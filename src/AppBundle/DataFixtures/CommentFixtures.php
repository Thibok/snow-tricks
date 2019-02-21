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
        $firstComment = new Comment;
        $secondComment = new Comment;
        $thirdComment = new Comment;
        $fourthComment = new Comment;
        $fifthComment = new Comment;
        $sixthComment = new Comment;
        $seventhComment = new Comment;
        $eighthComment = new Comment;
        $ninthComment = new Comment;
        $tenthComment = new Comment;
        $eleventhComment = new Comment;
        $twelfthComment = new Comment;

        $firstComment->setContent('First');
        $secondComment->setContent('Second');
        $thirdComment->setContent('Third');
        $fourthComment->setContent('Fourth');
        $fifthComment->setContent('Fifth');
        $sixthComment->setContent('Sixth');
        $seventhComment->setContent('Seventh');
        $eighthComment->setContent('Eighth');
        $ninthComment->setContent('Ninth');
        $tenthComment->setContent('Tenth');
        $eleventhComment->setContent('Eleventh');
        $twelfthComment->setContent('Twelfth');

        $firstComment->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $secondComment->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $thirdComment->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $fourthComment->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $fifthComment->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $sixthComment->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $seventhComment->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $eighthComment->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $ninthComment->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $tenthComment->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $eleventhComment->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));
        $twelfthComment->setUser($this->getReference(UserFixtures::ENABLED_USER_REFERENCE));

        $firstComment->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $secondComment->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $thirdComment->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $fourthComment->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $fifthComment->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $sixthComment->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $seventhComment->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $eighthComment->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $ninthComment->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $tenthComment->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $eleventhComment->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));
        $twelfthComment->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));

        $manager->persist($firstComment);
        $manager->persist($secondComment);
        $manager->persist($thirdComment);
        $manager->persist($fourthComment);
        $manager->persist($fifthComment);
        $manager->persist($sixthComment);
        $manager->persist($seventhComment);
        $manager->persist($eighthComment);
        $manager->persist($ninthComment);
        $manager->persist($tenthComment);
        $manager->persist($eleventhComment);
        $manager->persist($twelfthComment);

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