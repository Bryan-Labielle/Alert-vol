<?php

namespace App\Entity;

use App\Service\Slugify;
use DateTime;
use DateTimeInterface;
use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 * @Assert\EnableAutoMapping()
 */
class Annonce
{
    public const STATUS = [
        '0' => 'pending',
        '1' => 'activated',
        '2' => 'closed',
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"bookmarks"})
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank(message="champ obligatoire")
     * @Groups({"bookmarks"})
     */
    private string $title;

    /**
     * @ORM\OneToMany(targetEntity=AnnonceImage::class, mappedBy="annonce")
     * @Groups({"bookmarks"})
     */
    private Collection $annonceImages;

    /**
     * @ORM\OneToMany(targetEntity=Signalement::class, mappedBy="annonce")
     * @Groups({"bookmarks"})
     */
    private Collection $signalements;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"bookmarks"})
     */
    private ?string $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"bookmarks"})
     */
    private ?DateTimeInterface $publishedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"bookmarks"})
     */
    private ?int $nbRenew = 0 ;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"bookmarks"})
     */
    private ?DateTimeInterface $endPublishedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"bookmarks"})
     */
    private ?Category $category;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"bookmarks"})
     */
    private ?string $reference;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"bookmarks"})
     */
    private ?int $status = 0;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"bookmarks"})
     */
    private ?User $owner;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"bookmarks"})
     */
    private ?int $zip;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"bookmarks"})
     */
    private ?\DateTimeInterface $stolenAt;

    /**
     * @ORM\Column(name="slug", type="string", length=255)
     * @Groups({"bookmarks"})
     */
    private string $slug;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="bookmark")
     */
    private Collection $users;

    /**
     * @ORM\OneToMany(targetEntity=Details::class, mappedBy="annonce", orphanRemoval=true,
     * cascade={"persist", "remove"})
     */
    private Collection $details;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private ?string $city;


    public function __construct()
    {
        $this->annonceImages = new ArrayCollection();
        $this->signalements = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->details = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
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

    public function getZip(): ?int
    {
        return $this->zip;
    }

    public function setZip(int $zip): self
    {
        $this->zip = $zip;

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

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param String $slug
     * @return String
     */
    public function setSlug(string $slug): string
    {
        return $this->slug = $slug;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addToBookmarks($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeBookmark($this);
        }

        return $this;
    }

    /**
     * @return Collection|Details[]
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Details $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setAnnonce($this);
        }

        return $this;
    }

    public function removeDetail(Details $detail): self
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getAnnonce() === $this) {
                $detail->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }
}
