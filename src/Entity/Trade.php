<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TradeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TradeRepository::class)
 */
#[ApiResource()]
class Trade
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $startAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $endAt;

    /**
     * @ORM\Column(type="boolean",options={"default":0})
     */
    private $isPublished = false;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $reasons;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $outcome;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $lesson;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isGood;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $finalRatio;

    /**
     * @ORM\OneToMany(targetEntity=TradeImage::class, mappedBy="trade", orphanRemoval=true)
     */
    private $tradeImages;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=TradeInstrument::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $tradeInstrument;


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

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

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

}
