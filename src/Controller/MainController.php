<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
//    #[Route('/{reactRouting}', name: 'main', requirements: ["reactRouting"=>"^(?!api).+"], defaults: ["reactRouting"=> null])]
    #[Route('/{reactRouting}', name: 'main', requirements: ["reactRouting"=>".+"], defaults: ["reactRouting"=> null], priority: "-1")]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }
}
