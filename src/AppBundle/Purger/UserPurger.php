<?php

namespace AppBundle\Purger;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserPurger
{
    private $manager;

    public function purge(\DateTime $date)
    {
        $repo = $this->manager->getRepository(User::class);

        $users = $repo->getInactiveUsers($date);

        foreach ($users as $user) {
            $this->manager->remove($user);
        }
    }

    public function setManager(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
}