<?php

/**
 * Trick Listener
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\Trick;
use AppBundle\Slugger\Slugger;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

/**
 * TrickListener
 */
class TrickListener
{
    /**
     * @var Slugger
     * @access private
     */
    private $slugger;

    /**
     * Constructor
     * @access public
     * @param Slugger $slugger
     * 
     * @return void
     */
    public function __construct(Slugger $slugger)
    {
        $this->slugger = $slugger;
    }

    /**
     * Listen prePersist event of Trick
     * @access public
     * @param LifecycleEventArgs $args
     * 
     * @return void
     */
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