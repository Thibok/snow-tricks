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

        if ($env == 'dev') {
            $firstJapanAirVid = new Video;
            $firstJapanAirVid->setUrl('https://www.youtube.com/watch?v=CzDjM7h_Fwo');
            $firstJapanAirVid->setTrick($this->getReference(TrickFixtures::TRICK_JAPAN_AIR_DEMO_REFERENCE));

            $secondJapanAirVid = new Video;
            $secondJapanAirVid->setUrl('https://www.youtube.com/watch?v=jH76540wSqU');
            $secondJapanAirVid->setTrick($this->getReference(TrickFixtures::TRICK_JAPAN_AIR_DEMO_REFERENCE));

            $oneHundredEightyVid = new Video;
            $oneHundredEightyVid->setUrl('https://www.youtube.com/watch?v=LMfEdzmxAns');
            $oneHundredEightyVid->setTrick($this->getReference(TrickFixtures::TRICK_ONE_HUNDRED_EIGHTY_DEMO_REFERENCE));

            $backFlipVid = new Video;
            $backFlipVid->setUrl('https://www.dailymotion.com/video/xyxdbf');
            $backFlipVid->setTrick($this->getReference(TrickFixtures::TRICK_BACK_FLIP_DEMO_REFERENCE));

            $corkScrewVid = new Video;
            $corkScrewVid->setUrl('https://www.youtube.com/watch?v=IXC_BNYIUOo');
            $corkScrewVid->setTrick($this->getReference(TrickFixtures::TRICK_CORK_SCREW_DEMO_REFERENCE));

            $tailSlideVid = new Video;
            $tailSlideVid->setUrl('https://www.youtube.com/watch?v=HRNXjMBakwM');
            $tailSlideVid->setTrick($this->getReference(TrickFixtures::TRICK_TAIL_SLIDE_DEMO_REFERENCE));

            $rocketAirVid = new Video;
            $rocketAirVid->setUrl('https://www.youtube.com/watch?v=nom7QBoGh5w');
            $rocketAirVid->setTrick($this->getReference(TrickFixtures::TRICK_ROCKET_AIR_DEMO_REFERENCE));

            $stalFishVid = new Video;
            $stalFishVid->setUrl('https://www.youtube.com/watch?v=f9FjhCt_w2U');
            $stalFishVid->setTrick($this->getReference(TrickFixtures::TRICK_STALFISH_DEMO_REFERENCE));

            $haakonFlipVid = new Video;
            $haakonFlipVid->setUrl('https://www.youtube.com/watch?v=RvO2Dqnj7B4');
            $haakonFlipVid->setTrick($this->getReference(TrickFixtures::TRICK_HAAKON_FLIP_DEMO_REFERENCE));

            $truckDriverVid = new Video;
            $truckDriverVid->setUrl('https://www.youtube.com/watch?v=6tgjY8baFT0');
            $truckDriverVid->setTrick($this->getReference(TrickFixtures::TRICK_TRUCK_DRIVER_DEMO_REFERENCE));

            $seatBeltVid = new Video;
            $seatBeltVid->setUrl('https://www.youtube.com/watch?v=4vGEOYNGi_c');
            $seatBeltVid->setTrick($this->getReference(TrickFixtures::TRICK_SEAT_BELT_DEMO_REFERENCE));

            $noseGrabVid = new Video;
            $noseGrabVid->setUrl('https://www.youtube.com/watch?v=M-W7Pmo-YMY');
            $noseGrabVid->setTrick($this->getReference(TrickFixtures::TRICK_NOSE_GRAB_DEMO_REFERENCE));

            $tailGrabVid = new Video;
            $tailGrabVid->setUrl('https://www.youtube.com/watch?v=id8VKl9RVQw');
            $tailGrabVid->setTrick($this->getReference(TrickFixtures::TRICK_TAIL_GRAB_DEMO_REFERENCE));

            $indyVid = new Video;
            $indyVid->setUrl('https://www.youtube.com/watch?v=iKkhKekZNQ8');
            $indyVid->setTrick($this->getReference(TrickFixtures::TRICK_INDY_DEMO_REFERENCE));

            $sadVid = new Video;
            $sadVid->setUrl('https://www.youtube.com/watch?v=KEdFwJ4SWq4');
            $sadVid->setTrick($this->getReference(TrickFixtures::TRICK_SAD_DEMO_REFERENCE));

            $firstMuteVid = new Video;
            $firstMuteVid->setUrl('https://www.youtube.com/watch?v=k6aOWf0LDcQ');
            $firstMuteVid->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));

            $secondMuteVid = new Video;
            $secondMuteVid->setUrl('https://www.youtube.com/watch?v=CA5bURVJ5zk');
            $secondMuteVid->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));

            $thirdMuteVid = new Video;
            $thirdMuteVid->setUrl('https://www.youtube.com/watch?v=6z6KBAbM0MY');
            $thirdMuteVid->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));

            $manager->persist($firstJapanAirVid);
            $manager->persist($secondJapanAirVid);

            $manager->persist($oneHundredEightyVid);

            $manager->persist($backFlipVid);

            $manager->persist($corkScrewVid);

            $manager->persist($tailSlideVid);

            $manager->persist($rocketAirVid);

            $manager->persist($stalFishVid);

            $manager->persist($haakonFlipVid);

            $manager->persist($truckDriverVid);

            $manager->persist($seatBeltVid);

            $manager->persist($noseGrabVid);

            $manager->persist($tailGrabVid);

            $manager->persist($indyVid);

            $manager->persist($sadVid);

            $manager->persist($firstMuteVid);
            $manager->persist($secondMuteVid);
            $manager->persist($thirdMuteVid);
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