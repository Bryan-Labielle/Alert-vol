<?php

namespace App\Controller\Annonce;

use App\Entity\Annonce;
use App\Entity\Message;
use App\Entity\Signalement;
use App\Entity\SignalementImage;
use App\Form\Signalement\MessageType;
use App\Form\Signalement\NewSignalementType;
use App\Form\Signalement\SignalementImageType;
use App\Form\Signalement\SignalementType;
use App\Service\ApiImages;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class SignalementController
 * @package App\Controller\Annonce
 * @Route("/signalement", name="signalement_")
 */
class SignalementController extends AbstractController
{
    private ApiImages $apiImages;
    private EntityManagerInterface $entityManager;
    private Security $security;

    /**
     * AnnonceController constructor.
     * @param ApiImages $apiImages
     */
    public function __construct(ApiImages $apiImages, EntityManagerInterface $entityManager, Security $security)
    {
        $this->apiImages = $apiImages;
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    /**
     * @Route("/{slug}", methods={"POST", "GET"}, name="new")
     * @IsGranted("ROLE_USER")
     * @param Annonce $annonce
     * @param Request $request
     * @return Response
     */
    public function newSignalement(
        Annonce $annonce,
        Request $request
    ): Response {

        //TODO configure timezone
        $date = new DateTime('now');

        /**
         * new signalement
         */
        $signalement = new Signalement();
        $signalement->setSeenOn($date);
        $signalement->setSendAt($date);
        // @todo handle longitude & latitude
        $signalement->setLongitude(1.1);
        $signalement->setLatitude(2.2);
        $signalement->setAnnonce($annonce);
        $signalement->setOwner($this->security->getUser());

        /**
         * create the signalement form
         */
        $form = $this->createForm(NewSignalementType::class, $signalement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $messages = $form->getData()->getMessages();
            if ($messages) {
                foreach ($messages as $message) {
                    $message->setSentAt($date);
                    $message->setRecipient($annonce->getOwner());
                    $message->setSender($this->getUser());
                    $signalement->addMessage($message);
                }
            }

            $signalement->setDetails($request->request->get('details') ?? []);
            $this->entityManager->persist($signalement);
            $this->entityManager->flush();
            //TODO modifier message flash
            $this->addFlash('success', "Merci pour votre aide");

            return $this->redirectToRoute('signalement_edit', [
                'slug' => $annonce->getSlug(),
                'id' => $signalement->getId()
            ]);
        }

        /**
         * add empty image to the signalement form
         */
        $signalementImage = new SignalementImage();
        $signalement->addSignalementImage($signalementImage);

        /**
         * add empty message to the signalement form
         */
        $message = new Message();
        $signalement->addMessage($message);
        $form = $this->createForm(NewSignalementType::class, $signalement);
        return $this->render('signalement/new.html.twig', [
            'annonce' => $annonce,
            'signalement' => $signalement,
            'apiImages' => $this->apiImages->getResponse(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Annonce $annonce
     * @param Signalement $signalement
     * @param Request $request
     * @return Response
     * @Route("/{slug}/{id}/edit", name="edit")
     * @ParamConverter("annonce", options={"mapping": {"slug": "slug"}})
     * @ParamConverter("signalement", options={"mapping": {"id": "id"}})
     */
    public function edit(Annonce $annonce, Signalement $signalement, Request $request): Response
    {
        $user = $this->getUser();
        //TODO configure timezone
        $date = new DateTime('now');

        $subject = (object)[
            'annonce' => $annonce,
            'signalement' => $signalement
        ];
        /**
         * Check if user is signalementOwner or annonceOwner
         * if not: deny access. @todo see src/Security/SignalementOwnerVoter.php
         */
        $this->denyAccessUnlessGranted('ROLE_SIGNALEMENT', $subject);

        /**
         * create signalement form to be modified
         */
        $form = $this->createForm(SignalementType::class, $signalement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $user === $signalement->getOwner()) {
            $signalement->setDetails($request->request->get('details') ?? []);
            $this->entityManager->flush();
            $this->addFlash('success', "Votre signalement a bien été mis à jour");
            return $this->redirectToRoute('signalement_edit', [
                'slug' => $annonce->getSlug(),
                'id' => $signalement->getId()
            ]);
        }

        /**
         * create message form to be added if needed and handle it if submitted
         */
        $message = new Message();
        $message->setSentAt($date);
        $message->setSender($user);
        $recipient = $user === $annonce->getOwner() ? $signalement->getOwner() : $annonce->getOwner();
        $message->setRecipient($recipient);
        $formNewMessage = $this->createForm(MessageType::class, $message);
        $formNewMessage->handleRequest($request);
        if ($formNewMessage->isSubmitted() && $formNewMessage->isValid()) {
            $signalement->addMessage($message);
            $this->entityManager->persist($message);
            $this->entityManager->flush();
            $this->addFlash('success', "Votre message a bien été envoyé");
            return $this->redirectToRoute('signalement_edit', [
                'slug' => $annonce->getSlug(),
                'id' => $signalement->getId()
            ]);
        }

        return $this->render('signalement/edit.html.twig', [
            'annonce' => $annonce,
            'signalement' => $signalement,
            'form' => $form->createView(),
            'formNewMessage' => $formNewMessage->createView(),
            'apiImages' => $this->apiImages->getResponse(),
        ]);
    }
}
