<?php

/**
 * Handle Comment (handle request, validate form)
 */

namespace AppBundle\Handler;

use Symfony\Component\Form\FormInterface;
use AppBundle\ParamChecker\CaptchaChecker;
use Symfony\Component\HttpFoundation\Request;

/**
 * CommentHandler
 */
class CommentHandler
{
    /**
     * @var CaptchaChecker
     * @access private
     */
    private $captchaChecker;

    /**
     * Constructor
     * @access public
     * @param CaptchaChecker $captchaChecker
     * 
     * @return void
     */
    public function __construct(CaptchaChecker $captchaChecker)
    {
        $this->captchaChecker = $captchaChecker;
    }

    /**
     * Validate form
     * @access public
     * @param FormInterface $form
     * @param Request $request
     * 
     * @return boolean
     */
    public function validateForm(FormInterface $form, Request $request)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $this->captchaChecker->check() && $form->isValid()) {
            
            return true;
        } 

        return false;
    }
}