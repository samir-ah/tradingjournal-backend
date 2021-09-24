<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\MeController;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Scheb\TwoFactorBundle\Model\Email\TwoFactorInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
#[ApiResource(
    collectionOperations: [
        'get' => [
            'pagination_enabled' => false,
            'security_message' => 'Vous devez être un admin',
            'security' => 'is_granted("ROLE_ADMIN")',
            'openapi_context' => [
                'security' => [['bearerAuth' => []]]
            ]
        ]
    ],
    itemOperations: [
        'get' => [
            'openapi_context' => [
                'security' => [['bearerAuth' => []]]
            ],
            'security' => 'is_granted("ROLE_ADMIN") or object.getId() == user.getId()',
        ],

        'me' => [
            'pagination_enabled' => false,
            'path' => '/me',
            'method' => 'get',
            'controller' => MeController::class,
            'read' => false,
            'security' => 'is_granted("ROLE_USER")',
            'security_message' => 'Vous devez être connecté',
            'openapi_context' => [
                'security' => [['bearerAuth' => []]]
            ]

        ]
    ],
    denormalizationContext: ['groups' => ['write:User']],
    normalizationContext: ['groups' => ['read:User']],


)]
class User implements UserInterface, PasswordAuthenticatedUserInterface, JWTUserInterface, TwoFactorInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:User','read:Trade'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    #[Groups(['read:User', 'write:User'])]
    private $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $authCode;

    /**
     * @ORM\Column(type="json")
     */
    #[Groups(['read:User'])]
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    #[Groups(['write:User'])]
    private $password;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    #[Groups(['read:User', 'write:User','read:Trade','read:TradeComment'])]
    private $username;

    /**
     * @ORM\Column(type="boolean")
     */
    #[Groups(['read:User'])]
    private bool $isVerified = false;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    #[Groups(['read:User'])]
    #[ApiProperty(['security' => 'is_granted("ROLE_ADMIN") or is_granted("ROLE_USER") and object.getId() == user.getId()'])]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:m'])]
    private $registeredAt;

    /**
     * @ORM\OneToMany(targetEntity=Trade::class, mappedBy="author")
     */
    private $trades;

    public function __construct()
    {
        $this->registeredAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    public function getUsername(): string
    {
        return (string)$this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function getIsVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public static function createFromPayload($email, array $payload): User
    {
        return (new User())
            ->setId($payload['id'])
            ->setEmail($email)
            ->setRoles($payload['roles'])
            ->setUsername($payload['username'])
            ->setIsVerified($payload['is_verified']);

    }

    public function isEmailAuthEnabled(): bool
    {
        return false; // This can be a persisted field to switch email code authentication on/off
    }

    public function getEmailAuthRecipient(): string
    {
        return $this->email;
    }

    public function getEmailAuthCode(): string
    {
        if (null === $this->authCode) {
            throw new \LogicException('The email authentication code was not set');
        }

        return $this->authCode;
    }

    public function setEmailAuthCode(string $authCode): void
    {
        $this->authCode = $authCode;
    }

    public function getRegisteredAt(): ?\DateTimeImmutable
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(\DateTimeImmutable $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }
    /**
     * @return Collection|Trade[]
     */
    public function getTrades(): Collection
    {
        return $this->trades;
    }

    public function addTrade(Trade $trade): self
    {
        if (!$this->trades->contains($trade)) {
            $this->trades[] = $trade;
            $trade->setAuthor($this);
        }

        return $this;
    }

    public function removeTrade(Trade $trade): self
    {
        if ($this->trades->removeElement($trade)) {
            // set the owning side to null (unless already changed)
            if ($trade->getAuthor() === $this) {
                $trade->setAuthor(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->id;
    }

}
