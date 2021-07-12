<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ApiImages
{

    /**
     * @return array|null
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getResponse(): ?array
    {
        $statusCodeOk = 200;
        $client = HttpClient::create();
        $response = $client->request(
            'GET',
            'https://pixabay.com/api/?key=' . $_ENV['PIXABAY_KEY'] .
            '&q=vehicles&image_type=photo&min_width=500',
        );
        $statusCode = 0;
        try {
            $statusCode = $response->getStatusCode();
        } catch (TransportExceptionInterface $e) {
        }
        if ($statusCode === $statusCodeOk) {
            // $content = $response->getContent();
            // get the response in JSON format

            return $response->toArray();
            // convert the response (here in JSON) to an PHP array
        }
        return null;
    }
}
