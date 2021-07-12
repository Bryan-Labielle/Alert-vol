<?php

namespace App\Controller;

use App\Repository\SignalementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\User;

/**
 * @Route("/dashboard", name="dashboard_")
 */
class DashboardController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    private EntityManagerInterface $entityManager;

    /**
     * DashboardController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig');
    }
    /**
     * @Route("/profil", name="profil")
     */
    public function profil(): Response
    {
        return $this->render('dashboard/_profil.html.twig');
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
