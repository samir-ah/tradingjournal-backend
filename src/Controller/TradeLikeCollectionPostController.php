<?php

namespace App\Controller;

use App\Entity\TradeLike;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[AsController]
class TradeLikeCollectionPostController extends AbstractController
{
    public function __construct(private AuthorizationCheckerInterface $checker)
    {
    }

    public function __invoke(TradeLike $data): TradeLike
    {
        if ($this->checker->isGranted('ROLE_ADMIN') || $this->checker->isGranted('TRADE_VIEW',$data->getTrade())) {
            return $data;
        }
        throw new AccessDeniedHttpException('Vous ne pouvez pas liker ce trade');
    }

}