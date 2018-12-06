<?php

/**
 * User Listener
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use AppBundle\Mailer\Mailer;
use AppBundle\Purger\UserPurger;
use AppBundle\Event\UserPostForgotEvent;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * UserListener
 */
class UserListener
{
    /**
     * @var UserPasswordEncoderInterface
     * @access private
     */
    private $encoder;

    /**
     * @var Mailer
     * @access private
     */
    private $mailer;

    /**
     * @var UserPurger
     * @access private
     */
    private $purger;

    /**
     * Constructor
     * @access public
     * @param UserPasswordEncoderInterface $encoder
     * @param Mailer $mailer
     * @param UserPurger $purger
     * 
     * @return void
     */
    public function __construct(UserPasswordEncoderInterface $encoder, Mailer $mailer, UserPurger $purger)
    {
        $this->encoder = $encoder;
        $this->mailer = $mailer;
        $this->purger = $purger;
    }

    /**
     * Listen Pre Persist event of User
     * @access public
     * @param LifecycleEventArgs $args
     * 
     * @return void
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $user = $args->getObject();

        if (!$user instanceof User) {
            return;
        }

        $encoded = $this->encoder->encodePassword($user, $user->getPassword());

        $user->setPassword($encoded);
        $user->setRoles(['ROLE_MEMBER']);

        $this->purger->setManager($args->getObjectManager());

        $date = new \DateTime;
        $date->sub(new \DateInterval('P1W'));

        $this->purger->purge($date);
    }

    /**
     * Listen Post Persist event of User
     * @access public
     * @param LifecycleEventArgs $args
     * 
     * @return void
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $user = $args->getObject();

        if (!$user instanceof User) {
            return;
        }

        $message = (new \Swift_Message('Welcome to SnowTricks !'))
        ->setFrom([$this->mailer->getSender() => 'SnowTricks'])
        ->setTo($user->getEmail())
        ->setBody(
            $this->mailer->getTwig()->render(
                'emails/registration.html.twig',
                array(
                    'firstName' => $user->getFirstName(),
                    'token' => $user->getToken()->getCode()
                )
            ),
            'text/html'
        );

        $this->mailer->send($message);
    }

    public function postForgot(UserPostForgotEvent $event)
    {
        $user = $event->getUser();

        $message = (new \Swift_Message('Reset your password'))
        ->setFrom([$this->mailer->getSender() => 'SnowTricks'])
        ->setTo($user->getEmail())
        ->setBody(
            $this->mailer->getTwig()->render(
                'emails/reset_pass.html.twig',
                array(
                    'firstName' => $user->getFirstName(),
                    'token' => $user->getToken()->getCode()
                )
            ),
            'text/html'
        );

        $this->mailer->send($message);
    }
}