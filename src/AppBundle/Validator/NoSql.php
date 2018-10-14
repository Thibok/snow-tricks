<?php

/**
 * NoSql Constraint
 */

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * NoSql
 * @Annotation
 */
class NoSql extends Constraint
{
    /**
     * @var string
     * @access public
     */
    public $message = "Certains mots ne sont pas autorisé !";

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