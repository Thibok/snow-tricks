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

            $firstCommentTrickDeleteAjax = new Comment;
            $secondCommentTrickDeleteAjax = new Comment;

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

            $firstCommentTrickDeleteAjax->setContent('Delete me');
            $secondCommentTrickDeleteAjax->setContent('Clean me with Ajax');
            

            $firstCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $secondCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $thirdCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $fourthCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $fifthCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $sixthCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $seventhCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $eighthCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $ninthCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $tenthCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $eleventhCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $twelfthCommentTrickView->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));

            $firstCommentTrickDelete->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $secondCommentTrickDelete->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));

            $firstCommentTrickDeleteAjax->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));
            $secondCommentTrickDeleteAjax->setUser($this->getReference(UserFixtures::ENABLED_USER_TEST_REFERENCE));

            $firstCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $secondCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $thirdCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $fourthCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $fifthCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $sixthCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $seventhCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $eighthCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $ninthCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $tenthCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $eleventhCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));
            $twelfthCommentTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));

            $firstCommentTrickDelete->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_TEST_REFERENCE));
            $secondCommentTrickDelete->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_TEST_REFERENCE));

            $firstCommentTrickDeleteAjax->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_AJAX_TEST_REFERENCE));
            $secondCommentTrickDeleteAjax->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_AJAX_TEST_REFERENCE));

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

            $manager->persist($firstCommentTrickDeleteAjax);
            $manager->persist($secondCommentTrickDeleteAjax);
        }

        if ($env == 'dev') {
            $firstCommentMute = new Comment;
            $secondCommentMute = new Comment;
            $thirdCommentMute = new Comment;
            $fourthCommentMute = new Comment;
            $fifthCommentMute = new Comment;
            $sixthCommentMute = new Comment;
            $seventhCommentMute = new Comment;
            $eighthCommentMute = new Comment;
            $ninthCommentMute = new Comment;
            $tenthCommentMute = new Comment;
            $eleventhCommentMute = new Comment;
            $twelftCommentMute = new Comment;

            $firstCommentMute->setContent('First !');
            $secondCommentMute->setContent('Love this trick !');
            $thirdCommentMute->setContent('This trick is very hard...');
            $fourthCommentMute->setContent('A very good trick');
            $fifthCommentMute->setContent('This jump');
            $sixthCommentMute->setContent('Beautiful snow');
            $seventhCommentMute->setContent('Need help for this trick');
            $eighthCommentMute->setContent('Go to ride !');
            $ninthCommentMute->setContent('Thanks for this trick');
            $tenthCommentMute->setContent('Mute trick !');
            $eleventhCommentMute->setContent('What place to test that?');
            $twelftCommentMute->setContent('Love SnowTricks');

            $firstCommentMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $secondCommentMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $thirdCommentMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $fourthCommentMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $fifthCommentMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $sixthCommentMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $seventhCommentMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $eighthCommentMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $ninthCommentMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $tenthCommentMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $eleventhCommentMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));
            $twelftCommentMute->setUser($this->getReference(UserFixtures::USER_DEMO_REFERENCE));

            $firstCommentMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $secondCommentMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $thirdCommentMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $fourthCommentMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $fifthCommentMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $sixthCommentMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $seventhCommentMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $eighthCommentMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $ninthCommentMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $tenthCommentMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $eleventhCommentMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $twelftCommentMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));

            $manager->persist($firstCommentMute);
            $manager->persist($secondCommentMute);
            $manager->persist($thirdCommentMute);
            $manager->persist($fourthCommentMute);
            $manager->persist($fifthCommentMute);
            $manager->persist($sixthCommentMute);
            $manager->persist($seventhCommentMute);
            $manager->persist($eighthCommentMute);
            $manager->persist($ninthCommentMute);
            $manager->persist($tenthCommentMute);
            $manager->persist($eleventhCommentMute);
            $manager->persist($twelftCommentMute);
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