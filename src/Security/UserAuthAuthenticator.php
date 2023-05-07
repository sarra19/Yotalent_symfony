<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class UserAuthAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

public function authenticate(Request $request): Passport
{
    $email = $request->request->get('email', '');

    $request->getSession()->set(Security::LAST_USERNAME, $email);

    $password = $request->request->get('password', '');

    // Check if both username and password are "admin"
    if ($email === 'admin' && $password === 'admin') {
        // Login as admin and redirect to app_user_index
        return new Passport(
            new UserBadge($email, function () {
                // In this example, we assume that 'ROLE_ADMIN' is the role for an admin user
                return new User('admin', null, ['ROLE_ADMIN']);
            }),
            new PasswordCredentials($password),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    // Otherwise, authenticate as a regular user
    return new Passport(
        new UserBadge($email),
        new PasswordCredentials($password),
        [
            new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
        ]
    );
}


    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }
    
        // Get the user role
        $userRole = $token->getUser()->getRoles()[0];
    
        // Use a switch case to redirect to the appropriate page
        switch($userRole) {
            case 'Admin':
                
                return new RedirectResponse($this->urlGenerator->generate('app_user_index'));
            case 'User':
                return new RedirectResponse($this->urlGenerator->generate('app_user_index'));

                case 'Organization':
                    return new RedirectResponse($this->urlGenerator->generate('app_user_index'));
            default:
                return new RedirectResponse($this->urlGenerator->generate('app_user_index'));
        }
    }
    

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
