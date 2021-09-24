<?php

namespace App\Controller;
use App\Entity\TradeImage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[AsController]
class TradeImageCollectionPostController extends AbstractController
{
    public function __construct(private AuthorizationCheckerInterface $checker)
    {
    }

    public function __invoke(TradeImage $data): TradeImage
    {
        if ($this->checker->isGranted('ROLE_ADMIN') || $this->checker->isGranted('CAN_EDIT',$data->getTrade())) {
            return $data;
        }
        throw new AccessDeniedHttpException('Vous ne pouvez pas uploader une image pour ce trade');
    }

}