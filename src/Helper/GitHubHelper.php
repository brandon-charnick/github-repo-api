<?php

declare(strict_types=1);

namespace App\Helper;

use App\Entity\GitHub;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * https://docs.github.com/en/rest/search?apiVersion=2022-11-28
 */
class GitHubHelper
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly SerializerInterface $serializer,
        private readonly string $gitHubSearchUrl
    ) {
    }

    public function searchRepositories(int $perPage = 10): ArrayCollection
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
            $item = json_encode($item);
            // deserialize each item into a GitHub entity
            $github = $this->serializer->deserialize($item, GitHub::class, 'json');
            $repositories->add($github);
        }

        return $repositories;
    }

    public function getRepository(GitHub $gitHub): string
    {
        $response = $this->client->request(
            'GET',
            $gitHub->getApiUrl(),
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]
        );

        return $response->getContent();
    }
}
