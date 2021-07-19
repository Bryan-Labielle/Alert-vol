<?php

namespace App\Entity;

use App\Repository\AnnonceImageRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=AnnonceImageRepository::class)
 * @Vich\Uploadable
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */

    private ?string $name = null;

    /**
     * @Vich\UploadableField(mapping="annonce_file", fileNameProperty="name")
     * @var ?File
     */
    private ?File $annonceFile = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTime $postedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTime $updatedAt;

    /**
     * @return ?File
     */
    public function getAnnonceFile(): ?File
    {
        return $this->annonceFile;
    }

    /**
     * @param File|null $annonceFile
     * @return AnnonceImage
     */
    public function setAnnonceFile(?File $annonceFile = null): self
    {
        $this->annonceFile = $annonceFile;
        if ($annonceFile) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }
    /**
     * @ORM\ManyToOne(targetEntity=annonce::class, inversedBy="annonceImages")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Annonce $annonce;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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
    /**
     * @return ?DateTime
     */
    public function getPostedAt(): ?DateTime
    {
        return $this->postedAt;
    }
    /**
     * @param ?DateTime $postedAt
     * @return AnnonceImage
     */
    public function setPostedAt(?DateTime $postedAt): self
    {
        $this->postedAt = $postedAt;
        return $this;
    }

    /**
     * @return ?DateTime
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
