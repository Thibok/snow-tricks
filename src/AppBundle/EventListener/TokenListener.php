<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Token;
use AppBundle\Generator\TokenGenerator;
use AppBundle\Purger\TokenPurger;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class TokenListener
{
    private $tokenGenerator;
    private $tokenPurger;

    public function __construct(TokenGenerator $tokenGenerator, TokenPurger $tokenPurger)
    {
        $this->tokenGenerator = $tokenGenerator;
        $this->tokenPurger = $tokenPurger;
    }

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
        $this->tokenPurger->setEntityManager($args->getObjectManager());
        $this->tokenPurger->purge($date);
    }
}