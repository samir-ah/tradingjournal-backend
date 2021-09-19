<?php

namespace App\Controller;

use App\Entity\Trade;
use App\Entity\TradeInstrument;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;

#[AsController]
class TradeCollectionPostController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em,private AuthorizationCheckerInterface $checker)
    {
    }

    /**
     * @throws ORMException
     */
    public function __invoke(Trade $data): Trade
    {

        if ($this->checker->isGranted('ROLE_ADMIN') || $data->getAuthor()?->getId() === $this->checker->getUser()->getId()) {
            return $data;
        }

        return $data->setAuthor($this->em->getReference(User::class,$this->getUser()->getId()));
    }

}