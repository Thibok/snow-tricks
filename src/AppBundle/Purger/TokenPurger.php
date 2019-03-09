<?php

/**
 * Token Purger
 */

namespace AppBundle\Purger;

use AppBundle\Entity\Token;
use Doctrine\ORM\EntityManagerInterface;

/**
 * TokenPurger
 */
class TokenPurger
{
    /**
     * @var EntityManagerInterface
     * @access private
     */
    private $manager;

    /**
     * Purge expired tokens in database
     * @access public
     * @param \DateTime $date
     * 
     * @return void
     */
    public function purge(\DateTime $date)
    {
        $repo = $this->manager->getRepository(Token::class);

        $tokens = $repo->getExpiredTokens($date);

        foreach ($tokens as $token) {
            $this->manager->remove($token);
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