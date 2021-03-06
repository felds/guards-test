<?php
declare(strict_types=1);

namespace App\Security;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\OAuth2Client;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class GoogleOauthAuthenticator extends SocialAuthenticator
{
    const ROUTE = 'app_connect_check';

    /**
     * @var ClientRegistry
     */
    private $registry;

    public function __construct(ClientRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * Does the authenticator support the given Request?
     *
     * If this returns false, the authenticator will be skipped.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function supports(Request $request): bool
    {
        return $request->attributes->get('_route') === static::ROUTE;
    }

    /**
     * Get the authentication credentials from the request and return them
     * as any type (e.g. an associate array).
     *
     * Whatever value you return here will be passed to getUser() and checkCredentials()
     *
     * For example, for a form login, you might:
     *
     *      return array(
     *          'username' => $request->request->get('_username'),
     *          'password' => $request->request->get('_password'),
     *      );
     *
     * Or for an API token that's on a header, you might use:
     *
     *      return array('api_key' => $request->headers->get('X-API-TOKEN'));
     *
     * @param Request $request
     *
     * @return mixed Any non-null value
     *
     * @throws \UnexpectedValueException If null is returned
     */
    public function getCredentials(Request $request)
    {
        return $this->fetchAccessToken($this->getClient());
    }

    /**
     * Returns a response that directs the user to authenticate.
     *
     * This is called when an anonymous request accesses a resource that
     * requires authentication. The job of this method is to return some
     * response that "helps" the user start into the authentication process.
     *
     * Examples:
     *  A) For a form login, you might redirect to the login page
     *      return new RedirectResponse('/login');
     *  B) For an API token authentication system, you return a 401 response
     *      return new Response('Auth header required', 401);
     *
     * @param Request $request The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     *
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        dump(['start', $request, $authException]);
        die;
    }

    /**
     * Return a UserInterface object based on the credentials.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * You may throw an AuthenticationException if you wish. If you return
     * null, then a UsernameNotFoundException is thrown for you.
     *
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     *
     * @throws AuthenticationException
     *
     * @return UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        dump(['getUser', $credentials, $userProvider]);
        die;
    }

    /**
     * Called when authentication executed, but failed (e.g. wrong username password).
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the login page or a 403 response.
     *
     * If you return null, the request will continue, but the user will
     * not be authenticated. This is probably not what you want to do.
     *
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // TODO: Implement onAuthenticationFailure() method.
    }

    /**
     * Called when authentication executed and was successful!
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the last page they visited.
     *
     * If you return null, the current request will continue, and the user
     * will be authenticated. This makes sense, for example, with an API.
     *
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey The provider (i.e. firewall) key
     *
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // TODO: Implement onAuthenticationSuccess() method.
    }

    private function getClient(): OAuth2Client
    {
        return $this->registry->getClient('google');
    }
}

///**
//     * @var RouterInterface
//     */
//    private $router;
//
//    /**
//     * @var ClientRegistry
//     */
//    private $registry;
//
//    public function __construct(RouterInterface $router, ClientRegistry $registry)
//    {
//        $this->router = $router;
//        $this->registry = $registry;
//    }
//
//
//    /**
//     * Get the authentication credentials from the request and return them
//     * as any type (e.g. an associate array).
//     *
//     * Whatever value you return here will be passed to getUser() and checkCredentials()
//     *
//     * For example, for a form login, you might:
//     *
//     *      return array(
//     *          'username' => $request->request->get('_username'),
//     *          'password' => $request->request->get('_password'),
//     *      );
//     *
//     * Or for an API token that's on a header, you might use:
//     *
//     *      return array('api_key' => $request->headers->get('X-API-TOKEN'));
//     *
//     * @param Request $request
//     *
//     * @return mixed Any non-null value
//     *
//     * @throws \UnexpectedValueException If null is returned
//     */
//    public function getCredentials(Request $request)
//    {
//        dump($this->getClient()->fetchUser());
//        die;
//    }
//
//    /**
//     * Returns a response that directs the user to authenticate.
//     *
//     * This is called when an anonymous request accesses a resource that
//     * requires authentication. The job of this method is to return some
//     * response that "helps" the user start into the authentication process.
//     *
//     * Examples:
//     *  A) For a form login, you might redirect to the login page
//     *      return new RedirectResponse('/login');
//     *  B) For an API token authentication system, you return a 401 response
//     *      return new Response('Auth header required', 401);
//     *
//     * @param Request $request The request that resulted in an AuthenticationException
//     * @param AuthenticationException $authException The exception that started the authentication process
//     *
//     * @return Response
//     */
//    public function start(Request $request, AuthenticationException $authException = null)
//    {
//        dump(['start', $request, $authException]);
//        die;
//    }
//
//
//
//    /**
//     * Return a UserInterface object based on the credentials.
//     *
//     * The *credentials* are the return value from getCredentials()
//     *
//     * You may throw an AuthenticationException if you wish. If you return
//     * null, then a UsernameNotFoundException is thrown for you.
//     *
//     * @param mixed $credentials
//     * @param UserProviderInterface $userProvider
//     *
//     * @throws AuthenticationException
//     *
//     * @return UserInterface|null
//     */
//    public function getUser($credentials, UserProviderInterface $userProvider)
//    {
//        // TODO: Implement getUser() method.
//    }
//
//    /**
//     * Returns true if the credentials are valid.
//     *
//     * If any value other than true is returned, authentication will
//     * fail. You may also throw an AuthenticationException if you wish
//     * to cause authentication to fail.
//     *
//     * The *credentials* are the return value from getCredentials()
//     *
//     * @param mixed $credentials
//     * @param UserInterface $user
//     *
//     * @return bool
//     *
//     * @throws AuthenticationException
//     */
//    public function checkCredentials($credentials, UserInterface $user)
//    {
//        // TODO: Implement checkCredentials() method.
//    }
//
//    /**
//     * Create an authenticated token for the given user.
//     *
//     * If you don't care about which token class is used or don't really
//     * understand what a "token" is, you can skip this method by extending
//     * the AbstractGuardAuthenticator class from your authenticator.
//     *
//     * @see AbstractGuardAuthenticator
//     *
//     * @param UserInterface $user
//     * @param string $providerKey The provider (i.e. firewall) key
//     *
//     * @return GuardTokenInterface
//     */
//    public function createAuthenticatedToken(UserInterface $user, $providerKey)
//    {
//        // TODO: Implement createAuthenticatedToken() method.
//    }
//
//    /**
//     * Called when authentication executed, but failed (e.g. wrong username password).
//     *
//     * This should return the Response sent back to the user, like a
//     * RedirectResponse to the login page or a 403 response.
//     *
//     * If you return null, the request will continue, but the user will
//     * not be authenticated. This is probably not what you want to do.
//     *
//     * @param Request $request
//     * @param AuthenticationException $exception
//     *
//     * @return Response|null
//     */
//    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
//    {
//        // TODO: Implement onAuthenticationFailure() method.
//    }
//
//    /**
//     * Called when authentication executed and was successful!
//     *
//     * This should return the Response sent back to the user, like a
//     * RedirectResponse to the last page they visited.
//     *
//     * If you return null, the current request will continue, and the user
//     * will be authenticated. This makes sense, for example, with an API.
//     *
//     * @param Request $request
//     * @param TokenInterface $token
//     * @param string $providerKey The provider (i.e. firewall) key
//     *
//     * @return Response|null
//     */
//    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
//    {
//        // TODO: Implement onAuthenticationSuccess() method.
//    }
//
//    public function supportsRememberMe()
//    {
//        return false;
//    }
//
//    private function getClient(): OAuth2Client
//    {
//        return $this->registry->getClient('google');
//    }
//}
