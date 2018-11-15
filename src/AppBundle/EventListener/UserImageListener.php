<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\UserImage;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class UserImageListener
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $userImage = $args->getObject();

        if (!$userImage instanceof UserImage) {
            return;
        }

        $file = $userImage->getFile();
        $extension = $file->guessExtension();
        $userImage->setExtension($extension);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $userImage = $args->getObject();

        if (!$userImage instanceof UserImage) {
            return;
        }
    }
}