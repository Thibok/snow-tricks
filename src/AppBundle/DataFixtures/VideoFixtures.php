<?php

/**
 * Load Video Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Video;
use AppBundle\DataFixtures\TrickFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * VideoFixtures
 */
class VideoFixtures extends Fixture implements DependentFixtureInterface, ContainerAwareInterface
{
    /**
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
            $firstVideoTrickUpdate = new Video;
            $secondVideoTrickUpdate = new Video;
            $thirdVideoTrickUpdate = new Video;

            $videoTrickView = new Video;

            $firstVideoTrickDelete = new Video;
            $secondVideoTrickDelete = new Video;

            $firstVideoTrickDeleteAjax = new Video;
            $secondVideoTrickDeleteAjax = new Video;

            $firstVideoTrickUpdate->setUrl('https://www.youtube.com/watch?v=SQyTWk7OxSI');
            $secondVideoTrickUpdate->setUrl('https://www.youtube.com/watch?v=8CtWgw9xYRE');
            $thirdVideoTrickUpdate->setUrl('https://www.youtube.com/watch?v=dSZ7_TXcEdM');

            $videoTrickView->setUrl('https://www.youtube.com/watch?v=dSZ7_TXcEdM');

            $firstVideoTrickDelete->setUrl('https://www.youtube.com/watch?v=-27nqjI844I');
            $secondVideoTrickDelete->setUrl('https://www.youtube.com/watch?v=FaVnYAQ8BXM');

            $firstVideoTrickDeleteAjax->setUrl('https://www.youtube.com/watch?v=FaVnYAQ8BXM');
            $secondVideoTrickDeleteAjax->setUrl('https://www.youtube.com/watch?v=FaVnYAQ8BXM');

            $firstVideoTrickUpdate->setTrick($this->getReference(TrickFixtures::TRICK_UPDATE_TEST_REFERENCE));
            $secondVideoTrickUpdate->setTrick($this->getReference(TrickFixtures::TRICK_UPDATE_TEST_REFERENCE));
            $thirdVideoTrickUpdate->setTrick($this->getReference(TrickFixtures::TRICK_UPDATE_TEST_REFERENCE));

            $videoTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));

            $firstVideoTrickDelete->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_TEST_REFERENCE));
            $secondVideoTrickDelete->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_TEST_REFERENCE));

            $firstVideoTrickDeleteAjax->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_AJAX_TEST_REFERENCE));
            $secondVideoTrickDeleteAjax->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_AJAX_TEST_REFERENCE));

            $manager->persist($firstVideoTrickUpdate);
            $manager->persist($secondVideoTrickUpdate);
            $manager->persist($thirdVideoTrickUpdate);
        
            $manager->persist($videoTrickView);

            $manager->persist($firstVideoTrickDelete);
            $manager->persist($secondVideoTrickDelete);

            $manager->persist($firstVideoTrickDeleteAjax);
            $manager->persist($secondVideoTrickDeleteAjax);
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
            TrickFixtures::class,
        );
    }
}