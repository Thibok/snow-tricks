<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Trick;
use AppBundle\Slugger\Slugger;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class TrickListener
{
    private $slugger;

    public function __construct(Slugger $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $trick = $args->getObject();

        if (!$trick instanceof Trick) {
            return;
        }

        $name = $trick->getName();
        $slug = $this->slugger->slugify($name);
        $trick->setSlug($slug);
    }
}