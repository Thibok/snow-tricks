<?php

/**
 * Token Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Token;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * TokenFixtures
 */
class TokenFixtures extends Fixture
{
    /**
     * @var string
     */
    const VALID_TOKEN_REGISTRATION_REFERENCE = 'registration-token';
    const TOKEN_ENABLED_USER_REFERENCE = 'token-enabled-user';

    /**
     * Load fixtures
     * @access public
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $token = new Token;
        $token->setCode('c15b26a3d01aa113ed235d570ca43d621a552be7c9821aab8238a40f40b53e686689559629535112');
        $token->setType('registration');

        $tokenEnabledUser = new Token;
        $tokenEnabledUser->setCode('c15b26a3d01aa113ed2fcd5e52a43d621a552be7c9821aab8238a40f40b53e686689559629535112');
        $tokenEnabledUser->setType('registration');

        $manager->persist($token);
        $manager->persist($tokenEnabledUser);
        $manager->flush();

        $this->addReference(self::VALID_TOKEN_REGISTRATION_REFERENCE, $token);
        $this->addReference(self::TOKEN_ENABLED_USER_REFERENCE, $tokenEnabledUser);
    }
}