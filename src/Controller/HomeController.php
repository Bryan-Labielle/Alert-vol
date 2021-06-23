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
     */
    public function index(): Response
    {
        $apiImages = new ApiImages();
        $response = $apiImages->getResponse();
        dump($response);
        return $this->render('home/index.html.twig', [
            'response' => $response,
            'random' => rand(1, 20),
        ]);
    }
}
