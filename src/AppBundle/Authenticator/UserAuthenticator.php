<?php

/**
 * Guard Authenticator
 */

namespace AppBundle\Authenticator;

use AppBundle\Validator\Captcha;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

/**
 * UserAuthenticator
 */
class UserAuthenticator extends AbstractFormLoginAuthenticator
{
    /**
     * @var UserPasswordEncoderInterface $encoder
     * @access private
     */
    private $encoder;

    /**
     * @var RouterInterface $router
     * @access private
     */
    private $router;

    /**
     * @var ValidatorInterface $validator
     * @access private
     */
    private $validator;

    /**
     * @var CsrfTokenManagerInterface $csrfTokenManager
     * @access private
     */
    private $csrfTokenManager;

    /**
     * Constructor
     * @access public
     * @param RouterInterface $router
     * @param UserPasswordEncoderInterface $encoder
     * @param ValidatorInterface $validator
     * @param CsrfTokenManagerInterface $csrfTokenManager
     * 
     * @return void
     */
    public function __construct(
        RouterInterface $router,
        UserPasswordEncoderInterface $encoder,
        ValidatorInterface $validator,
        CsrfTokenManagerInterface $csrfTokenManager
    ) {
        $this->router = $router;
        $this->encoder = $encoder;
        $this->validator = $validator;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'st_login'
            && $request->isMethod('POST');
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        $csrfToken = $request->request->get('_csrf_token');

        if (false === $this->csrfTokenManager->isTokenValid(new CsrfToken('authenticate', $csrfToken))) {
            throw new InvalidCsrfTokenException('Invalid CSRF token.');
        }

        $username = $request->request->get('_username');
        $request->getSession()->set(Security::LAST_USERNAME, $username);
        $password = $request->request->get('_password');
        $captcha = $request->request->get('g-recaptcha-response');
  
        return [
            'username' => $username,
            'password' => $password,
            'captcha' => $captcha
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $provider)
    {
        $captcha = $credentials['captcha'];
        $username = $credentials['username'];
        
        $captchaConstraint =  new Captcha();

        $errors = $this->validator->validate($captcha, $captchaConstraint);

        if (count($errors) != 0) {
            throw new CustomUserMessageAuthenticationException(
                $errors[0]->getMessage()
            );
        }

        return $provider->loadUserByUsername($username);
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        if (!$user->isEnabled()) {
            throw new CustomUserMessageAuthenticationException(
                'Your account is not active !'
            );
        }
        
        $password = $credentials['password'];

        if ($this->encoder->isPasswordValid($user, $password)) {
            return true;
        }

        throw new CustomUserMessageAuthenticationException(
            'Username or password is incorrect !'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $url = $this->getDefaultSuccessRedirectUrl();

        return new RedirectResponse($url);
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
       $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);

       $url = $this->getLoginUrl();

       return new RedirectResponse($url);
    }

    /**
     * {@inheritdoc}
     */
    protected function getLoginUrl()
    {
        return $this->router->generate('st_login');
    }

    /**
     * Get default url to redirect when auth success
     * @access protected
     *
     * @return string
     */
    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->router->generate('st_index');
    }

    /**
     * {@inheritdoc}
     */
    public function supportsRememberMe()
    {
        return false;
    }
}