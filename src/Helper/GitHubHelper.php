<?php

declare(strict_types=1);

namespace App\Helper;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Serializer\GitHubSerializer;

/**
 * https://docs.github.com/en/search-github/searching-on-github/searching-code
 */
class GitHubHelper
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly GitHubSerializer $serializer,
        private readonly string $gitHubSearchUrl
    ) {
    }

    public function searchRepos(int $perPage=10): ArrayCollection
    {
        $response = $this->client->request(
            'GET',
            $this->gitHubSearchUrl,
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'query' => [
                    'q' => 'language:php',
                    'sort' => 'stars',
                    'order' => 'desc',
                    'per_page' => $perPage
                ]
            ]
        );

        $items = $response->toArray()['items'];

        $repositories = new ArrayCollection();

        foreach ($items as $item) {
            // denormalize each item into GitHub entity
            $github = $this->serializer->denormalizeEntity($item);
            $repositories->add($github);
        }

        return $repositories;
    }
}
