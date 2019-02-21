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
    const TRICK_UPDATE_REFERENCE = 'trick-for-update';

    /**
     * @var string
     */
    const TRICK_VIEW_REFERENCE = 'trick-for-view';

    public function load(ObjectManager $manager)
    {
        $trickForUpdate = new Trick;
        $trickForUpdate->setName('A very good Trick');
        $trickForUpdate->setDescription('This trick is very hard !');
        $trickForUpdate->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $trickForUpdate->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $trickForView = new Trick;
        $trickForView->setName('A simple trick');
        $trickForView->setDescription('Simple');
        $trickForView->setUpdateAt(new \DateTime);
        $trickForView->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $trickForView->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $manager->persist($trickForUpdate);
        $manager->persist($trickForView);
        $manager->flush();

        $this->addReference(self::TRICK_UPDATE_REFERENCE, $trickForUpdate);
        $this->addReference(self::TRICK_VIEW_REFERENCE, $trickForView);
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