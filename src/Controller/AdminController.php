<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AnnonceRepository;
use App\Repository\CategoryRepository;
use App\Repository\MessageRepository;
use App\Repository\SignalementRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/annonces", name="admin_annonces")
     */
    public function manageAnnonces(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('admin/_adminAnnonces.html.twig', [
            'annonces' => $annonceRepository->findByStatus('0')
        ]);
    }

    /**
     * @param CategoryRepository $categoryRepository
     * @return Response
     * @Route("/admin/categories", name="admin_categories")
     */
    public function manageCategories(CategoryRepository $categoryRepository): Response
    {

        return $this->render('admin/_adminCategories.html.twig', [
            'categories' => $categoryRepository->findAll()
        ]);
    }

    /**
     * @param SignalementRepository $signalementRepo
     * @return Response
     * @Route("/admin/signalements", name="admin_signalements")
     */
    public function manageSignalements(SignalementRepository $signalementRepo): Response
    {
        return $this->render('admin/_adminSignalements.html.twig', [
            'signalements' => $signalementRepo->findAll()
        ]);
    }

    /**
     * @param UserRepository $userRepository
     * @return Response
     * @Route("/admin/users", name="admin_users")
     */
    public function managerUsers(UserRepository $userRepository): Response
    {
        return $this->render('admin/_adminUsers.html.twig', [
            'users' => $userRepository->findAll()
        ]);
    }

    /**
     * @param User $user
     * @param Request $request
     * @return Response
     * @Route("/admin/user/{id}/delete", name="admin_deleteUser")
     */
    public function deleteUser(User $user, Request $request): Response
    {
        {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }
            return $this->redirectToRoute('admin');
        }
    }
}
