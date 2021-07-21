<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiZipCode
{

    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }


    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function autocompleteZip(?string $commune): array
    {
            $response = $this->client->request(
                'GET',
                'https://geo.api.gouv.fr/communes?nom=' . $commune . '&fields=code,nom,codesPostaux&limit=5',
                //https://geo.api.gouv.fr/communes?nom=' . $commune . '&fields=departement&boost=population&limit=5',
            );

        return $response->toArray();
    }
}
