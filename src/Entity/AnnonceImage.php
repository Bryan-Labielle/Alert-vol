<?php

namespace App\Entity;

use App\Repository\AnnonceImageRepository;
use Symfony\Component\HttpFoundation\File\File;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
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
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @Vich\UploadableField(mapping="image_file", fileNameProperty="name")
     * @var ?File
     */
    private ?File $imageFile;

    /**
     * @ORM\ManyToOne(targetEntity=annonce::class, inversedBy="annonceImages")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Annonce $annonce;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTime $postedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTime $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
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

    public function getPostedAt(): ?DateTime
    {
        return $this->postedAt;
    }

    public function setPostedAt(DateTime $postedAt): self
    {
        $this->postedAt = $postedAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): self
    {
        $this->imageFile = $imageFile;
        if ($imageFile) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
}
