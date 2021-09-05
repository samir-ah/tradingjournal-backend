<?php

namespace App\Entity;

use App\Repository\TradeLikeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TradeLikeRepository::class)
 */
class TradeLike
{
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $likedAt;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Trade::class)
     * @ORM\JoinColumn(nullable=false,onDelete="CASCADE")
     */
    private $trade;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false,onDelete="CASCADE")
     */
    private $author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLikedAt(): ?\DateTimeImmutable
    {
        return $this->likedAt;
    }

    public function setLikedAt(\DateTimeImmutable $likedAt): self
    {
        $this->likedAt = $likedAt;

        return $this;
    }

    public function getTrade(): ?Trade
    {
        return $this->trade;
    }

    public function setTrade(?Trade $trade): self
    {
        $this->trade = $trade;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
