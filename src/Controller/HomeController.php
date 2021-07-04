<?php

namespace App\Controller;

use App\Service\ApiImages;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="app_")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param ApiImages $apiImages
     * @return Response
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function index(ApiImages $apiImages): Response
    {
        $response = $apiImages->getResponse();
        dump($response);
        return $this->render('home/index.html.twig', [
            'response' => $response,
            'random' => rand(1, 20),
        ]);
    }
}
