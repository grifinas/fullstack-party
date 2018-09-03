<?php

namespace App\Src;

use App\Src\Contracts\IssueInterface;
use Illuminate\Support\Carbon;


class GithubProvider extends DataProvider implements IssueInterface
{
    /**
     * @var GithubRequest
     */
    protected $client;

    function __construct(GithubRequest $request)
    {
        $this->client = $request;
    }

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

    public function getIssue(string $user_name, string $repo_name, int $number) : array
    {
        $issue = $this->client->getIssue($user_name, $repo_name, $number) ?: [];
        $issue['created_from_now'] = Carbon::parse($issue['created_at'])->diffForHumans();
        if (array_get($issue, 'comments')) {
            $issue['comments_content'] = $this->client->request('GET', array_get($issue, 'comments_url'));
        }

        return $issue;
    }
}
