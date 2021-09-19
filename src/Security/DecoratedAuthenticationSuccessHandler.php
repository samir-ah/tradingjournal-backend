<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Scheb\TwoFactorBundle\Security\Authentication\Token\TwoFactorTokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class DecoratedAuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(private AuthenticationSuccessHandler $authenticationSuccessHandler)
    {
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): ?Response
    {
        if ($token instanceof TwoFactorTokenInterface) {
            // Return the response to tell the client two-factor authentication is required.
            return new Response('{"login": "success": "2fa_complete": false}');
        }

        // Otherwise return the default response for successful login. You could do this by decorating
        // the original authentication success handler and calling it here.
        return $this->authenticationSuccessHandler->onAuthenticationSuccess($request,$token);
    }
}
//class DecoratedAuthenticationSuccessHandler extends AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
//{
//    public function onAuthenticationSuccess(Request $request, TokenInterface $token): ?Response
//    {
//        if ($token instanceof TwoFactorTokenInterface) {
//            // Return the response to tell the client two-factor authentication is required.
//            return new Response('{"login": "success": "2fa_complete": false}');
//        }
//
//        // Otherwise return the default response for successful login. You could do this by decorating
//        // the original authentication success handler and calling it here.
//        return parent::onAuthenticationSuccess($request,$token);
//    }
//}