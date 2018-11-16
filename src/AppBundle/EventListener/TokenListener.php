<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Token;
use AppBundle\Generator\TokenGenerator;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class TokenListener
{
    private $tokenGenerator;

    public function __construct(TokenGenerator $tokenGenerator)
    {
        $this->tokenGenerator = $tokenGenerator;
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

        $expiration->add(new \DateInterval($interval));
        $token->setExpirationDate($expiration);
        $tokenCode = $this->tokenGenerator->generate(80);
        $token->setCode($tokenCode);
    }
}