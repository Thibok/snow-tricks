<?php

namespace AppBundle\Purger;

use AppBundle\Entity\Token;
use Doctrine\ORM\EntityManagerInterface;

class TokenPurger
{
    private $manager;

    public function purge(\DateTime $date)
    {
        $repo = $this->manager->getRepository(Token::class);

        $tokens = $repo->getExpiredTokens($date);

        foreach ($tokens as $token) {
            $this->manager->remove($token);
        }
    }

    public function setManager(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
}