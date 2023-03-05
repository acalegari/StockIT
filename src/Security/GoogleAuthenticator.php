<?php

namespace App\Security;

use Amp\Http\Client\HttpClient;
use App\Entity\User;
use League\OAuth2\Client\Provider\GoogleUser;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class GoogleAuthenticator extends OAuth2Authenticator {

    private RouterInterface $router;
    private ClientRegistry $clientRegistry;
    private EntityManagerInterface $entityManager;

    public function __construct(RouterInterface $router, ClientRegistry $clientRegistry, EntityManagerInterface $entityManager)
    {
        $this->router = $router;
        $this->clientRegistry = $clientRegistry;
        $this->entityManager = $entityManager;
    }

    public function start() 
    {

        return new RedirectResponse($this->router->generate('app_login'));
    }

    public function supports(Request $request): ?bool
    {
        return 'oauth_check' == $request->attributes->get('_route') && $request->get('service') == 'google';
    }

    public function authenticate(Request $request): Passport
    {
        // return $this->fetchAccessToken($this->clientRegistry->getClient('google'));
        $client = $this->clientRegistry->getClient('google_main');
        $accessToken = $this->fetchAccessToken($client);

        return new SelfValidatingPassport(
            new UserBadge($accessToken->getToken(), function () use ($accessToken, $client) {
                /** @var GoogleUser $googleUser */
                $googleUser = $client->fetchUserFromToken($accessToken);
              
                $email = $googleUser->getEmail();
                $lastName = $googleUser->getLastName();
                $firstName = $googleUser->getFirstName();

                // User already logged before
                $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['googleId' => $googleUser->getId()]);

                //Create user if not exists
                if (!$existingUser) {
                    //email address already saved
                    $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
                    if($user) {
                        $existingUser = $user->setGoogleId($googleUser->getId());
                    } else {
                        $existingUser = new User();
                        $existingUser->setEmail($email);
                        $existingUser->setFirstName($firstName);
                        $existingUser->setLastName($lastName);
                        $existingUser->setGoogleId($googleUser->getId());
                        $existingUser->setRoles(['ROLE_USER']);
                    }
                    $this->entityManager->persist($existingUser);
                }
                $this->entityManager->flush();

                return $existingUser;
            })
        );
    }

    // public function getUser ($credentials, UserProviderInterface $userProvider) 
    // {
    //     dd($credentials);
    // }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse(
            $this->router->generate('app_home')
        );
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($message, Response::HTTP_FORBIDDEN);
    }
}
