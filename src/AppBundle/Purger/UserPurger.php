<?php

/**
 * User Purger
 */

namespace AppBundle\Purger;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * UserPurger
 */
class UserPurger
{
    /**
     * @var EntityManagerInterface
     * @access private
     */
    private $manager;

    /**
     * Purge inactive users in database
     * @access public
     * @param \DateTime $date
     * 
     * @return void
     */
    public function purge(\DateTime $date)
    {
        $repo = $this->manager->getRepository(User::class);

        $users = $repo->getInactiveUsers($date);

        foreach ($users as $user) {
            $this->manager->remove($user);
        }
    }

    /**
     * Set manager
     * @access public
     * @param EntityManagerInterface $manager
     * 
     * @return void
     */
    public function setManager(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
}