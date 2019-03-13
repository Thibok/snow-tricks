<?php

/**
 * Load Token Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Token;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * TokenFixtures
 */
class TokenFixtures extends Fixture implements ContainerAwareInterface
{
    /**
     * @var string
     */
    const VALID_TOKEN_REGISTRATION_TEST_REFERENCE = 'registration-token-test';

    /**
     * @var string
     */
    const TOKEN_ENABLED_USER_TEST_REFERENCE = 'token-enabled-user-test';

    /**
     * @var string
     */
    const TOKEN_INACTIVE_USER_TEST_REFERENCE = 'token-inactive-user-test';

    /**
     * @var string
     */
    const TOKEN_RESET_PASS_USER_TEST_REFERENCE = 'token-reset-pass-user-test';

    /**
     * @var string
     */
    const TOKEN_RESET_PASS_BAD_USER_TEST_REFERENCE = 'token-reset-pass-bad-user-test';

    /**
     * @var string
     */
    const TOKEN_RESET_PASS_EXPIRED_TEST_REFERENCE = 'token-reset-pass-expired-test';

    /**
     * @var string
     */
    const TOKEN_VALID_REGISTRATION_EXPIRED_TEST_REFERENCE = 'token-valid-registration-expired-test';

    /**
     * @var string
     */
    const TOKEN_DEMO_REFERENCE = 'token-demo';

    /**
     * @var ContainerInterface
     * @access private
     */
    private $container;

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $env = $this->container->get('kernel')->getEnvironment();

        if ($env == 'test') {
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
        }

        if ($env == 'dev') {
            $tokenDemo = new Token;
            $tokenDemo->setCode('515b19a3p01aa951ed235d570ca43d621a552ue7c9lj1aa68238a40f40b53e4666qvsz94f953c11p');
            $tokenDemo->setType('registration');

            $manager->persist($tokenDemo);
        }
        
        $manager->flush();

        if ($env == 'test') {
            $this->addReference(self::VALID_TOKEN_REGISTRATION_TEST_REFERENCE, $token);
            $this->addReference(self::TOKEN_ENABLED_USER_TEST_REFERENCE, $tokenEnabledUser);
            $this->addReference(self::TOKEN_INACTIVE_USER_TEST_REFERENCE, $tokenInactiveUser);
            $this->addReference(self::TOKEN_RESET_PASS_USER_TEST_REFERENCE, $tokenResetPassUser);
            $this->addReference(self::TOKEN_RESET_PASS_BAD_USER_TEST_REFERENCE, $tokenResetPassBadUser);
            $this->addReference(self::TOKEN_RESET_PASS_EXPIRED_TEST_REFERENCE, $expiredResetPassToken);
            $this->addReference(self::TOKEN_VALID_REGISTRATION_EXPIRED_TEST_REFERENCE, $expiredValidRegistrationToken);
        }

        if ($env == 'dev') {
            $this->addReference(self::TOKEN_DEMO_REFERENCE, $tokenDemo);
        }
    }

    /**
     * @inheritDoc
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}