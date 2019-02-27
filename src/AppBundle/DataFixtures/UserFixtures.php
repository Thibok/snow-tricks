<?php

/**
 * User Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use AppBundle\DataFixtures\TokenFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use AppBundle\DataFixtures\UserImageFixtures;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * UserFixtures
 */
class UserFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var string
     */
    const ENABLED_USER_REFERENCE = 'user-enabled';

    /**
     * Load fixtures
     * @access public
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $user = new User;
        $user->setUsername('GoodUser');
        $user->setEmail('good@email.com');
        $user->setPassword('verystrongpassword12');
        $user->setName('Test');
        $user->setFirstName('Bryan');
        $user->setToken($this->getReference(TokenFixtures::VALID_TOKEN_REGISTRATION_REFERENCE));
        $user->setImage($this->getReference(UserImageFixtures::VALID_REGISTRATION_USERIMAGE_REFERENCE));

        $inactiveUser = new User;
        $inactiveUser->setUsername('InactiveUser');
        $inactiveUser->setEmail('bad@email.com');
        $inactiveUser->setPassword('verystrongpassword1222');
        $inactiveUser->setName('TestInactive');
        $inactiveUser->setFirstName('BryanDisabled');
        $inactiveUser->setToken($this->getReference(TokenFixtures::TOKEN_INACTIVE_USER_REFERENCE));
        $inactiveUser->setImage($this->getReference(UserImageFixtures::USERIMAGE_INACTIVE_USER_REFERENCE));

        $userEnabled = new User;
        $userEnabled->setUsername('EnabledUser');
        $userEnabled->setEmail('goodie@email.com');
        $userEnabled->setPassword('verystrongpassword123');
        $userEnabled->setName('TestEnabled');
        $userEnabled->setFirstName('BryanEnabled');
        $userEnabled->setIsActive(true);
        $userEnabled->setToken($this->getReference(TokenFixtures::TOKEN_ENABLED_USER_REFERENCE));
        $userEnabled->setImage($this->getReference(UserImageFixtures::USERIMAGE_ENABLED_USER_REFERENCE));

        $userResetPass = new User;
        $userResetPass->setUsername('ResetPassUser');
        $userResetPass->setEmail('resetpass@email.com');
        $userResetPass->setPassword('verystrongpassword1234');
        $userResetPass->setName('TestResetPass');
        $userResetPass->setFirstName('BryanResetPass');
        $userResetPass->setIsActive(true);
        $userResetPass->setToken($this->getReference(TokenFixtures::TOKEN_RESET_PASS_USER_REFERENCE));
        $userResetPass->setImage($this->getReference(UserImageFixtures::USERIMAGE_RESET_PASS_USER_REFERENCE));

        $userBadResetPass = new User;
        $userBadResetPass->setUsername('ResetPassOtherUser');
        $userBadResetPass->setEmail('resetpasss@email.com');
        $userBadResetPass->setPassword('verystrongpassword12345');
        $userBadResetPass->setName('TestOtherResetPass');
        $userBadResetPass->setFirstName('BryanOtherResetPass');
        $userBadResetPass->setIsActive(true);
        $userBadResetPass->setToken($this->getReference(TokenFixtures::TOKEN_RESET_PASS_BAD_USER_REFERENCE));
        $userBadResetPass->setImage($this->getReference(UserImageFixtures::USERIMAGE_RESET_PASS_BAD_REFERENCE));

        $userResetPassExpiredToken = new User;
        $userResetPassExpiredToken->setUsername('IWantResetMyPass');
        $userResetPassExpiredToken->setEmail('resetmypass@email.com');
        $userResetPassExpiredToken->setPassword('verystrongpassword123456');
        $userResetPassExpiredToken->setName('TestMyResetPass');
        $userResetPassExpiredToken->setFirstName('ResetReset');
        $userResetPassExpiredToken->setToken($this->getReference(TokenFixtures::TOKEN_RESET_PASS_EXPIRED_REFERENCE));
        $userResetPassExpiredToken->setImage($this->getReference(UserImageFixtures::USERIMAGE_RESET_PASS_EXPIRED_REFERENCE));

        $userValidRegistrationExpired = new User;
        $userValidRegistrationExpired->setUsername('ValidMyRegistration');
        $userValidRegistrationExpired->setEmail('validregister@email.com');
        $userValidRegistrationExpired->setPassword('verystrongpassword1234567');
        $userValidRegistrationExpired->setName('TestBadValidRegister');
        $userValidRegistrationExpired->setFirstName('BadRegistration');
        $userValidRegistrationExpired->setToken($this->getReference(TokenFixtures::TOKEN_VALID_REGISTRATION_EXPIRED_REFERENCE));
        $userValidRegistrationExpired->setImage($this->getReference(UserImageFixtures::USERIMAGE_VALID_REGISTRATION_EXPIRED_REFERENCE));

        $manager->persist($user);
        $manager->persist($userEnabled);
        $manager->persist($inactiveUser);
        $manager->persist($userResetPass);
        $manager->persist($userBadResetPass);
        $manager->persist($userResetPassExpiredToken);
        $manager->persist($userValidRegistrationExpired);
        $manager->flush();

        $this->addReference(self::ENABLED_USER_REFERENCE, $userEnabled);
    }

    /**
     * Get dependencies fixtures
     * @access public
     * 
     * @return array
     */
    public function getDependencies()
    {
        return array(
            TokenFixtures::class,
            UserImageFixtures::class
        );
    }
}