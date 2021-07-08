<?php

namespace App\Controller\Annonce;

use App\Entity\Annonce;
use App\Entity\Message;
use App\Entity\Signalement;
use App\Entity\SignalementImage;
use App\Form\SignalementImageType;
use App\Form\SignalementType;
use App\Service\ApiImages;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

class SignalementController extends AbstractController
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
     * @Route("/{slug}/signalement", methods={"POST", "GET"}, name="signalement")
     * @param Annonce $annonce
     * @param Signalement $signalement
     * @param Request $request
     * @return Response
     */
    public function signalement(
        Annonce $annonce,
        Signalement $signalement,
        Request $request
    ): Response {

        $entityManager = $this->getDoctrine()->getManager();
        //TODO configure timezone   
        $date = new DateTime('now');
        
        $signalement->setSendAt($date);
        $signalement->setLongitude(1.1);
        $signalement->setLatitude(2.2);
        $signalement->setAnnonce($annonce);
        $signalement->setOwner($this->getUser());

        $form = $this->createForm(SignalementType::class, $signalement);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($signalement);
            $entityManager->flush();
            //TODO modifier message flash
            $this->addFlash('succes', "Merci pour votre aide");
            //TODO change redirect
            $this->redirectToRoute('annonce_index');
        }


        $signalementImage = new SignalementImage();
        $signalementImage->setSignalement($signalement);
        $formUpload = $this->createForm(SignalementImageType::class, $signalementImage);
        $formUpload->handleRequest($request);

        if ($formUpload->isSubmitted() && $formUpload->isValid()) {
            $signalementImage->setPostedAt($date);
            $entityManager->persist($signalementImage);
            $entityManager->flush();

            //TODO redirect sur page de confirmation d'envoi ?
            $this->redirectToRoute('annonce_index');
        }
        dump($formUpload);
        dump($form);

        return $this->render('signalement/signalement.html.twig', [
            'annonce' => $annonce,
            'signalement' => $signalement,
            'apiImages' => $this->apiImages->getResponse(),
            'form' => $form->createView(),
            'formUpload' => $formUpload->createView()
        ]);
    }
}
