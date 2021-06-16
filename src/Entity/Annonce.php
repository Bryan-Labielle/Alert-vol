<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 * @Assert\EnableAutoMapping()
 */
class Annonce
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank(message="champ obligatoire")
     */
    private string $title;

    /**
     * @ORM\OneToMany(targetEntity=AnnonceImage::class, mappedBy="annonce")
     */
    private Collection $annonceImages;
    /**
     * @ORM\OneToMany(targetEntity=Signalement::class, mappedBy="annonce")
     */
    private Collection $signalements;

    /**
    public function getPublishedAt(): ?\Da
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $publishedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $nbRenew;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $endPublishedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Category $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $reference;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?User $owner;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $location;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private ?array $details = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $stolenAt;

    public function __construct()
    {
        $this->annonceImages = new ArrayCollection();
        $this->signalements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|AnnonceImage[]
     */
    public function getAnnonceImages(): Collection
    {
        return $this->annonceImages;
    }

    public function addAnnonceImage(AnnonceImage $annonceImage): self
    {
        if (!$this->annonceImages->contains($annonceImage)) {
            $this->annonceImages[] = $annonceImage;
            $annonceImage->setAnnonce($this);
        }

        return $this;
    }

    public function removeAnnonceImage(AnnonceImage $annonceImage): self
    {
        if ($this->annonceImages->removeElement($annonceImage)) {
            // set the owning side to null (unless already changed)
            if ($annonceImage->getAnnonce() === $this) {
                $annonceImage->setAnnonce(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Signalement[]
     */
    public function getSignalements(): Collection
    {
        return $this->signalements;
    }

    public function addSignalement(Signalement $signalement): self
    {
        if (!$this->signalements->contains($signalement)) {
            $this->signalements[] = $signalement;
            $signalement->setAnnonce($this);
        }

        return $this;
    }

    public function removeSignalement(Signalement $signalement): self
    {
        if ($this->signalements->removeElement($signalement)) {
            // set the owning side to null (unless already changed)
            if ($signalement->getAnnonce() === $this) {
                $signalement->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getNbRenew(): ?int
    {
        return $this->nbRenew;
    }

    public function setNbRenew(?int $nbRenew): self
    {
        $this->nbRenew = $nbRenew;

        return $this;
    }

    public function getEndPublishedAt(): ?\DateTimeInterface
    {
        return $this->endPublishedAt;
    }

    public function setEndPublishedAt(\DateTimeInterface $endPublishedAt): self
    {
        $this->endPublishedAt = $endPublishedAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

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

    public function getLocation(): ?int
    {
        return $this->location;
    }

    public function setLocation(int $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getDetails(): ?array
    {
        return $this->details;
    }

    public function setDetails(?array $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getStolenAt(): ?\DateTimeInterface
    {
        return $this->stolenAt;
    }

    public function setStolenAt(\DateTimeInterface $stolenAt): self
    {
        $this->stolenAt = $stolenAt;

        return $this;
    }
}
