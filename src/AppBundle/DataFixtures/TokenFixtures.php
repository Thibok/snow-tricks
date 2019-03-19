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

            $tok = new Token;
            $tok->setCode('c15b26a3d01aa113ed235d570ca43d621a552be7c9821aab8238a40f40b53e686689559629535112');
            $tok->setType('registration');

            $tokInactiveUser = new Token;
            $tokInactiveUser->setCode('c15b26a3d01aa113ed235d570ca43d621a552be7c9lk1aa88238a40f40b53e666682559429535112');
            $tokInactiveUser->setType('registration');

            $tokEnabledUser = new Token;
            $tokEnabledUser->setCode('c15b26a3d01aa113ed2fcd5e52a43d621a552be7c9821aab8238a40f40b53e686689559629535112');
            $tokEnabledUser->setType('registration');

            $expiredValidRegistrationTok = new Token;
            $expiredValidRegistrationTok->setCode(
                'w1fb48a3d01aa113ed2fcd5e52a43d621a552be7c9821aab8238a40f40b53868668v5596h95351lo'
            );
            $expiredValidRegistrationTok->setType('registration');
            $expiredValidRegistrationTok->setExpirationDate($expiredDate);

            $tokResetPassUser = new Token;
            $tokResetPassUser->setCode('k15b26a3d01aaoo2ed2f8efe52a43d621a552be7c9821aab8238a4dc40b53e600689559629535115');
            $tokResetPassUser->setType('reset-pass');

            $tokResetPassBadUser = new Token;
            $tokResetPassBadUser->setCode('k15b26a3d01aaoo2ed2f8effffa42d621a554be7c9821aab8238a4dc4et53e600689486629535115');
            $tokResetPassBadUser->setType('reset-pass');

            $expiredResetPassTok = new Token;
            $expiredResetPassTok->setCode('u15b26a3d01aaoo2ed2f8efkzfa42d621a554be8c9821aab8238a4dc4et53e6006c9482629535115');
            $expiredResetPassTok->setType('reset-pass');
            $expiredResetPassTok->setExpirationDate($expiredDate);

            $manager->persist($tok);
            $manager->persist($tokEnabledUser);
            $manager->persist($expiredValidRegistrationTok);
            $manager->persist($tokInactiveUser);
            $manager->persist($tokResetPassUser);
            $manager->persist($tokResetPassBadUser);
            $manager->persist($expiredResetPassTok);
        }

        if ($env == 'dev') {
            $tokDemo = new Token;
            $tokDemo->setCode('515b19a3p01aa951ed235d570ca43d621a552ue7c9lj1aa68238a40f40b53e4666qvsz94f953c11p');
            $tokDemo->setType('registration');

            $manager->persist($tokDemo);
        }
        
        $manager->flush();

        if ($env == 'test') {
            $this->addReference(self::VALID_TOKEN_REGISTRATION_TEST_REFERENCE, $tok);
            $this->addReference(self::TOKEN_ENABLED_USER_TEST_REFERENCE, $tokEnabledUser);
            $this->addReference(self::TOKEN_INACTIVE_USER_TEST_REFERENCE, $tokInactiveUser);
            $this->addReference(self::TOKEN_RESET_PASS_USER_TEST_REFERENCE, $tokResetPassUser);
            $this->addReference(self::TOKEN_RESET_PASS_BAD_USER_TEST_REFERENCE, $tokResetPassBadUser);
            $this->addReference(self::TOKEN_RESET_PASS_EXPIRED_TEST_REFERENCE, $expiredResetPassTok);
            $this->addReference(self::TOKEN_VALID_REGISTRATION_EXPIRED_TEST_REFERENCE, $expiredValidRegistrationTok);
        }

        if ($env == 'dev') {
            $this->addReference(self::TOKEN_DEMO_REFERENCE, $tokDemo);
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