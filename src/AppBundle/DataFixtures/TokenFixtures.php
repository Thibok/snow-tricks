<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Token;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TokenFixtures extends Fixture
{
    const VALID_TOKEN_REGISTRATION_REFERENCE = 'registration-token';

    public function load(ObjectManager $manager)
    {
        $token = new Token;
        $token->setCode('c15b26a3d01aa113ed235d570ca43d621a552be7c9821aab8238a40f40b53e686689559629535112');
        $token->setType('registration');

        $manager->persist($token);
        $manager->flush();

        $this->addReference(self::VALID_TOKEN_REGISTRATION_REFERENCE, $token);
    }
}