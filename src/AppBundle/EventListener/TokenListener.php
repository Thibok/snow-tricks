<?php

/**
 * User Token listener
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\Token;
use AppBundle\Generator\TokenGenerator;
use AppBundle\Purger\TokenPurger;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

/**
 * TokenListener
 */
class TokenListener
{
    /**
     * @var TokenGenerator
     * @access private
     */
    private $tokenGenerator;

    /**
     * @var TokenPurger
     * @access private
     */
    private $tokenPurger;

    /**
     * Constructor
     * @access public
     * @param TokenGenerator $tokenGenerator
     * @param TokenPurger $tokenPurger
     * 
     * @return void
     */
    public function __construct(TokenGenerator $tokenGenerator, TokenPurger $tokenPurger)
    {
        $this->tokenGenerator = $tokenGenerator;
        $this->tokenPurger = $tokenPurger;
    }

    /**
     * Listen Pre Persist event of Token
     * @access public
     * @param LifecycleEventArgs $args
     *
     * @return void
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $token = $args->getObject();

        if (!$token instanceof Token) {
            return;
        }

        $expiration = new \DateTime;

        if ($token->getType() == 'registration') {
            $interval = 'P1W';
        }

        if ($token->getCode() == null) {
            $tokenCode = $this->tokenGenerator->generate(80);
            $token->setCode($tokenCode);
        }

        if ($token->getExpirationDate() == null) {
            $expiration->add(new \DateInterval($interval));
            $token->setExpirationDate($expiration);
        }
        
        $date = new \DateTime;
        $this->tokenPurger->setManager($args->getObjectManager());
        $this->tokenPurger->purge($date);
    }
}