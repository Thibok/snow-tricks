<?php

namespace AppBundle\Purger;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserPurger
{
    private $entityManager;

    public function purge(\DateTime $date)
    {
        $repo = $this->entityManager->getRepository(User::class);

        $users = $repo->getInactiveUsers($date);

        foreach ($users as $user) {
            $this->entityManager->remove($user);
        }
    }

    public function setEntityManager(EntityManagerInterface $em)
    {
        $this->entityManager = $entityManager;
    }
}