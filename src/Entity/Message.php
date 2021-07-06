<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 * @Assert\EnableAutoMapping()
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="text")
     */
    private string $content;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="sender")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?User $sender;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="recipient")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?User $recipient;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $sentAt;

    /**
     * @ORM\ManyToOne(targetEntity=signalement::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Signalement $signalement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getRecipient(): ?User
    {
        return $this->recipient;
    }

    public function setRecipient(?User $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getSentAt(): ?\DateTimeInterface
    {
        return $this->sentAt;
    }

    public function setSentAt(\DateTimeInterface $sentAt): self
    {
        $this->sentAt = $sentAt;

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
}
