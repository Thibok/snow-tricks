<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use AppBundle\Mailer\Mailer;
use AppBundle\Purger\UserPurger;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserListener
{
    private $encoder;
    private $mailer;
    private $purger;

    public function __construct(UserPasswordEncoderInterface $encoder, Mailer $mailer, UserPurger $purger)
    {
        $this->encoder = $encoder;
        $this->mailer = $mailer;
        $this->purger = $purger;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $user = $args->getObject();

        if (!$user instanceof User) {
            return;
        }

        $encoded = $this->encoder->encodePassword($user, $user->getPassword());

        $user->setPassword($encoded);
        $user->setRoles(['ROLE_MEMBER']);

        $this->purger->setEntityManager($args->getObjectManager());

        $date = new \DateTime;
        $date->sub(new \DateInterval('P1W'));

        $this->purger->purge($date);
    }

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
}