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

        $firstComment->setContent('1');
        $secondComment->setContent('2');
        $thirdComment->setContent('3');
        $fourthComment->setContent('4');
        $fifthComment->setContent('5');
        $sixthComment->setContent('6');
        $seventhComment->setContent('7');
        $eighthComment->setContent('8');
        $ninthComment->setContent('9');
        $tenthComment->setContent('10');
        $eleventhComment->setContent('11');
        $twelfthComment->setContent('12');

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

        $firstComment->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE));
        $secondComment->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE));
        $thirdComment->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE));
        $fourthComment->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE));
        $fifthComment->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE));
        $sixthComment->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE));
        $seventhComment->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE));
        $eighthComment->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE));
        $ninthComment->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE));
        $tenthComment->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE));
        $eleventhComment->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE));
        $twelfthComment->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE));

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