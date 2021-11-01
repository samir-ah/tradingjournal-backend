<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/{reactRouting}', name: 'main',requirements: ["reactRouting"=>"^(?!api).+"],defaults: ["reactRouting"=> null])]
    public function index(): Response
    {
        return $this->render('index.html.twig', []);
    }
}
