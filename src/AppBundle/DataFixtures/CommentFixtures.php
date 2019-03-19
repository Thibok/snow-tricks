<?php

/**
 * Load Comment Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Comment;
use AppBundle\DataFixtures\UserFixtures;
use AppBundle\DataFixtures\TrickFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * CommentFixtures
 */
class CommentFixtures extends Fixture implements DependentFixtureInterface, ContainerAwareInterface
{
    /**
     * Service container
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
            $firstCmtTrickView = new Comment;
            $secondCmtTrickView = new Comment;
            $thirdCmtTrickView = new Comment;
            $fourthCmtTrickView = new Comment;
            $fifthCmtTrickView = new Comment;
            $sixthCmtTrickView = new Comment;
            $seventhCmtTrickView = new Comment;
            $eighthCmtTrickView = new Comment;
            $ninthCmtTrickView = new Comment;
            $tenthCmtTrickView = new Comment;
            $eleventhCmtTrickView = new Comment;
            $twelfthCmtTrickView = new Comment;

            $firstCmtTrickDelete = new Comment;
            $secondCmtTrickDelete = new Comment;

            $firstCmtTrickDeleteAjax = new Comment;
            $secondCmtTrickDeleteAjax = new Comment;

            $firstCmtTrickView->setContent('First');
            $secondCmtTrickView->setContent('Second');
            $thirdCmtTrickView->setContent('Third');
            $fourthCmtTrickView->setContent('Fourth');
            $fifthCmtTrickView->setContent('Fifth');
            $sixthCmtTrickView->setContent('Sixth');
            $seventhCmtTrickView->setContent('Seventh');
            $eighthCmtTrickView->setContent('Eighth');
            $ninthCmtTrickView->setContent('Ninth');
            $tenthCmtTrickView->setContent('Tenth');
            $eleventhCmtTrickView->setContent('Eleventh');
            $twelfthCmtTrickView->setContent('Twelfth');

            $firstCmtTrickDelete->setContent('Top comment !');
            $secondCmtTrickDelete->setContent('Me too !');

            $firstCmtTrickDeleteAjax->setContent('Delete me');
            $secondCmtTrickDeleteAjax->setContent('Clean me with Ajax');
            

            $firstCmtTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $secondCmtTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $thirdCmtTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $fourthCmtTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $fifthCmtTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $sixthCmtTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $seventhCmtTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $eighthCmtTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $ninthCmtTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $tenthCmtTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $eleventhCmtTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $twelfthCmtTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));

            $firstCmtTrickDelete->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $secondCmtTrickDelete->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));

            $firstCmtTrickDeleteAjax->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $secondCmtTrickDeleteAjax->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));

            $firstCmtTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $secondCmtTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $thirdCmtTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $fourthCmtTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $fifthCmtTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $sixthCmtTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $seventhCmtTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $eighthCmtTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $ninthCmtTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $tenthCmtTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $eleventhCmtTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $twelfthCmtTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));

            $firstCmtTrickDelete->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_TEST_REFERENCE));
            $secondCmtTrickDelete->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_TEST_REFERENCE));

            $firstCmtTrickDeleteAjax->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_AJAX_TEST_REFERENCE));
            $secondCmtTrickDeleteAjax->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_AJAX_TEST_REFERENCE));

            $manager->persist($firstCmtTrickView);
            $manager->persist($secondCmtTrickView);
            $manager->persist($thirdCmtTrickView);
            $manager->persist($fourthCmtTrickView);
            $manager->persist($fifthCmtTrickView);
            $manager->persist($sixthCmtTrickView);
            $manager->persist($seventhCmtTrickView);
            $manager->persist($eighthCmtTrickView);
            $manager->persist($ninthCmtTrickView);
            $manager->persist($tenthCmtTrickView);
            $manager->persist($eleventhCmtTrickView);
            $manager->persist($twelfthCmtTrickView);

            $manager->persist($firstCmtTrickDelete);
            $manager->persist($secondCmtTrickDelete);

            $manager->persist($firstCmtTrickDeleteAjax);
            $manager->persist($secondCmtTrickDeleteAjax);
        }

        if ($env == 'dev') {
            $firstCmtMute = new Comment;
            $secondCmtMute = new Comment;
            $thirdCmtMute = new Comment;
            $fourthCmtMute = new Comment;
            $fifthCmtMute = new Comment;
            $sixthCmtMute = new Comment;
            $seventhCmtMute = new Comment;
            $eighthCmtMute = new Comment;
            $ninthCmtMute = new Comment;
            $tenthCmtMute = new Comment;
            $eleventhCmtMute = new Comment;
            $twelftCmtMute = new Comment;

            $firstCmtMute->setContent('First !');
            $secondCmtMute->setContent('Love this trick !');
            $thirdCmtMute->setContent('This trick is very hard...');
            $fourthCmtMute->setContent('A very good trick');
            $fifthCmtMute->setContent('This jump');
            $sixthCmtMute->setContent('Beautiful snow');
            $seventhCmtMute->setContent('Need help for this trick');
            $eighthCmtMute->setContent('Go to ride !');
            $ninthCmtMute->setContent('Thanks for this trick');
            $tenthCmtMute->setContent('Mute trick !');
            $eleventhCmtMute->setContent('What place to test that?');
            $twelftCmtMute->setContent('Love SnowTricks');

            $firstCmtMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $secondCmtMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $thirdCmtMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $fourthCmtMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $fifthCmtMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $sixthCmtMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $seventhCmtMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $eighthCmtMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $ninthCmtMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $tenthCmtMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $eleventhCmtMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $twelftCmtMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));

            $firstCmtMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $secondCmtMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $thirdCmtMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $fourthCmtMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $fifthCmtMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $sixthCmtMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $seventhCmtMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $eighthCmtMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $ninthCmtMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $tenthCmtMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $eleventhCmtMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $twelftCmtMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));

            $manager->persist($firstCmtMute);
            $manager->persist($secondCmtMute);
            $manager->persist($thirdCmtMute);
            $manager->persist($fourthCmtMute);
            $manager->persist($fifthCmtMute);
            $manager->persist($sixthCmtMute);
            $manager->persist($seventhCmtMute);
            $manager->persist($eighthCmtMute);
            $manager->persist($ninthCmtMute);
            $manager->persist($tenthCmtMute);
            $manager->persist($eleventhCmtMute);
            $manager->persist($twelftCmtMute);
        }
        
        $manager->flush();
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
            UserFixtures::class,
            TrickFixtures::class
        );
    }
}