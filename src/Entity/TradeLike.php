<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\TradeLikeCollectionPostController;
use App\Repository\TradeLikeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TradeLikeRepository::class)
 * @UniqueEntity(fields={"trade","author"}, message="Vous avez déjà liké ce trade")
 */

#[ApiResource(
    collectionOperations: [
        'post' => [
            'controller' => TradeLikeCollectionPostController::class
        ],
        'get' => [
            'openapi_context' => [
                'security' => [['bearerAuth' => []]]
            ],
            'normalization_context' => [
                'groups' => ['read:TradeLike','read:Trade:Collection']
            ]
        ],

    ],
    itemOperations: [
        'get' =>[
            'security' => 'is_granted("ROLE_ADMIN") or is_granted("TRADE_VIEW",object.getTrade())'
        ],
        'delete' => [
            'security' => 'is_granted("ROLE_ADMIN") or is_granted("CAN_EDIT",object)'
        ]
    ],
    denormalizationContext: ['groups' => ['write:TradeLike']],
    normalizationContext: ['groups' => ['read:TradeLike']],
    order: ["likedAt" => "DESC"], paginationItemsPerPage: 4, security: 'is_granted("ROLE_USER")'
)]
class TradeLike implements AuthorOwnedInterface
{
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    #[Groups(['read:TradeLike'])]
    private $likedAt;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Trade::class)
     * @ORM\JoinColumn(nullable=false,onDelete="CASCADE")
     */
    #[Groups(['write:TradeLike','read:TradeLike'])]
    private $trade;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false,onDelete="CASCADE")
     */
    #[Groups(['read:TradeLike'])]
    private $author;


    public function __construct()
    {
        $this->likedAt = new \DateTimeImmutable();
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
