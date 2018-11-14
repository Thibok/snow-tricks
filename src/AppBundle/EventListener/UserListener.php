<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserListener
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
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
}