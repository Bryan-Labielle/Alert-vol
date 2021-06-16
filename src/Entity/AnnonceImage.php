<?php

namespace App\Entity;

use App\Repository\AnnonceImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnonceImageRepository::class)
 */
class AnnonceImage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $image;

    /**
     * @ORM\ManyToOne(targetEntity=annonce::class, inversedBy="annonceImages")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Annonce $annonce;

    public function getId(): int
    {
        return $this->id;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }
}
