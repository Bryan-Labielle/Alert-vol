<?php

namespace App\Entity;

use App\Repository\SignalementRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SignalementRepository::class)
 * @Assert\EnableAutoMapping()
 */
class Signalement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private array $details = [];

    /**
     * @ORM\ManyToOne(targetEntity=Annonce::class, inversedBy="signalements")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Annonce $annonce;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $sendAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $seenOn;

    /**
     * @ORM\Column(type="float")
     */
    private float $latitude;

    /**
     * @ORM\Column(type="float")
     */
    private float $longitude;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="signalement",  cascade={"persist", "remove"})
     */
    private Collection $messages;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private ?User $owner;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $image;

    /**
     * @ORM\OneToMany(targetEntity=SignalementImage::class, mappedBy="signalement")
     */
    private $signalementImages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->signalementImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDetails(): ?array
    {
        return $this->details;
    }

    public function setDetails(array $details): self
    {
        $this->details = $details;

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

    public function getSendAt(): \DateTimeInterface
    {
        return $this->sendAt;
    }

    public function setSendAt(DateTime $sendAt): self
    {
        $this->sendAt = $sendAt;

        return $this;
    }

    public function getSeenOn(): DateTime
    {
        return $this->seenOn;
    }

    public function setSeenOn(DateTime $seenOn): self
    {
        $this->seenOn = $seenOn;

        return $this;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setSignalement($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getSignalement() === $this) {
                $message->setSignalement(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|SignalementImage[]
     */
    public function getSignalementImages(): Collection
    {
        return $this->signalementImages;
    }

    public function addSignalementImage(SignalementImage $signalementImage): self
    {
        if (!$this->signalementImages->contains($signalementImage)) {
            $this->signalementImages[] = $signalementImage;
            $signalementImage->setSignalement($this);
        }

        return $this;
    }

    public function removeSignalementImage(SignalementImage $signalementImage): self
    {
        if ($this->signalementImages->removeElement($signalementImage)) {
            // set the owning side to null (unless already changed)
            if ($signalementImage->getSignalement() === $this) {
                $signalementImage->setSignalement(null);
            }
        }

        return $this;
    }
}
