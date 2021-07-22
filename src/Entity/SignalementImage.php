<?php

namespace App\Entity;

use App\Repository\SignalementImageRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=SignalementImageRepository::class)
 * @Vich\Uploadable
 */
class SignalementImage
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
     * @Vich\UploadableField(mapping="signalement_file", fileNameProperty="name")
     * @var ?File
     */
    private ?File $signalementFile = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $postedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Signalement::class, inversedBy="signalementImages")
     */
    private ?Signalement $signalement;

    public function __construct()
    {
        $this->postedAt = new DateTime("now");
    }


    public function getId(): ?int
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

    public function getSignalement(): ?Signalement
    {
        return $this->signalement;
    }

    public function setSignalement(?Signalement $signalement): self
    {
        $this->signalement = $signalement;

        return $this;
    }
    public function getSignalementFile(): ?File
    {
        return $this->signalementFile;
    }
    public function setSignalementFile(?File $signalementFile = null): self
    {
        $this->signalementFile = $signalementFile;
        if ($signalementFile) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }
}
