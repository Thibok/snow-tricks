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
            $user = new User;
            $user->setUsername('GoodUser');
            $user->setEmail('good@email.com');
            $user->setPassword('verystrongpassword12');
            $user->setName('Test');
            $user->setFirstName('Bryan');
            $user->setToken($this->getReference(TokenFixtures::VALID_TOKEN_REGISTRATION_TEST_REFERENCE));
            $user->setImage($this->getReference(UserImageFixtures::VALID_REGISTRATION_USERIMAGE_TEST_REFERENCE));

            $inactiveUser = new User;
            $inactiveUser->setUsername('InactiveUser');
            $inactiveUser->setEmail('bad@email.com');
            $inactiveUser->setPassword('verystrongpassword1222');
            $inactiveUser->setName('TestInactive');
            $inactiveUser->setFirstName('BryanDisabled');
            $inactiveUser->setToken($this->getReference(TokenFixtures::TOKEN_INACTIVE_USER_TEST_REFERENCE));
            $inactiveUser->setImage($this->getReference(UserImageFixtures::USERIMAGE_INACTIVE_USER_TEST_REFERENCE));

            $userEnabled = new User;
            $userEnabled->setUsername('EnabledUser');
            $userEnabled->setEmail('goodie@email.com');
            $userEnabled->setPassword('verystrongpassword123');
            $userEnabled->setName('TestEnabled');
            $userEnabled->setFirstName('BryanEnabled');
            $userEnabled->setIsActive(true);
            $userEnabled->setToken($this->getReference(TokenFixtures::TOKEN_ENABLED_USER_TEST_REFERENCE));
            $userEnabled->setImage($this->getReference(UserImageFixtures::USERIMAGE_ENABLED_USER_TEST_REFERENCE));

            $userResetPass = new User;
            $userResetPass->setUsername('ResetPassUser');
            $userResetPass->setEmail('resetpass@email.com');
            $userResetPass->setPassword('verystrongpassword1234');
            $userResetPass->setName('TestResetPass');
            $userResetPass->setFirstName('BryanResetPass');
            $userResetPass->setIsActive(true);
            $userResetPass->setToken($this->getReference(TokenFixtures::TOKEN_RESET_PASS_USER_TEST_REFERENCE));
            $userResetPass->setImage($this->getReference(UserImageFixtures::USERIMAGE_RESET_PASS_USER_TEST_REFERENCE));

            $userBadResetPass = new User;
            $userBadResetPass->setUsername('ResetPassOtherUser');
            $userBadResetPass->setEmail('resetpasss@email.com');
            $userBadResetPass->setPassword('verystrongpassword12345');
            $userBadResetPass->setName('TestOtherResetPass');
            $userBadResetPass->setFirstName('BryanOtherResetPass');
            $userBadResetPass->setIsActive(true);
            $userBadResetPass->setToken($this->getReference(TokenFixtures::TOKEN_RESET_PASS_BAD_USER_TEST_REFERENCE));
            $userBadResetPass->setImage($this->getReference(UserImageFixtures::USERIMAGE_RESET_PASS_BAD_TEST_REFERENCE));

            $userResetPassExpiredToken = new User;
            $userResetPassExpiredToken->setUsername('IWantResetMyPass');
            $userResetPassExpiredToken->setEmail('resetmypass@email.com');
            $userResetPassExpiredToken->setPassword('verystrongpassword123456');
            $userResetPassExpiredToken->setName('TestMyResetPass');
            $userResetPassExpiredToken->setFirstName('ResetReset');
            $userResetPassExpiredToken->setToken($this->getReference(TokenFixtures::TOKEN_RESET_PASS_EXPIRED_TEST_REFERENCE));
            $userResetPassExpiredToken->setImage($this->getReference(UserImageFixtures::USERIMAGE_RESET_PASS_EXPIRED_TEST_REFERENCE));

            $userValidRegistrationExpired = new User;
            $userValidRegistrationExpired->setUsername('ValidMyRegistration');
            $userValidRegistrationExpired->setEmail('validregister@email.com');
            $userValidRegistrationExpired->setPassword('verystrongpassword1234567');
            $userValidRegistrationExpired->setName('TestBadValidRegister');
            $userValidRegistrationExpired->setFirstName('BadRegistration');
            $userValidRegistrationExpired->setToken($this->getReference(TokenFixtures::TOKEN_VALID_REGISTRATION_EXPIRED_TEST_REFERENCE));
            $userValidRegistrationExpired->setImage($this->getReference(UserImageFixtures::USERIMAGE_VALID_REGISTRATION_EXPIRED_TEST_REFERENCE));

            $manager->persist($user);
            $manager->persist($userEnabled);
            $manager->persist($inactiveUser);
            $manager->persist($userResetPass);
            $manager->persist($userBadResetPass);
            $manager->persist($userResetPassExpiredToken);
            $manager->persist($userValidRegistrationExpired);
        }

        if ($env == 'dev') {
            $demoUsername = $this->container->getParameter('demo_user_username');
            $demoPassword = $this->container->getParameter('demo_user_password');

            $demoUser = new User;
            $demoUser->setUsername($demoUsername);
            $demoUser->setEmail('demobryantrickemail@yahoo.com');
            $demoUser->setPassword($demoPassword);
            $demoUser->setName('Trick');
            $demoUser->setFirstName('Bryan');
            $demoUser->setIsActive(true);
            $demoUser->setToken($this->getReference(TokenFixtures::TOKEN_DEMO_REFERENCE));
            $demoUser->setImage($this->getReference(UserImageFixtures::USERIMAGE_DEMO_REFERENCE));

            $manager->persist($demoUser);
        }

        $manager->flush();

        if ($env == 'test') {
            $this->addReference(self::ENABLED_USER_TEST_REFERENCE, $userEnabled);
        }

        if ($env == 'dev') {
            $this->addReference(self::USER_DEMO_REFERENCE, $demoUser);
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