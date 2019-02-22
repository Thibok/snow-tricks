<?php

/**
 * Comment Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Comment;
use AppBundle\DataFixtures\UserFixtures;
use AppBundle\DataFixtures\TrickFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * CommentFixtures
 */
class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * Load fixtures
     * @access public
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $firstCommentTrickView = new Comment;
        $secondCommentTrickView = new Comment;
        $thirdCommentTrickView = new Comment;
        $fourthCommentTrickView = new Comment;
        $fifthCommentTrickView = new Comment;
        $sixthCommentTrickView = new Comment;
        $seventhCommentTrickView = new Comment;
        $eighthCommentTrickView = new Comment;
        $ninthCommentTrickView = new Comment;
        $tenthCommentTrickView = new Comment;
        $eleventhCommentTrickView = new Comment;
        $twelfthCommentTrickView = new Comment;

        $firstCommentTrickDelete = new Comment;
        $secondCommentTrickDelete = new Comment;

        $firstCommentTrickView->setContent('First');
        $secondCommentTrickView->setContent('Second');
        $thirdCommentTrickView->setContent('Third');
        $fourthCommentTrickView->setContent('Fourth');
        $fifthCommentTrickView->setContent('Fifth');
        $sixthCommentTrickView->setContent('Sixth');
        $seventhCommentTrickView->setContent('Seventh');
        $eighthCommentTrickView->setContent('Eighth');
        $ninthCommentTrickView->setContent('Ninth');
        $tenthCommentTrickView->setContent('Tenth');
        $eleventhCommentTrickView->setContent('Eleventh');
        $twelfthCommentTrickView->setContent('Twelfth');

        $firstCommentTrickDelete->setContent('Top comment !');
        $secondCommentTrickDelete->setContent('Me too !');
        

        $firstCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $secondCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $thirdCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $fourthCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $fifthCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $sixthCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $seventhCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $eighthCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $ninthCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $tenthCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $eleventhCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $twelfthCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));

        $firstCommentTrickDelete->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $secondCommentTrickDelete->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));

        $firstCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $secondCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $thirdCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $fourthCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $fifthCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $sixthCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $seventhCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $eighthCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $ninthCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $tenthCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $eleventhCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $twelfthCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));

        $firstCommentTrickDelete->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_REFERENCE));
        $secondCommentTrickDelete->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_REFERENCE));

        $manager->persist($firstCommentTrickView);
        $manager->persist($secondCommentTrickView);
        $manager->persist($thirdCommentTrickView);
        $manager->persist($fourthCommentTrickView);
        $manager->persist($fifthCommentTrickView);
        $manager->persist($sixthCommentTrickView);
        $manager->persist($seventhCommentTrickView);
        $manager->persist($eighthCommentTrickView);
        $manager->persist($ninthCommentTrickView);
        $manager->persist($tenthCommentTrickView);
        $manager->persist($eleventhCommentTrickView);
        $manager->persist($twelfthCommentTrickView);

        $manager->persist($firstCommentTrickDelete);
        $manager->persist($secondCommentTrickDelete);

        $manager->flush();
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
            TrickFixtures::class
        );
    }
}