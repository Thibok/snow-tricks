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

    /**
     * @var string
     */
    const TRICK_DELETE_REFERENCE = 'trick-for-delete';

    /**
     * 
     */
    const TRICK_DELETE_AJAX_REFERENCE = 'trick-for-delete-ajax';

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

        $trickForDelete = new Trick;
        $trickForDelete->setName('A very bad trick');
        $trickForDelete->setDescription('This trick need remove !');
        $trickForDelete->setUpdateAt(new \DateTime);
        $trickForDelete->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $trickForDelete->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $trickForDeleteAjax = new Trick;
        $trickForDeleteAjax->setName('A very bad bad bad trick');
        $trickForDeleteAjax->setDescription('This trick need to remove with ajax !');
        $trickForDeleteAjax->setUpdateAt(new \DateTime);
        $trickForDeleteAjax->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $trickForDeleteAjax->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $manager->persist($trickForUpdate);
        $manager->persist($trickForView);
        $manager->persist($trickForDelete);
        $manager->persist($trickForDeleteAjax);
        
        $manager->flush();

        $this->addReference(self::TRICK_UPDATE_REFERENCE, $trickForUpdate);
        $this->addReference(self::TRICK_VIEW_REFERENCE, $trickForView);
        $this->addReference(self::TRICK_DELETE_REFERENCE, $trickForDelete);
        $this->addReference(self::TRICK_DELETE_AJAX_REFERENCE, $trickForDeleteAjax);
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