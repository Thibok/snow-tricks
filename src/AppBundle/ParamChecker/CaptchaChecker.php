<?php

/**
 * Check the captcha
 */

namespace AppBundle\ParamChecker;

use AppBundle\Validator\Captcha;
use AppBundle\Validator\CaptchaValidator;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Captcha Checker
 */
class CaptchaChecker
{
    /**
     * @var CaptchaValidator
     * @access private
     */
    private $captchaValidator;

    /**
     * @var RequestStack
     * @access private
     */
    private $request;
    
    /**
     * Constructor
     *
     * @param CaptchaValidator $captchaValidator
     * @param RequestStack $requestStack
     */
    public function __construct(CaptchaValidator $captchaValidator, RequestStack $request)
    {
        $this->captchaValidator = $captchaValidator;
        $this->request = $request;
    }

    /**
     * Check the value of captcha with CaptchaValidator
     *
     * @param string $value
     * 
     * @return boolean
     */
    public function check($value)
    {
        $currentRequest = $this->request->getCurrentRequest();
        $captcha = $request->request->get('g-recaptcha-response');
        $constraint = new Captcha;

        $errors = $this->captchaValidator($captcha, $constraint);

        if (count($errors) > 0) {
            $currentRequest->getSession()->getFlashBag()->add('error', $constraint->message);
            return false;
        }

        return true;
    }
}