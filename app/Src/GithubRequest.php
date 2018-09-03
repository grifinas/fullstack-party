<?php

namespace App\Src;

use App\Src\Contracts\IssueInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;


class GithubRequest extends ProviderRequest
{
    const BASE_URL = 'https://api.github.com';

    protected $client_id;
    protected $client_secret;

    protected $access_token;

    function __construct(string $access_token = null)
    {
        $this->client_id = env('GITHUB_OAUTH_CLIENT_ID');
        $this->client_secret = env('GITHUB_OAUTH_CLIENT_SECRET');

        $this->access_token = $access_token;

        parent::__construct([
            'http_errors' => false
        ]);
    }


    public function getIssues() : ?array
    {
        return $this->request('GET', '/issues', [
            'query' => [
                'state' => 'all',
                'filter' => 'all',
            ]
        ]);
    }

    public function getIssue(string $user_name, string $repo_name, int $number) : ?array
    {
        return $this->request('GET', "/repos/$user_name/$repo_name/issues/$number");
    }

    public function getAccessToken(string $code)
    {
        return $this->request('POST', 'https://github.com/login/oauth/access_token', [
            RequestOptions::JSON => [
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'code' => $code,
            ],
        ]);
    }

    public function request($method, $url = '', array $options = []) : ?array
    {
        if ($url == '') {
            return null;
        }

        $options['Accept'] = 'application/vnd.github.v3+json';

        if ($this->access_token) {
            if (!isset($options['query'])) {
                $options['query'] = [];
            }

            $options['query']['access_token'] = $this->access_token;
        }

        if (!starts_with($url, 'http')) {
            $url = $this::BASE_URL . ($url[0] == '/' ? $url : "/$url");
        }

        // dump($url, $options);
        $response = parent::request($method, $url, $options);

        $body = $response->getBody()->getContents();

        if ($result = json_decode($body, true)) {
            return $result;
        }

        //For some reson github.com/login/oauth/access_token returns xform not json
        //TODO check why
        parse_str($body, $body);

        return $body;
    }
}
