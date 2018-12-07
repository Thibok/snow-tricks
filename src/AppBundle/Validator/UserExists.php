<?php

/**
 * UserExists Constraint
 */

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * UserExists
 */
class UserExists extends Constraint
{
    /**
     * @var string
     * @access public
     */
    public $message = "This user does not exist";

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