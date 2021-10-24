<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\TradeCommentCollectionPostController;
use App\Repository\TradeCommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

/**
 * @ORM\Entity(repositoryClass=TradeCommentRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get' => [],
        'post' => [
          'controller' => TradeCommentCollectionPostController::class
        ],

    ],
    itemOperations: [
        'delete' => [
            'security' => 'is_granted("ROLE_ADMIN") or is_granted("CAN_EDIT",object)'
        ],
        'put' => [
            'security' => 'is_granted("ROLE_ADMIN") or is_granted("CAN_EDIT",object)'
        ],
        'get' =>[
            'security' => 'is_granted("ROLE_ADMIN") or is_granted("TRADE_VIEW",object.getTrade()) or is_granted("CAN_EDIT",object)'
        ]
    ],
    denormalizationContext: ['groups' => ['write:TradeComment']],
    normalizationContext: ['groups' => ['read:TradeComment']],
    order: [
        'createdAt' => 'DESC'
],
    paginationItemsPerPage: 7,
    security: 'is_granted("ROLE_USER")'
)]
#[ApiFilter(SearchFilter::class, properties: ['trade' => 'exact'])]
class TradeComment implements AuthorOwnedInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:TradeComment'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:TradeComment','write:TradeComment'])]
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    #[Groups(['read:TradeComment','write:TradeComment'])]
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class,)
     * @ORM\JoinColumn(nullable=true,onDelete="SET NULL")
     */
    #[Groups(['read:TradeComment'])]
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=Trade::class)
     * @ORM\JoinColumn(nullable=false,onDelete="CASCADE")
     */
    #[Groups(['write:TradeComment'])]
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

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    #[Groups(['read:TradeComment'])]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:i'])]
    private $createdAt;

    public function __construct()
    {
        $this->tradeComments = new ArrayCollection();
        $this->setCreatedAt(new \DateTimeImmutable());
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
