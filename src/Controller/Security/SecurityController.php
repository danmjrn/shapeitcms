<?php

namespace App\Controller\Security;

use App\Security\Authentication\ExternalUserAuthenticator;
use App\Security\Authentication\InternalUserAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

// generate code for this file

class SecurityController extends AbstractController
{
    #[Route('/auth/external/sign-in', name: 'external_login')]
    public function externalLogin(AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();

        if (ExternalUserAuthenticator::isUserExternalUser($user))
            return $this->redirectToRoute('external_dashboard');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/external_login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/auth/external/sign-out', name: 'external_logout')]
    public function externalLogout(): Response
    {
        throw new \Exception('This should never be reached!');
    }

    #[Route('/auth/internal/sign-in', name: 'internal_login', methods: ['GET','POST'])]
    public function internalLogin(AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();

        if (InternalUserAuthenticator::isUserInternalUser($user))
            return $this->redirectToRoute('internal_dashboard');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/internal_login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/auth/internal/sign-out', name: 'internal_logout')]
    public function internalLogout(): Response
    {
        throw new \Exception('This should never be reached!');
    }

}
