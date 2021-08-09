<?php

namespace App\Controller;

use App\Form\SearchForm;
use App\Repository\AnnonceRepository;
use App\Service\ApiImages;
use App\Service\SearchData;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FilterController extends AbstractController
{
    /**
     * @Route("/filter", name="filter")
     * @param Request $request
     * @param AnnonceRepository $annonceRepository
     * @param ApiImages $apiImages
     * @return Response
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function index(
        Request $request,
        AnnonceRepository $annonceRepository,
        ApiImages $apiImages,
        PaginatorInterface $paginator
    ): Response {
        $querySimple = $request->query->get('search');
        $queryDate = $request->query->get('dateSearch');
        if (!empty($queryDate)) {
            $queryDate = new DateTime($queryDate . '+1 days');
            $queryDate = $queryDate->format('Y-m-d H:i:s');
        }
        $queryPlace = $request->query->get('placeSearch');
        $query = [
            'querySimple' => $querySimple,
            'queryDate' => $queryDate,
            'queryPlace' => $queryPlace];

        dump($query);
        if (!empty($query)) {
            $annonces = $annonceRepository->findByCompleteQuery(
                $query['querySimple'],
                $query['queryDate'],
                $query['queryPlace']
            );
        }
        $annonces = $annonces ?? [];

        $pagination = $paginator->paginate(
            $annonces,
            $request->query->getInt('page', 1),
            6,
            [],
        );

        $queries = [$queryDate, $queryPlace, $querySimple];
        return $this->render('annonce/index.html.twig', [
            'annonces' => $pagination,
            'count' => count($annonces),
            'apiImages' => $apiImages->getResponse(),
            'queries' => $queries,
        ]);
    }
}
