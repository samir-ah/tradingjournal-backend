<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TradeCommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TradeCommentRepository::class)
 */
#[ApiResource()]
class TradeComment implements AuthorOwnedInterface
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class,)
     * @ORM\JoinColumn(nullable=true,onDelete="SET NULL")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=Trade::class)
     * @ORM\JoinColumn(nullable=false,onDelete="CASCADE")
     */
    private $trade;

    /**
     * @ORM\ManyToOne(targetEntity=TradeComment::class, inversedBy="tradeComments")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $parentTradeComment;

    /**
     * @ORM\OneToMany(targetEntity=TradeComment::class, mappedBy="parentTradeComment")
     */
    private $tradeComments;

    public function __construct()
    {
        $this->tradeComments = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getTrade(): ?Trade
    {
        return $this->trade;
    }

    public function setTrade(?Trade $trade): self
    {
        $this->trade = $trade;

        return $this;
    }

    public function getParentTradeComment(): ?self
    {
        return $this->parentTradeComment;
    }

    public function setParentTradeComment(?self $parentTradeComment): self
    {
        $this->parentTradeComment = $parentTradeComment;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getTradeComments(): Collection
    {
        return $this->tradeComments;
    }

    public function addTradeComment(self $tradeComment): self
    {
        if (!$this->tradeComments->contains($tradeComment)) {
            $this->tradeComments[] = $tradeComment;
            $tradeComment->setParentTradeComment($this);
        }

        return $this;
    }

    public function removeTradeComment(self $tradeComment): self
    {
        if ($this->tradeComments->removeElement($tradeComment)) {
            // set the owning side to null (unless already changed)
            if ($tradeComment->getParentTradeComment() === $this) {
                $tradeComment->setParentTradeComment(null);
            }
        }

        return $this;
    }
}
