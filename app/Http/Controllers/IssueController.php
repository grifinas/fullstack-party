<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Src\GithubRequest;
use App\Src\GithubProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use App\Src\Contracts\IssueInterface;

class IssueController extends Controller
{
    /**
     * @var IssueInterface
     */
    protected $provider;

    public function getIndex(Request $request)
    {
        $issues = $this->getProvider()->getIssues();

        return view('issues', [
            'issues' => $issues,
        ]);
    }

    public function getIssue($user, $name, $number)
    {
        $issue = $this->getProvider()->getIssue($user, $name, $number);

        return view('issue', [
            'issue' => $issue
        ]);
    }

    protected function getProvider() : IssueInterface
    {
        if ($this->provider) {
            return $this->provider;
        }

        $request = new GithubRequest(session('token'));

        return $this->provider = new GithubProvider($request);
    }
}
