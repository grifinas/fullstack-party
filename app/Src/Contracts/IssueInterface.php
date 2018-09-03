<?php

namespace App\Src\Contracts;

interface IssueInterface
{
    public function getIssues() : array;

    public function getIssue(string $user_name, string $repo_name, int $number) : array;
}
