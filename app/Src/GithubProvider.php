<?php

namespace App\Src;

use App\Src\Contracts\IssueInterface;
use Illuminate\Support\Carbon;


class GithubProvider extends DataProvider implements IssueInterface
{
    /**
     * An abstraction of guzzle client tied to a specific user
     * Intended to get requests from GithubApi
     *
     * @var GithubRequest
     */
    protected $client;

    function __construct(GithubRequest $request)
    {
        $this->client = $request;
    }

    /**
     * Gets an array of all users' issues in all their states
     *
     * @todo An issue should be a sepparate object
     *
     * @return array issues belonging to the user
     */
    public function getIssues() : array
    {
        $issues = $this->client->getIssues() ?: [];

        foreach ($issues as &$issue) {
            $issue['created_from_now'] = Carbon::parse($issue['created_at'])->diffForHumans();
            $issue['inspect_url'] = route('issue', [
                'user' => array_get($issue, 'repository.owner.login'),
                'name' => array_get($issue, 'repository.name'),
                'number' => $issue['number'],
            ]);
        }

        return $issues;
    }

    /**
     * Gets details of a single users' issue
     *
     * @todo Issue transformations repeated and copied
     * @todo Issue should be a sepparate object, that this function returns
     *
     * @param string $user_name The owners' username to whom the repository and issues belong to
     * @param string $repo_name The repository to whom the issue belongs to
     * @param int $number The issue number unique only in the scope of repository
     *
     * @return array Data of the issue queried
     */
    public function getIssue(string $user_name, string $repo_name, int $number) : array
    {
        $issue = $this->client->getIssue($user_name, $repo_name, $number) ?: [];
        $issue['created_from_now'] = Carbon::parse($issue['created_at'])->diffForHumans();
        $issue['comments_content'] = [];
        if (array_get($issue, 'comments')) {
            $issue['comments_content'] = $this->client->request('GET', array_get($issue, 'comments_url'));
        }

        return $issue;
    }
}
