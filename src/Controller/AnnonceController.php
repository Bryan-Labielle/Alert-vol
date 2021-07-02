<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\AnnonceImage;
use App\Entity\User;
use App\Form\AnnonceImageType;
use App\Repository\AnnonceImageRepository;
use App\Repository\AnnonceRepository;
use App\Repository\UserRepository;
use App\Service\ApiImages;
use App\Service\ApiZipCode;
use App\Service\Slugify;
use App\Form\AnnonceType;
use ContainerJUlAk0t\getUserRepositoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use DateTime;
use DateInterval;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Route("/annonce", name="annonce_")
 * @Assert\EnableAutoMapping()
 */
class AnnonceController extends AbstractController
{
    private ApiImages $apiImages;

    /**
     * AnnonceController constructor.
     * @param ApiImages $apiImages
     */
    public function __construct(ApiImages $apiImages)
    {
        $this->apiImages = $apiImages;
    }

    /**
     * @Route("/", methods={"GET"}, name="index")
     * @param AnnonceRepository $annonceRepository
     * @return Response A response instance
     */
    public function index(AnnonceRepository $annonceRepository): Response
    {
        $annonces = $annonceRepository->findByStatus('1');
        return $this->render('annonce/index.html.twig', [
            'apiImages' => $this->apiImages->getResponse(),
            'annonces' => $annonces,
            'count' => count($annonces),
        ]);
    }

    /**
     * @Route("/new", methods={"GET","POST"}, name="new")
     * @param Request $request
     * @param Slugify $slugify
     * @param UserRepository $userRepository
     * @return Response
     */
    public function new(
        Request $request,
        Slugify $slugify,
        UserRepository $userRepository
    ): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $annonce = new Annonce();
        $start = new DateTime();
        $end = $start->add(new DateInterval('P30D'));
        $annonce->setSlug('-');
        /**
         * @TODO: remplacer le status par 0 une fois le process de modération créé
         */
        $annonce->setStatus(1);
        $annonce->setPublishedAt($start);
        $annonce->setEndPublishedAt($end);
        /**
         * @TODO: remplacer par l'utilisateur connecté
         */
        $annonce->setOwner($this->getUser());

        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonce->setSlug($slugify->generate($annonce->getTitle()));

            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('annonce_edit', ['slug' => $annonce->getSlug()]);
        }
        // créer formulaire séparer pour ajouter plusieurs signes distinctifs en ajax
        /**
         * @TODO: créer le champs actif dans le formulaire
         */
        $annonce->setDetails([
            'peinture' => 'rouge',
            'date_achat' => '2019',
            'defaults' => 'rayures aile gauche'
        ]);

        return $this->render('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/autocomplete-zip", name="autocomplete-zip", methods={"GET"})
     * @param Request $request
     * @param ApiZipCode $apiZipCode
     * @return Response
     */
    public function apiZip(Request $request, ApiZipCode $apiZipCode): Response
    {
        $zip = $request->query->get('search');
        return $this->json($apiZipCode->autocompleteZip($zip) ?? []);
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
        // annonce form
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $annonce->setNbRenew($annonce->getNbRenew() + 1);

            return $this->redirectToRoute('annonce_index');
        }
        // upload file form
        $annonceImage = new AnnonceImage();
        $annonceImage->setAnnonce($annonce);
        $formUpload = $this->createForm(AnnonceImageType::class, $annonceImage);
        $formUpload->handleRequest($request);

        if ($formUpload->isSubmitted() && $formUpload->isValid()) {
            $annonceImage->setPostedAt(new DateTime('now'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonceImage);
            $annonce->setNbRenew($annonce->getNbRenew() + 1);
            $em->flush();


            return $this->redirectToRoute('annonce_edit', [
                'slug' => $annonce->getSlug(),
                ]);
        }

        return $this->render('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
            'formUpload' => $formUpload->createView(),
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
            'apiImages' => $this->apiImages->getResponse(),
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

    /**
     * @Route("/{id}", methods={"POST"}, name="deleteImage")
     * @ParamConverter("annonceImage", class="App\Entity\AnnonceImage", options={"mapping": {"id": "id"}})
     * @param Request $request
     * @param AnnonceImage $annonceImage
     * @return Response
     */
    public function deleteImage(Request $request, AnnonceImage $annonceImage): Response
    {
        $annonce = $annonceImage->getAnnonce();
        if ($this->isCsrfTokenValid('delete' . $annonceImage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $annonceImage = $entityManager->getRepository(AnnonceImage::class)->find($annonceImage->getId());
            $entityManager->remove($annonceImage);
            $entityManager->flush();
        }
        return $this->redirectToRoute('annonce_edit', [
            'annonce' => $annonce,
            'slug' => $annonce->getSlug()
        ]);
    }
}
