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

    /**
     * @var string
     */
    const TOKEN_ENABLED_USER_REFERENCE = 'token-enabled-user';

    /**
     * @var string
     */
    const TOKEN_INACTIVE_USER_REFERENCE = 'token-inactive-user';

    /**
     * @var string
     */
    const TOKEN_RESET_PASS_USER_REFERENCE = 'token-reset-pass-user';

    /**
     * @var string
     */
    const TOKEN_RESET_PASS_OTHER_USER_REFERENCE = 'token-reset-pass-other-user';

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

        $tokenInactiveUser = new Token;
        $tokenInactiveUser->setCode('c15b26a3d01aa113ed235d570ca43d621a552be7c9lk1aa88238a40f40b53e666682559429535112');
        $tokenInactiveUser->setType('registration');

        $tokenEnabledUser = new Token;
        $tokenEnabledUser->setCode('c15b26a3d01aa113ed2fcd5e52a43d621a552be7c9821aab8238a40f40b53e686689559629535112');
        $tokenEnabledUser->setType('registration');

        $tokenResetPassUser = new Token;
        $tokenResetPassUser->setCode('k15b26a3d01aaoo2ed2f8efe52a43d621a552be7c9821aab8238a4dc40b53e600689559629535115');
        $tokenResetPassUser->setType('reset-pass');

        $tokenResetPassOtherUser = new Token;
        $tokenResetPassOtherUser->setCode('k15b26a3d01aaoo2ed2f8effffa42d621a554be7c9821aab8238a4dc4et53e600689486629535115');
        $tokenResetPassOtherUser->setType('reset-pass');

        $manager->persist($token);
        $manager->persist($tokenEnabledUser);
        $manager->persist($tokenInactiveUser);
        $manager->persist($tokenResetPassUser);
        $manager->persist($tokenResetPassOtherUser);
        $manager->flush();

        $this->addReference(self::VALID_TOKEN_REGISTRATION_REFERENCE, $token);
        $this->addReference(self::TOKEN_ENABLED_USER_REFERENCE, $tokenEnabledUser);
        $this->addReference(self::TOKEN_INACTIVE_USER_REFERENCE, $tokenInactiveUser);
        $this->addReference(self::TOKEN_RESET_PASS_USER_REFERENCE, $tokenResetPassUser);
        $this->addReference(self::TOKEN_RESET_PASS_OTHER_USER_REFERENCE, $tokenResetPassOtherUser);
    }
}