<?php

namespace App\Controller;

use App\Entity\Trade;
use App\Repository\TradeLikeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class TradeGetController extends AbstractController
{

    public function __construct(private TradeLikeRepository $likeRepository)
    {
    }

    public function __invoke(Trade $data):Trade
    {
        return $data->setLikedByMe($this->likeRepository->count(['trade' => $data->getId(),
            'author' => $this->getUser()->getId()]));
    }
}
