<?php

declare(strict_types=1);

namespace App\Helper;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Serializer\GitHubSerializer;

class GitHubHelper
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly GitHubSerializer $serializer
    ) {
    }

    public function searchRepos(): ArrayCollection
    {
        $url = 'https://api.github.com/search/repositories?q=language:php&sort=stars&order=desc&per_page=100&page=1';
        $response = $this->client->request(
            'GET',
            $url,
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]
        );

        $items = $response->toArray()['items'];

        $return = new ArrayCollection();

        foreach ($items as $item) {
            // denormalize each item into GitHub entity
            $github = $this->serializer->denormalizeEntity($item);
            $return->add($github);
        }

        return $return;
    }
}
