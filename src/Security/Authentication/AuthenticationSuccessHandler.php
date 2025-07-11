<?php

namespace App\Security\Authentication;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {

    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return JsonResponse|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token): ?JsonResponse
    {
        return new RedirectResponse($this->urlGenerator->generate('app_main'));
    }
}