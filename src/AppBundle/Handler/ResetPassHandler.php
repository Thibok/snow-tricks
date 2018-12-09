<?php

/**
 * Handle the reset pass (create form, valid form and set values)
 */

namespace AppBundle\Handler;

use Symfony\Component\Form\FormInterface;
use AppBundle\ParamChecker\CaptchaChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * ResetPassHandler
 */
class ResetPassHandler
{
    /**
     * @var CaptchaChecker
     * @access private
     */
    private $captchaChecker;

    /**
     * @var FormFactoryInterface
     * @access private
     */
    private $formFactory;

    /**
     * @var UserPasswordEncoderInterface
     * @access private
     */
    private $encoder;

    /**
     * Constructor
     * @access public
     * @param CaptchaChecker $captchaChecker
     * @param FormFactoryInterface $formFactory
     * @param UserPasswordEncoderInterface $encoder
     * 
     * @return void
     */
    public function __construct(
        CaptchaChecker $captchaChecker,
        FormFactoryInterface $formFactory,
        UserPasswordEncoderInterface $encoder
    ) {
        $this->captchaChecker = $captchaChecker;
        $this->formFactory = $formFactory;
        $this->encoder = $encoder;
    }

    /**
     * Create reset pass form
     * @access public
     * @param UserInterface $user
     * @return FormInterface
     */
    public function createForm(UserInterface $user)
    {
        $builder = $this->formFactory->createBuilder();

        $builder
            ->add('email', TextType::class, array(
                'constraints' => array(
                    new NotBlank(array('message' => 'You must enter your email !')),
                    new EqualTo(array(
                        'value' => $user->getEmail(),
                        'message' => 'The email entered does not match the one of the account'
                    ))
                )
            ))
            ->add('password', PasswordType::class, array(
                'constraints' => array(
                    new NotBlank(array('message' => 'You must enter an password !')),
                    new Length(array(
                        'min' => 8,
                        'max' => 48,
                        'minMessage' => 'The password must be at least 8 characters',
                        'maxMessage' => 'The password must be at most 48 characters'
                    )),
                    new Regex(array(
                        'pattern' => '/^(?=.*[0-9])(?=.*[a-zA-Z]).{8,}$/',
                        'message' => 'The password must contain at least one letter and one number'
                    ))
                )
            ))
        ;

        return $builder->getForm();
    }

    /**
     * Valid form and set new password for user
     * @access public
     * @param FormInterface $form
     * @param Request $request
     * @param UserInterface $user
     * @return boolean
     */
    public function validAndHandle(FormInterface $form, Request $request, UserInterface $user)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $this->captchaChecker->check() && $form->isValid()) {
            $data = $form->getData();
            
            $encode = $this->encoder->encodePassword($user, $data['password']);
            $user->setPassword($encode);

            return true;
        } 

        return false;
    }
}