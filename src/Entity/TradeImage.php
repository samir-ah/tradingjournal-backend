<?php

namespace App\Entity;

use App\Repository\TradeImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TradeImageRepository::class)
 */
class TradeImage
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
    private $imageFile;

    /**
     * @ORM\ManyToOne(targetEntity=Trade::class, inversedBy="tradeImages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trade;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageFile(): ?string
    {
        return $this->imageFile;
    }

    public function setImageFile(string $imageFile): self
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    public function getTrade(): ?Trade
    {
        return $this->Trade;
    }

    public function setTrade(?Trade $Trade): self
    {
        $this->Trade = $Trade;

        return $this;
    }
}
