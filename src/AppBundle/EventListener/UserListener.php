<?php

namespace AppBundle\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class UserListener
{
    public function prePersist(LifecycleEventArgs $args)
    {
        
    }
}