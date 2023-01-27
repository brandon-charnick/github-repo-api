<?php

declare(strict_types=1);

namespace App\Helper;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GitHubHelper
{
    public function __construct(
        private readonly HttpClientInterface $client
    ) {
    }

    public function searchRepos()
    {
        $url = 'https://api.github.com/search/repositories?q=language:php&sort=stars&order=desc&per_page=10&page=1';
        $response = $this->client->request('GET', $url);

        return $response->toArray();
    }
}
