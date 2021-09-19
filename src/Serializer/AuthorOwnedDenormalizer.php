<?php


namespace App\Serializer;

use App\Entity\AuthorOwnedInterface;
use App\Entity\UserOwnedInterface;
use ReflectionException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;

class AuthorOwnedDenormalizer implements ContextAwareDenormalizerInterface, DenormalizerAwareInterface
{

    use DenormalizerAwareTrait;

    private const ALREADY_CALLED_DENORMALIZER = 'UserOwnedDenormalizerCalled';

    public function __construct(private Security $security){

    }

    /**
     * @throws ReflectionException
     */
    public function supportsDenormalization($data, string $type, string $format = null, array $context = [])
    {
        $reflectionClass = new \ReflectionClass($type);
        $alreadyCalled = $data[self::ALREADY_CALLED_DENORMALIZER] ?? false;
        return $reflectionClass->implementsInterface(AuthorOwnedInterface::class) && $alreadyCalled === false;
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $data[self::ALREADY_CALLED_DENORMALIZER] = true;
        /** @var AuthorOwnedInterface $obj */
        $obj = $this->denormalizer->denormalize($data, $type, $format, $context);
        $obj->setAuthor($this->security->getUser());
        return $obj;
    }

    private function getAlreadyCalledKey (string $type) {
        return self::ALREADY_CALLED_DENORMALIZER . $type;
    }
}
