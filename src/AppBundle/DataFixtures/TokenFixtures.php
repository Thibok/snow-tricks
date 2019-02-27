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
    const TOKEN_RESET_PASS_BAD_USER_REFERENCE = 'token-reset-pass-bad_user';

    /**
     * @var string
     */
    const TOKEN_RESET_PASS_EXPIRED_REFERENCE = 'token-reset-pass-expired';

    /**
     * @var string
     */
    const TOKEN_VALID_REGISTRATION_EXPIRED_REFERENCE = 'token-valid-registration_expired';

    /**
     * Load fixtures
     * @access public
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $actualDate = new \DateTime;
        $expiredDate = $actualDate->sub(new \DateInterval('P1D'));

        $token = new Token;
        $token->setCode('c15b26a3d01aa113ed235d570ca43d621a552be7c9821aab8238a40f40b53e686689559629535112');
        $token->setType('registration');

        $tokenInactiveUser = new Token;
        $tokenInactiveUser->setCode('c15b26a3d01aa113ed235d570ca43d621a552be7c9lk1aa88238a40f40b53e666682559429535112');
        $tokenInactiveUser->setType('registration');

        $tokenEnabledUser = new Token;
        $tokenEnabledUser->setCode('c15b26a3d01aa113ed2fcd5e52a43d621a552be7c9821aab8238a40f40b53e686689559629535112');
        $tokenEnabledUser->setType('registration');

        $expiredValidRegistrationToken = new Token;
        $expiredValidRegistrationToken->setCode(
            'w1fb48a3d01aa113ed2fcd5e52a43d621a552be7c9821aab8238a40f40b53868668v5596h95351lo'
        );
        $expiredValidRegistrationToken->setType('registration');
        $expiredValidRegistrationToken->setExpirationDate($expiredDate);

        $tokenResetPassUser = new Token;
        $tokenResetPassUser->setCode('k15b26a3d01aaoo2ed2f8efe52a43d621a552be7c9821aab8238a4dc40b53e600689559629535115');
        $tokenResetPassUser->setType('reset-pass');

        $tokenResetPassBadUser = new Token;
        $tokenResetPassBadUser->setCode('k15b26a3d01aaoo2ed2f8effffa42d621a554be7c9821aab8238a4dc4et53e600689486629535115');
        $tokenResetPassBadUser->setType('reset-pass');

        $expiredResetPassToken = new Token;
        $expiredResetPassToken->setCode('u15b26a3d01aaoo2ed2f8efkzfa42d621a554be8c9821aab8238a4dc4et53e6006c9482629535115');
        $expiredResetPassToken->setType('reset-pass');
        $expiredResetPassToken->setExpirationDate($expiredDate);

        $manager->persist($token);
        $manager->persist($tokenEnabledUser);
        $manager->persist($expiredValidRegistrationToken);
        $manager->persist($tokenInactiveUser);
        $manager->persist($tokenResetPassUser);
        $manager->persist($tokenResetPassBadUser);
        $manager->persist($expiredResetPassToken);
        $manager->flush();

        $this->addReference(self::VALID_TOKEN_REGISTRATION_REFERENCE, $token);
        $this->addReference(self::TOKEN_ENABLED_USER_REFERENCE, $tokenEnabledUser);
        $this->addReference(self::TOKEN_INACTIVE_USER_REFERENCE, $tokenInactiveUser);
        $this->addReference(self::TOKEN_RESET_PASS_USER_REFERENCE, $tokenResetPassUser);
        $this->addReference(self::TOKEN_RESET_PASS_BAD_USER_REFERENCE, $tokenResetPassBadUser);
        $this->addReference(self::TOKEN_RESET_PASS_EXPIRED_REFERENCE, $expiredResetPassToken);
        $this->addReference(self::TOKEN_VALID_REGISTRATION_EXPIRED_REFERENCE, $expiredValidRegistrationToken);
    }
}