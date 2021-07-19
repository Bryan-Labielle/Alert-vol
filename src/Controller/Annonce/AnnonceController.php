<?php

namespace App\Controller\Annonce;

use App\Entity\Annonce;
use App\Entity\AnnonceImage;
use App\Form\AnnonceImageType;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use App\Repository\UserRepository;
use App\Service\ApiImages;
use App\Service\ApiTwitter;
use App\Service\ApiZipCode;
use App\Service\Slugify;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use DateTime;
use DateInterval;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Route("/annonce", name="annonce_")
 * @Assert\EnableAutoMapping()
 */
class AnnonceController extends AbstractController
{
    private ApiImages $apiImages;
    private Security $security;

    /**
     * AnnonceController constructor.
     * @param ApiImages $apiImages
     */
    public function __construct(ApiImages $apiImages, Security $security)
    {
        $this->apiImages = $apiImages;
        $this->security = $security;
    }

    /**
     * @Route("/", methods={"GET"}, name="index")
     * @param AnnonceRepository $annonceRepository
     * @return Response A response instance
     */
    public function index(AnnonceRepository $annonceRepository): Response
    {
        $annonces = $annonceRepository->findBy(
            ['status' => '1'],
            ['publishedAt' => 'DESC']
        );
        return $this->render('annonce/index.html.twig', [
            'apiImages' => $this->apiImages->getResponse(),
            'annonces' => $annonces,
            'count' => count($annonces),
            'queries' => [],
        ]);
    }

    /**
     * @Route("/new", methods={"GET","POST"}, name="new")
     * @param Request $request
     * @param Slugify $slugify
     * @param UserRepository $userRepository
     * @param ApiTwitter $apiTwitter
     * @return Response
     */
    public function new(
        Request $request,
        Slugify $slugify,
        UserRepository $userRepository,
        ApiTwitter $apiTwitter
    ): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $annonce = new Annonce();
        $start = new DateTime();
        $end = new DateTime();
        $end->add(new DateInterval('P30D'));
        $annonce->setSlug('-');
        /**
         * @TODO: remplacer le status par 0 une fois le process de modération créé
         */
        $annonce->setStatus(0);
        $annonce->setPublishedAt($start);
        $annonce->setEndPublishedAt($end);
        $annonce->setOwner($this->security->getUser());

        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonce->setSlug($slugify->generate($annonce->getTitle()));

            $entityManager->persist($annonce);
            $entityManager->flush();
            //TODO update template
           /* $title = $annonce->getTitle();
            $description = $annonce->getDescription();
            $url = $_SERVER['HTTP_ORIGIN'] . '/annonce/' . $annonce->getSlug();
            $hashtag = trim($title);
            $apiTwitter->post(
                "Une nouvelle annonce à été publiée :" . PHP_EOL .
                $url . PHP_EOL .
                $title . PHP_EOL .
                $description . PHP_EOL .
                "#" . $hashtag . " #Alertvol #Khiko "
            );*/
            $this->addFlash('success', 'Votre annonce est enregistrée, ajoutez des images.');
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

        // upload file form
        $annonceImage = new AnnonceImage();
        $annonceImage->setAnnonce($annonce);
        $formUpload = $this->createForm(AnnonceImageType::class, $annonceImage);
        $formUpload->handleRequest($request);

        if ($formUpload->isSubmitted() && $formUpload->isValid()) {
            $annonceImage->setPostedAt(new DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonceImage);
            $annonce->setNbRenew($annonce->getNbRenew() + 1);
            $entityManager->flush();

            return $this->redirectToRoute('annonce_edit', [
                'slug' => $annonce->getSlug(),
            ]);
        }
        $detail = new Details();
        $annonce->addDetail($detail);
        $form = $this->createForm(AnnonceType::class, $annonce);
        return $this->render('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
            'formUpload' => $formUpload->createView(),
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

            return $this->redirectToRoute('annonce_edit', [
            'slug' => $annonce->getSlug(),
                ]);
        }
        // upload file form
        $annonceImage = new AnnonceImage();
        $annonceImage->setAnnonce($annonce);
        $formUpload = $this->createForm(AnnonceImageType::class, $annonceImage);
        $formUpload->handleRequest($request);

        if ($formUpload->isSubmitted() && $formUpload->isValid()) {
            $annonceImage->setPostedAt(new DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonceImage);
            $annonce->setNbRenew($annonce->getNbRenew() + 1);
            $entityManager->flush();

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
        $url = $_SERVER['HTTP_REFERER'] . $annonce->getSlug();
        $title = $annonce->getTitle();
        $hashtag = trim($title);
        $apiTwitter->post($url);
        dump($annonce);
        dump($_SERVER);
        return $this->render('annonce/show.html.twig', [
            'apiImages' => $this->apiImages->getResponse(),
            'annonce' => $annonce,
            'url' => $url,
            'hashtag' => $hashtag
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
     * @Route("/{slug}/edit/{id}", methods={"POST"}, name="deleteImage")
     * @ParamConverter("annonce", class="App\Entity\Annonce", options={"mapping": {"slug": "slug"}})
     * @ParamConverter("annonceImage", class="App\Entity\AnnonceImage", options={"mapping": {"id": "id"}})
     * @param Request $request
     * @param AnnonceImage $annonceImage
     * @return Response
     */
    public function deleteImage(Request $request, AnnonceImage $annonceImage): Response
    {
        $slug = $annonceImage->getAnnonce()->getSlug();
        if ($this->isCsrfTokenValid('delete' . $annonceImage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($annonceImage);
            $entityManager->flush();
        }
        return $this->redirectToRoute('annonce_edit', ['slug' => $slug]);
    }

    /**
     * @Route("/annonce/{id}/bookmark", name="bookmark", methods={"GET", "POST"})
     * @IsGranted("ROLE_USER")
     */
    public function addToBookmarks(Annonce $annonce, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if ($user !== null) {
            if ($user->isInBookmarks($annonce) === true) {
                $user->removeBookmark($annonce);
                $this->addFlash('danger', 'Cette annonce a été retirée de vos favoris');
            } else {
                $user->addToBookmarks($annonce);
                $entityManager->persist($annonce);
                $this->addFlash('success', 'Cette annonce a été ajoutée à vos favoris');
            }
        }
        $entityManager->flush();
        return $this->json([
            'isInBookmarks' => $user->isInBookmarks($annonce)
        ], '200', [], ['groups' => 'bookmarks']);
    }
}
