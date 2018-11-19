<?php

namespace AppBundle\Purger;

use AppBundle\Entity\Token;
use Doctrine\ORM\EntityManagerInterface;

class TokenPurger
{
    private $entityManager;

    public function purge(\DateTime $date)
    {
        $repo = $this->entityManager->getRepository(Token::class);

        $tokens = $repo->getExpiredTokens($date);

        foreach ($tokens as $token) {
            $this->entityManager->remove($token);
        }
    }

    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}