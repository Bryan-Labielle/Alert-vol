<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiZipCode
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }


    public function autocompleteZip(?string $commune): array
    {
            $response = $this->client->request(
                'GET',
                'https://geo.api.gouv.fr/communes?nom=' . $commune . '&fields=departement&boost=population&limit=5',
            );

        return $response->toArray();
    }
}
