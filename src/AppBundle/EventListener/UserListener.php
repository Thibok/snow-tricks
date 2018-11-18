<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserListener
{
    private $encoder;
    private $mailer;
    private $twig;

    public function __construct(UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer, \Twig_Environment $twig, $sender)
    {
        $this->encoder = $encoder;
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->sender = $sender;
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
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $user = $args->getObject();

        if (!$user instanceof User) {
            return;
        }

        $message = (new \Swift_Message('Welcome to SnowTricks !'))
        ->setFrom([$this->sender => 'SnowTricks'])
        ->setTo($user->getEmail())
        ->setBody(
            $this->twig->render(
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