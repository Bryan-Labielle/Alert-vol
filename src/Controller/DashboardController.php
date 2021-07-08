<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\User;

/**
 * @Route("/dashboard", name="dashboard_")
 */
class DashboardController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig');
    }
    /**
     * @Route("profil", name="profil")
     */
    public function profil(): Response
    {
        return $this->render('dashboard/_profil.html.twig');
    }
}
