<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\TradeCollectionGetController;
use App\Controller\TradeCollectionPostController;
use App\Repository\TradeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

/**
 * @ORM\Entity(repositoryClass=TradeRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get' => [
            'openapi_context' => [
                'security' => [['bearerAuth' => []]]
            ],
            'normalization_context' => [
                'groups' => ['read:Trade:Collection']
            ]
        ],
        'post' => [
            'controller' => TradeCollectionPostController::class,
            'openapi_context' => [
                'security' => [['bearerAuth' => []]]
            ],
        ]
    ],
    itemOperations: [
        'get' => [
            'openapi_context' => [
                'security' => [['bearerAuth' => []]]
            ],
            'controller' => TradeCollectionGetController::class,
            'security' => 'is_granted("TRADE_VIEW",object)'
        ],
        'delete' => [
            'openapi_context' => [
                'security' => [['bearerAuth' => []]]
            ],
            'security' => 'is_granted("ROLE_ADMIN") or is_granted("CAN_EDIT",object)'
        ],
        'put' => [
            'openapi_context' => [
                'security' => [['bearerAuth' => []]]
            ],
            'security' => 'is_granted("ROLE_ADMIN") or is_granted("CAN_EDIT",object)'
        ]
    ],
    denormalizationContext: ['groups' => ['write:Trade']],
    normalizationContext: ['groups' => ['read:Trade']],
    security: 'is_granted("ROLE_USER")'


)]
class Trade implements AuthorOwnedInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:Trade', 'read:Trade:Collection'])]
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    #[Groups(['read:Trade', 'write:Trade', 'read:Trade:Collection'])]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:m'])]
    private $startAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    #[Groups(['read:Trade', 'write:Trade', 'read:Trade:Collection'])]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:m'])]
    private $endAt;

    /**
     * @ORM\Column(type="boolean",options={"default":0})
     */
    #[Groups(['read:Trade', 'write:Trade', 'read:Trade:Collection'])]
    private bool $isPublished = false;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    #[Groups(['read:Trade', 'write:Trade'])]
    private $reasons;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    #[Groups(['read:Trade', 'write:Trade'])]
    private $outcome;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    #[Groups(['read:Trade', 'write:Trade'])]
    private $lesson;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    #[Groups(['read:Trade', 'write:Trade', 'read:Trade:Collection'])]
    private ?bool $isGood;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    #[Groups(['read:Trade', 'write:Trade', 'read:Trade:Collection'])]
    private $finalRatio;

    /**
     * @ORM\OneToMany(targetEntity=TradeImage::class, mappedBy="trade", orphanRemoval=true)
     */
    #[Groups(['read:Trade', 'write:Trade'])]
    private $tradeImages;

    /**
     *
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="trades")
     * @ORM\JoinColumn(onDelete="SET NULL")
     * @ORM\JoinColumn(nullable=true)
     */
    #[Groups(['read:Trade', 'read:Trade:Collection'])]
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=TradeInstrument::class)
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:Trade', 'write:Trade', 'read:Trade:Collection'])]
    private $tradeInstrument;

    #[Groups(['read:Trade', 'read:Trade:Collection'])]
    private int $tradeLikesCount = 0;

    /**
     * @return int
     */
    public function getTradeLikesCount()
    {
        return $this->tradeLikesCount;
    }

    /**
     * @param int $tradeLikesCount
     * @return Trade
     */
    public function setTradeLikesCount(int $tradeLikesCount): self
    {
        $this->tradeLikesCount = $tradeLikesCount;
        return $this;
    }


    public function __construct()
    {
        $this->tradeImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeImmutable $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getReasons(): ?string
    {
        return $this->reasons;
    }

    public function setReasons(?string $reasons): self
    {
        $this->reasons = $reasons;

        return $this;
    }

    public function getOutcome(): ?string
    {
        return $this->outcome;
    }

    public function setOutcome(?string $outcome): self
    {
        $this->outcome = $outcome;

        return $this;
    }

    public function getLesson(): ?string
    {
        return $this->lesson;
    }

    public function setLesson(?string $lesson): self
    {
        $this->lesson = $lesson;

        return $this;
    }

    public function getIsGood(): ?bool
    {
        return $this->isGood;
    }

    public function setIsGood(?bool $isGood): self
    {
        $this->isGood = $isGood;

        return $this;
    }

    public function getFinalRatio(): ?float
    {
        return $this->finalRatio;
    }

    public function setFinalRatio(?float $finalRatio): self
    {
        $this->finalRatio = $finalRatio;

        return $this;
    }

    /**
     * @return Collection|TradeImage[]
     */
    public function getTradeImages(): Collection
    {
        return $this->tradeImages;
    }

    public function addTradeImage(TradeImage $tradeImage): self
    {
        if (!$this->tradeImages->contains($tradeImage)) {
            $this->tradeImages[] = $tradeImage;
            $tradeImage->setTrade($this);
        }

        return $this;
    }

    public function removeTradeImage(TradeImage $tradeImage): self
    {
        if ($this->tradeImages->removeElement($tradeImage)) {
            // set the owning side to null (unless already changed)
            if ($tradeImage->getTrade() === $this) {
                $tradeImage->setTrade(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $user): self
    {
        $this->author = $user;

        return $this;
    }

    public function getTradeInstrument(): ?TradeInstrument
    {
        return $this->tradeInstrument;
    }

    public function setTradeInstrument(?TradeInstrument $tradeInstrument): self
    {
        $this->tradeInstrument = $tradeInstrument;

        return $this;
    }
    // Calculated field
//    #[Groups(['read:Trade'])]
//    public function getTradeLikesCount(): int
//    {
//        return 1;
//    }

}
