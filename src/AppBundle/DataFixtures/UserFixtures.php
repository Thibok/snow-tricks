<?php

/**
 * Load User Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use AppBundle\DataFixtures\TokenFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use AppBundle\DataFixtures\UserImageFixtures;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * UserFixtures
 */
class UserFixtures extends Fixture implements DependentFixtureInterface, ContainerAwareInterface
{
    /**
     * @var string
     */
    const ENABLED_USER_TEST_REFERENCE = 'user-enabled-test';

    /**
     * @var string
     */
    const USER_DEMO_REFERENCE = 'user-demo';

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
            $usr = new User;
            $usr->setUsername('GoodUser');
            $usr->setEmail('good@email.com');
            $usr->setPassword('verystrongpassword12');
            $usr->setName('Test');
            $usr->setFirstName('Bryan');
            $usr->setToken($this->getReference(TokenFixtures::VALID_TOKEN_REGISTRATION_TEST_REFERENCE));
            $usr->setImage($this->getReference(UserImageFixtures::VALID_REGISTRATION_USERIMAGE_TEST_REFERENCE));

            $inactiveUsr = new User;
            $inactiveUsr->setUsername('InactiveUser');
            $inactiveUsr->setEmail('bad@email.com');
            $inactiveUsr->setPassword('verystrongpassword1222');
            $inactiveUsr->setName('TestInactive');
            $inactiveUsr->setFirstName('BryanDisabled');
            $inactiveUsr->setToken($this->getReference(TokenFixtures::TOKEN_INACTIVE_USER_TEST_REFERENCE));
            $inactiveUsr->setImage($this->getReference(UserImageFixtures::USERIMAGE_INACTIVE_USER_TEST_REFERENCE));

            $usrEnabled = new User;
            $usrEnabled->setUsername('EnabledUser');
            $usrEnabled->setEmail('goodie@email.com');
            $usrEnabled->setPassword('verystrongpassword123');
            $usrEnabled->setName('TestEnabled');
            $usrEnabled->setFirstName('BryanEnabled');
            $usrEnabled->setIsActive(true);
            $usrEnabled->setToken($this->getReference(TokenFixtures::TOKEN_ENABLED_USER_TEST_REFERENCE));
            $usrEnabled->setImage($this->getReference(UserImageFixtures::USERIMAGE_ENABLED_USER_TEST_REFERENCE));

            $usrResetPass = new User;
            $usrResetPass->setUsername('ResetPassUser');
            $usrResetPass->setEmail('resetpass@email.com');
            $usrResetPass->setPassword('verystrongpassword1234');
            $usrResetPass->setName('TestResetPass');
            $usrResetPass->setFirstName('BryanResetPass');
            $usrResetPass->setIsActive(true);
            $usrResetPass->setToken($this->getReference(TokenFixtures::TOKEN_RESET_PASS_USER_TEST_REFERENCE));
            $usrResetPass->setImage($this->getReference(UserImageFixtures::USERIMAGE_RESET_PASS_USER_TEST_REFERENCE));

            $usrBadResetPass = new User;
            $usrBadResetPass->setUsername('ResetPassOtherUser');
            $usrBadResetPass->setEmail('resetpasss@email.com');
            $usrBadResetPass->setPassword('verystrongpassword12345');
            $usrBadResetPass->setName('TestOtherResetPass');
            $usrBadResetPass->setFirstName('BryanOtherResetPass');
            $usrBadResetPass->setIsActive(true);
            $usrBadResetPass->setToken($this->getReference(TokenFixtures::TOKEN_RESET_PASS_BAD_USER_TEST_REFERENCE));
            $usrBadResetPass->setImage($this->getReference(UserImageFixtures::USERIMAGE_RESET_PASS_BAD_TEST_REFERENCE));

            $usrResetPassExpiredToken = new User;
            $usrResetPassExpiredToken->setUsername('IWantResetMyPass');
            $usrResetPassExpiredToken->setEmail('resetmypass@email.com');
            $usrResetPassExpiredToken->setPassword('verystrongpassword123456');
            $usrResetPassExpiredToken->setName('TestMyResetPass');
            $usrResetPassExpiredToken->setFirstName('ResetReset');
            $usrResetPassExpiredToken->setToken($this->getReference(TokenFixtures::TOKEN_RESET_PASS_EXPIRED_TEST_REFERENCE));
            $usrResetPassExpiredToken->setImage($this->getReference(UserImageFixtures::USERIMAGE_RESET_PASS_EXPIRED_TEST_REFERENCE));

            $usrValidRegistrationExpired = new User;
            $usrValidRegistrationExpired->setUsername('ValidMyRegistration');
            $usrValidRegistrationExpired->setEmail('validregister@email.com');
            $usrValidRegistrationExpired->setPassword('verystrongpassword1234567');
            $usrValidRegistrationExpired->setName('TestBadValidRegister');
            $usrValidRegistrationExpired->setFirstName('BadRegistration');
            $usrValidRegistrationExpired->setToken($this->getReference(TokenFixtures::TOKEN_VALID_REGISTRATION_EXPIRED_TEST_REFERENCE));
            $usrValidRegistrationExpired->setImage($this->getReference(UserImageFixtures::USERIMAGE_VALID_REGISTRATION_EXPIRED_TEST_REFERENCE));

            $manager->persist($usr);
            $manager->persist($usrEnabled);
            $manager->persist($inactiveUsr);
            $manager->persist($usrResetPass);
            $manager->persist($usrBadResetPass);
            $manager->persist($usrResetPassExpiredToken);
            $manager->persist($usrValidRegistrationExpired);
        }

        if ($env == 'dev') {
            $demoUsrname = $this->container->getParameter('demo_user_username');
            $demoPassword = $this->container->getParameter('demo_user_password');

            $demoUsr = new User;
            $demoUsr->setUsername($demoUsrname);
            $demoUsr->setEmail('demobryantrickemail@yahoo.com');
            $demoUsr->setPassword($demoPassword);
            $demoUsr->setName('Trick');
            $demoUsr->setFirstName('Bryan');
            $demoUsr->setIsActive(true);
            $demoUsr->setToken($this->getReference(TokenFixtures::TOKEN_DEMO_REFERENCE));
            $demoUsr->setImage($this->getReference(UserImageFixtures::USERIMAGE_DEMO_REFERENCE));

            $manager->persist($demoUsr);
        }

        $manager->flush();

        if ($env == 'test') {
            $this->addReference(self::ENABLED_USER_TEST_REFERENCE, $usrEnabled);
        }

        if ($env == 'dev') {
            $this->addReference(self::USER_DEMO_REFERENCE, $demoUsr);
        }
    }

    /**
     * @inheritDoc
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return array(
            TokenFixtures::class,
            UserImageFixtures::class
        );
    }
}