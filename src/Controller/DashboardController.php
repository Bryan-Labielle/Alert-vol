<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use App\Service\ApiImages;
use App\Repository\SignalementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\User;

/**
 * @Route("/dashboard", name="dashboard_")
 */
class DashboardController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{

    private ApiImages $apiImages;
    private AnnonceRepository $annonceRepository;
    private Security $security;
    private EntityManagerInterface $entityManager;


    /**
     * AnnonceController constructor.
     * @param ApiImages $apiImages
     */
    public function __construct(
        ApiImages $apiImages,
        AnnonceRepository $annonceRepository,
        Security $security,
        EntityManagerInterface $entityManager
    ) {
        $this->apiImages = $apiImages;
        $this->annonceRepository = $annonceRepository;
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
        ]);
    }
    /**
     * @Route("/profil", name="profil")
     */
    public function profil(
        AnnonceRepository $annonceRepository,
        SignalementRepository $signalementRepo
    ): Response {
        $user = $this->getUser();
        return $this->render('dashboard/_profil.html.twig', [
            'countBookmark' => $user ? count($user->getBookmarks()) : '',
            'countAnnonce' => $user ? count($annonceRepository->findByOwner($user)) : '',
            'countSignalement' => $user ? count($signalementRepo->findByOwner($user)) : '',
            'lastSignalements' => $user ? $signalementRepo->findBy(
                ['owner' => $user],
                ['sendAt' => 'DESC'],
                '1',
            ) : '',
            'lastAnnonces' => $user ? $annonceRepository->findBy(
                ['owner' => $user,
                    'status' => '1'],
                ['publishedAt' => 'DESC'],
                '1',
            ) : ''
        ]);
    }

    /**
     * @Route("/mybookmarks", name="myBookmarks")
     */
    public function myBookmarks(): Response
    {
        $user = $this->getUser();
        return $this->render('dashboard/_myBookmarks.html.twig', [
            'annonces' => $user ? $user->getBookmarks() : '',
            'apiImages' => $this->apiImages->getResponse()
        ]);
    }

    /**
     * @Route("/myannounces", name="myAnnounces")
     */
    public function myAnnounces(): Response
    {
        return $this->render('dashboard/_myAnnounces.html.twig', [
            'annonces' => $this->security->getUser() ? $this->annonceRepository
                ->findByOwner($this->security->getUser()) : '',
            'apiImages' => $this->apiImages->getResponse()
        ]);
    }

    /**
     * @Route("/mes-signalements", name="mes_signalements")
     */
    public function signalements(SignalementRepository $signalementRepos): Response
    {
        $signalements = $signalementRepos->findBy(['owner' => $this->getUser()]);
        return $this->render('dashboard/_mes-signalements.html.twig', [
            'signalements' => $signalements
        ]);
    }
}
