<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Serializer\Encoder\JsonEncoder;


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
        $annonces = $annonceRepository->findAll();
        dump($annonces);

        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }

    /**
     * @Route("/new", methods={"GET","POST"}, name="new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $annonce = new Annonce();

        $form = $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();


            $annonce->setOwner('user_test');
            $annonce->setStatus('pending');
            $annonce->setNbRenew('0');
            $annonce->setCategory('1');


            $location = array(
                'adresse' => "rue daumesnil 75012 paris"
            );
            $jsonEncoder = new JsonEncoder();
            $annonce->setLocation($jsonEncoder->encode($location, $format = 'json'));

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
     * Show details on an annonce
     *
     * @Route("/{id}", methods={"GET"}, name="show")
     * @ParamConverter("annonce", class="App\Entity\Annonce", options={"mapping": {"id": "id"}})
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
     * Edit details on an annonce
     *
     * @Route("/{id}/edit", methods={"GET", "POST"}, name="edit")
     * @ParamConverter("annonce", class="App\Entity\Annonce", options={"mapping": {"id": "id"}})
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


            $nbRenew = ($annonce->getNbRenew() + 1);
            $annonce->setNbRenew($nbRenew);

            return $this->redirectToRoute('annonce_index');
        }

        return $this->render('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", methods={"DELETE"}, name="delete")
     * @ParamConverter("annonce", class="App\Entity\Annonce", options={"mapping": {"id": "id"}})
     * @param Request $request
     * @param Annonce $annonce
     * @return Response
     */
    public function delete(Request $request, Annonce $annonce): Response
    {
        if ($this->isCsrfTokenValid('delete' . $annonce->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('annonce_index');
    }
}
