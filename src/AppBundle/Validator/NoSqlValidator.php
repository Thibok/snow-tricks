<?php

/**
 * Validator for validate a NoSQL value.
 */

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * NoSql Validator
 */
class NoSqlValidator extends ConstraintValidator
{
    /**
     * Valid value
     * @access public
     * @param string $value
     * @param Constraint $constraint
     * 
     * @return void
     */
    public function validate($value, Constraint $constraint)
    {
        if (preg_match("#drop|delete|update|insert|union|select|where|like|create|set|join#i", $value)) {
            $this->context->addViolation($constraint->message);
        }
    }
}