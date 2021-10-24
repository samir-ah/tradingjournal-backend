<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\TradeImageCollectionPostController;
use App\Repository\TradeImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=TradeImageRepository::class)
 * @Vich\Uploadable
 */
#[ApiResource(

    collectionOperations: [

        'post' => [
            'deserialize' => false,
            'openapi_context' => [
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'controller' => TradeImageCollectionPostController::class
        ],

    ],
    itemOperations: [
        'delete' => [
            'security' => 'is_granted("ROLE_ADMIN") or is_granted("CAN_EDIT",object.getTrade())'
        ],
        'get' =>[
            'security' => 'is_granted("TRADE_VIEW",object.getTrade())'
        ]
    ],
    denormalizationContext: ['groups' => ['write:TradeImage']],
    normalizationContext: ['groups' => ['read:TradeImage']],
    security: 'is_granted("ROLE_USER")'

)]
class TradeImage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:TradeImage', 'read:Trade'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:TradeImage', 'read:Trade'])]
    private ?string $imageFile;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="trade_image", fileNameProperty="imageFile")
     */
    #[
        Image(
            maxSize: "2048k",
            mimeTypes: ["image/jpeg", "image/png"],
            mimeTypesMessage: "Ce type de fichier n'est pas autorisé"
        )
    ]
    #[Groups(['write:TradeImage'])]
    private ?File $file = null;
    /**
     * @var string|null
     */
    #[Groups(['read:TradeImage', 'read:Trade'])]
    private ?string $fileUrl = null;

    /**
     * @ORM\ManyToOne(targetEntity=Trade::class, inversedBy="tradeImages")
     * @ORM\JoinColumn(nullable=false)
     */
    #[
        Groups(['write:TradeImage']),
        NotBlank()
    ]
    private $trade;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    #[Groups(['read:TradeImage'])]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:i:s'])]
    private $createdAt;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageFile(): ?string
    {
        return $this->imageFile;
    }

    public function setImageFile(?string $imageFile): self
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    public function getTrade(): ?Trade
    {
        return $this->trade;
    }

    public function setTrade(?Trade $Trade): self
    {
        $this->trade = $Trade;

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

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @param File|null $file
     * @return TradeImage
     */
    public function setFile(?File $file): TradeImage
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFileUrl(): ?string
    {
        return $this->fileUrl;
    }

    /**
     * @param string|null $fileUrl
     * @return TradeImage
     */
    public function setFileUrl(?string $fileUrl): TradeImage
    {
        $this->fileUrl = $fileUrl;
        return $this;
    }
}
