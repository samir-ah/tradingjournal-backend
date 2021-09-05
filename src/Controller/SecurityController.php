<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/api/login', name: 'api_login', methods: ['POST'])]
    public function apiLogin(): JsonResponse
    {

        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUsername(),
            'email' => $user->getUserIdentifier(),
            'roles' => $user->getRoles()
        ]);
    }
//    /**
//     * @Route("/login", name="app_login")
//     */
//    public function login(AuthenticationUtils $authenticationUtils): Response
//    {
////         if ($this->getUser()) {
////             return $this->redirectToRoute('target_path');
////         }
//        $user = $this->getUser();
//        if ($user) {
//            return $this->json([
//                'username' => $user->getUsername(),
//                'email' => $user->getUserIdentifier(),
//                'roles' => $user->getRoles()
//            ]);
//        }
//
//        // get the login error if there is one
//        $error = $authenticationUtils->getLastAuthenticationError();
//        // last username entered by the user
//        $lastUsername = $authenticationUtils->getLastUsername();
//
//        return $this->json( ['last_username' => $lastUsername, 'error' => $error]);
////        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
//    }
//
//    /**
//     * @Route("/logout", name="app_logout")
//     */
//    public function logout()
//    {
//        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
//    }
}
