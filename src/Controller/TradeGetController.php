<?php

namespace App\Controller;

use App\Entity\Trade;
use App\Repository\TradeLikeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Vich\UploaderBundle\Storage\StorageInterface;

#[AsController]
class TradeGetController extends AbstractController
{

    public function __construct(private StorageInterface $storage)
    {

    }

    public function __invoke(Trade $data): Trade
    {
        foreach ($data->getTradeImages() as $tradeImage) {
            $tradeImage->setFileUrl($this->storage->resolveUri($tradeImage, 'file'));
        }
        return $data;
//        return $data->setLikedByMe($this->likeRepository->count(['trade' => $data->getId(),
//            'author' => $this->getUser()->getId()]));
    }
}
