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
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;
    /**
     * @Vich\UploadableField(mapping="signalement_file", fileNameProperty="name")
     * @var ?File
     */
    private ?File $signalementFile ;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $posted_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Signalement::class, inversedBy="signalementImages")
     */
    private ?Signalement $signalement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPostedAt(): ?DateTime
    {
        return $this->posted_at;
    }

    public function setPostedAt(DateTime $posted_at): self
    {
        $this->posted_at = $posted_at;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTime $updated_at): self
    {
        $this->updated_at = $updated_at;

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
            $this->updated_at = new DateTime('now');
        }
        return $this;
    }
}
