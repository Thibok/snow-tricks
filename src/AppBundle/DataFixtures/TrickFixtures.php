<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Trick;
use AppBundle\DataFixtures\UserFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use AppBundle\DataFixtures\CategoryFixtures;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var string
     */
    const TRICK_REFERENCE = 'trick-for-update';

    public function load(ObjectManager $manager)
    {
        $trick = new Trick;
        $trick->setName('A very good Trick');
        $trick->setDescription('This trick is very hard !');
        $trick->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $trick->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $otherTrick = new Trick;
        $otherTrick->setName('A simple trick');
        $otherTrick->setDescription('Simple');
        $otherTrick->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $otherTrick->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $manager->persist($trick);
        $manager->persist($otherTrick);
        $manager->flush();

        $this->addReference(self::TRICK_REFERENCE, $trick);
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
            UserFixtures::class,
            CategoryFixtures::class
        );
    }
}