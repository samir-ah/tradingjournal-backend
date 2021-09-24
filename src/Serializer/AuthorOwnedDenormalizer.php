<?php


namespace App\Serializer;

use App\Entity\AuthorOwnedInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use ReflectionException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;

class AuthorOwnedDenormalizer implements ContextAwareDenormalizerInterface, DenormalizerAwareInterface
{

    use DenormalizerAwareTrait;

    private const ALREADY_CALLED_DENORMALIZER = 'UserOwnedDenormalizerCalled';

    public function __construct(private Security $security,private EntityManagerInterface $em){

    }

    /**
     * @throws ReflectionException
     */
    public function supportsDenormalization($data, string $type, string $format = null, array $context = []): bool
    {
        $reflectionClass = new \ReflectionClass($type);
        $alreadyCalled = $context[self::ALREADY_CALLED_DENORMALIZER] ?? false;
        return $reflectionClass->implementsInterface(AuthorOwnedInterface::class) && $alreadyCalled === false;
    }

    /**
     * @throws ExceptionInterface
     * @throws ORMException
     */
    public function denormalize($data, string $type, string $format = null, array $context = []): AuthorOwnedInterface
    {
        $context[self::ALREADY_CALLED_DENORMALIZER] = true;
        /** @var AuthorOwnedInterface $obj */
        $obj = $this->denormalizer->denormalize($data, $type, $format, $context);
        $obj->setAuthor($this->em->getReference(User::class,$this->security->getUser()->getId()));
        return $obj;
    }

}
