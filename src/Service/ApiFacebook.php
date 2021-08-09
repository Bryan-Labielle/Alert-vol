<?php

namespace App\Service;

use App\Entity\Annonce;
use MartinGeorgiev\SocialPost\Message;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ApiFacebook
{
    private ContainerInterface $container;

    /**
     * ApiFacebook constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     */
    public function postArticle(Annonce $annonce): void
    {
        $message = "Une nouvelle annonce vient d'être publiée sur Alert'Vol";
        $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") .
            "://$_SERVER[HTTP_HOST]" . "/annonce/" . $annonce->getSlug();
        if ($annonce->getAnnonceImages()[0]) {
            $image = $annonce->getAnnonceImages()[0]->getName();
        }
        $caption = $annonce->getTitle();
        $description = $annonce->getDescription() ?? '';

        $article = new Message(
            $message,
            $link,
            $image ?? '',
            $caption,
            $description,
        );
        $this->container->get('social_post')->publish($article);
    }
}
