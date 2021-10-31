<?php

namespace App\Serializer;

use App\Entity\Trade;
use App\Repository\TradeLikeRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

class TradeNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;
    private const ALREADY_CALLED = 'TRADE_IMAGE_NORMALIZER_ALREADY_CALLED';

    public function __construct(private TradeLikeRepository $likeRepository, private  Security $security)
    {
    }
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return !isset($context[self::ALREADY_CALLED]) && $data instanceof Trade;
    }

    public function normalize($object, string $format = null, array $context = []): float|int|bool|\ArrayObject|array|string|null
    {
        $object->setLikedByMe($this->likeRepository->count(['trade' => $object->getId(),
            'author' => $this->security->getUser()->getId()]));;
        $context[self::ALREADY_CALLED] = true;
        return $this->normalizer->normalize($object, $format, $context);
    }

}