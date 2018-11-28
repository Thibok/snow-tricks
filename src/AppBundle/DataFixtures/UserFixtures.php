<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use AppBundle\DataFixtures\TokenFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use AppBundle\DataFixtures\UserImageFixtures;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User;
        $user->setUsername('GoodUser');
        $user->setEmail('good@email.com');
        $user->setPassword('verystrongpassword12');
        $user->setName('Test');
        $user->setFirstName('Bryan');
        $user->setToken($this->getReference(TokenFixtures::VALID_TOKEN_REGISTRATION_REFERENCE));
        $user->setImage($this->getReference(UserImageFixtures::USERIMAGE_REFERENCE));

        $manager->persist($user);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            TokenFixtures::class,
            UserImageFixtures::class
        );
    }
}