<?php

/**
 * Captcha Constraint
 */

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Captcha
 */
class Captcha extends Constraint
{
    /**
     * @var string
     * @access public
     */
    public $message = "Captcha not valid !";

    /**
     * Return ths name of validator
     * @access public
     * 
     * @return string
     */
    public function validateBy()
    {
        return \get_class($this).'Validator';
    }
}