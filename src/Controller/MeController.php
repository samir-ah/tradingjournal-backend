<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\User\UserInterface;

#[AsController]
class MeController extends AbstractController
{

    public function __invoke():UserInterface
    {
        return $this->getUser();
    }

}
