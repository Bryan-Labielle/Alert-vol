<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\User;
use App\Repository\AnnonceRepository;
use App\Service\Slugify;
use App\Form\AnnonceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use DateTime;
use DateInterval;

/**
 * @Route("/annonce", name="annonce_")
 */
class AnnonceController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="index")
     * @param AnnonceRepository $annonceRepository
     * @return Response A response instance
     */
    public function index(AnnonceRepository $annonceRepository): Response
    {
        $annonces = $annonceRepository->findByStatus('2');
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
            'count' => count($annonces),
        ]);
    }

    /**
     * @Route("/new", methods={"GET","POST"}, name="new")
     * @param Request $request
     * @param Slugify $slugify
     * @return Response
     */
    public function new(Request $request, Slugify $slugify): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $annonce = new Annonce();
        $start = new DateTime();
        $end = $start->add(new DateInterval('P30D'));
        $annonce->setSlug('-');
        /**
         * @TODO: remplacer le status par 1 une fois le process de modération créé
         */
        $annonce->setStatus(2);
        $annonce->setPublishedAt($start);
        $annonce->setEndPublishedAt($end);
        /**
         * @TODO: remplacer par l'utilisateur connecté
         */
        $annonce->setOwner($entityManager->getRepository(User::class)->findOneByRole(rand(1, 3)));
        /**
         * @TODO: créer le champs actif dans le formulaire
         */
        $annonce->setDetails([
            'peinture' => 'rouge',
            'date_achat' => '2019',
            'defaults' => 'rayures aile gauche'
        ]);

        $form = $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonce->setSlug($slugify->generate($annonce->getTitle()));

            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('annonce_index');
        }

        return $this->render('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edit details on an annonce
     *
     * @Route("/{slug}/edit", methods={"GET", "POST"}, name="edit")
     * @ParamConverter("annonce", class="App\Entity\Annonce", options={"mapping": {"slug": "slug"}})
     * @param Request $request
     * @param Annonce $annonce
     * @return Response
     */
    public function edit(Request $request, Annonce $annonce): Response
    {
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $annonce->setNbRenew($annonce->getNbRenew() + 1);

            return $this->redirectToRoute('annonce_index');
        }

        return $this->render('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Show details on an annonce
     *
     * @Route("/{slug}", methods={"GET"}, name="show")
     * @ParamConverter("annonce", class="App\Entity\Annonce", options={"mapping": {"slug": "slug"}})
     * @param Annonce $annonce
     * @return Response
     */
    public function show(Annonce $annonce): Response
    {
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    /**
     * @Route("/{slug}", methods={"POST"}, name="delete")
     * @ParamConverter("annonce", class="App\Entity\Annonce", options={"mapping": {"slug": "slug"}})
     * @param Request $request
     * @param Annonce $annonce
     * @return Response
     */
    public function delete(Request $request, Annonce $annonce): Response
    {
        if ($this->isCsrfTokenValid('delete' . $annonce->getSlug(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $annonce->setStatus(3);
            $entityManager->persist($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('annonce_index');
    }
}
