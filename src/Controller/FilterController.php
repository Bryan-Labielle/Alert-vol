<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use App\Service\ApiImages;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FilterController extends AbstractController
{
    /**
     * @Route("/filter", name="filter")
     */
    public function index(Request $request, AnnonceRepository $annonceRepository, ApiImages $apiImages): Response
    {
        $querySimple = $request->query->get('search');
        $queryDate = $request->query->get('dateSearch');
        if (!empty($queryDate)) {
            $queryDate = new DateTime($queryDate);
            $queryDate = $queryDate->format('Y-m-d');
        }
        $queryPlace = $request->query->get('placeSearch');
        dump($querySimple);
        dump($queryDate);
        dump($queryPlace);
        if (!empty($querySimple)) {
            $annonces = $annonceRepository->findByQuery($querySimple);
        }
        if (!empty($queryDate)) {
            $annonces = $annonceRepository->findByDate($queryDate);
        }
        if (!empty($queryPlace)) {
            $annonces = $annonceRepository->findByQueryPlace($queryPlace);
        }
        $annonces = $annonces ?? [];
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
            'count' => count($annonces),
            'apiImages' => $apiImages->getResponse(),
        ]);
    }
}
