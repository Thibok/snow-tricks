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
     * @var string
     */
    const TRICK_DELETE_AJAX_REFERENCE = 'trick-for-delete-ajax';

    /**
     * @var string
     */
    const TRICK_HOME_REFERENCE = 'trick-for-home';

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

        $trickPathEditDelete = new Trick;
        $trickPathEditDelete->setName('Test path edit to delete');
        $trickPathEditDelete->setDescription('Go here !');
        $trickPathEditDelete->setUpdateAt(new \DateTime);
        $trickPathEditDelete->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $trickPathEditDelete->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $trickPathViewDelete = new Trick;
        $trickPathViewDelete->setName('Test path view to delete');
        $trickPathViewDelete->setDescription('Go here');
        $trickPathViewDelete->setUpdateAt(new \DateTime);
        $trickPathViewDelete->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $trickPathViewDelete->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $firstTrickHome = new Trick;
        $firstTrickHome->setName('First trick');
        $firstTrickHome->setDescription('I am first !');
        $firstTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $firstTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $secondTrickHome = new Trick;
        $secondTrickHome->setName('Second trick');
        $secondTrickHome->setDescription('I am second !');
        $secondTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $secondTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $thirdTrickHome = new Trick;
        $thirdTrickHome->setName('Third trick');
        $thirdTrickHome->setDescription('I am third !');
        $thirdTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $thirdTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $fourthTrickHome = new Trick;
        $fourthTrickHome->setName('Fourth trick');
        $fourthTrickHome->setDescription('I am fourth !');
        $fourthTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $fourthTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $fifthTrickHome = new Trick;
        $fifthTrickHome->setName('Fifth trick');
        $fifthTrickHome->setDescription('I am fifth');
        $fifthTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $fifthTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $sixthTrickHome = new Trick;
        $sixthTrickHome->setName('Sixth trick');
        $sixthTrickHome->setDescription('I am sixth !');
        $sixthTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $sixthTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $seventhTrickHome = new Trick;
        $seventhTrickHome->setName('Seventh trick');
        $seventhTrickHome->setDescription('I am seventh !');
        $seventhTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $seventhTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $eighthTrickHome = new Trick;
        $eighthTrickHome->setName('Eighth trick');
        $eighthTrickHome->setDescription('I am eighth !');
        $eighthTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $eighthTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $ninthTrickHome = new Trick;
        $ninthTrickHome->setName('Ninth trick');
        $ninthTrickHome->setDescription('I am ninth !');
        $ninthTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $ninthTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $tenthTrickHome = new Trick;
        $tenthTrickHome->setName('Tenth trick');
        $tenthTrickHome->setDescription('I am tenth !');
        $tenthTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $tenthTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $eleventhTrickHome = new Trick;
        $eleventhTrickHome->setName('Eleventh trick');
        $eleventhTrickHome->setDescription('I am eleventh !');
        $eleventhTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $eleventhTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $twelfthTrickHome = new Trick;
        $twelfthTrickHome->setName('Twelfth trick');
        $twelfthTrickHome->setDescription('I am twelfth !');
        $twelfthTrickHome->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $twelfthTrickHome->setCategory($this->getReference(CategoryFixtures::CATEGORY_FLIP_REFERENCE));

        $manager->persist($trickForUpdate);

        $manager->persist($trickForView);

        $manager->persist($trickForDelete);
        $manager->persist($trickForDeleteAjax);

        $manager->persist($trickPathEditDelete);
        $manager->persist($trickPathViewDelete);

        $manager->persist($firstTrickHome);
        $manager->persist($secondTrickHome);
        $manager->persist($thirdTrickHome);
        $manager->persist($fourthTrickHome);
        $manager->persist($fifthTrickHome);
        $manager->persist($sixthTrickHome);
        $manager->persist($seventhTrickHome);
        $manager->persist($eighthTrickHome);
        $manager->persist($ninthTrickHome);
        $manager->persist($tenthTrickHome);
        $manager->persist($eleventhTrickHome);
        $manager->persist($twelfthTrickHome);
        
        $manager->flush();

        $this->addReference(self::TRICK_UPDATE_REFERENCE, $trickForUpdate);
        $this->addReference(self::TRICK_VIEW_REFERENCE, $trickForView);
        $this->addReference(self::TRICK_DELETE_REFERENCE, $trickForDelete);
        $this->addReference(self::TRICK_DELETE_AJAX_REFERENCE, $trickForDeleteAjax);
        $this->addReference(self::TRICK_HOME_REFERENCE, $twelfthTrickHome);
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