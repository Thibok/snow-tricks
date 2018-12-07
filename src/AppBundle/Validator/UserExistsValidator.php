<?php

/**
 * Validator for validate user exists
 */

namespace AppBundle\Validator;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * UserExistsValidator
 */
class UserExistsValidator extends ConstraintValidator
{
    /**
     * @var EntityManagerInterface
     * @access private
     */
    private $manager;

    /**
     * Constructor
     * @access public
     * @param EntityManagerInterface $manager
     * 
     * @return void
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

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
        $exists = $this->manager->getRepository(User::class)->getUserExists($value);

        if ($exists == false) {
            $this->context->addViolation($constraint->message);
        }
    }
}