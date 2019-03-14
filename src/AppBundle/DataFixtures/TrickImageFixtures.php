<?php

/**
 * Load TrickImage Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\TrickImage;
use AppBundle\DataFixtures\TrickFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * TrickImageFixtures
 */
class TrickImageFixtures extends Fixture implements DependentFixtureInterface, ContainerAwareInterface
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
            $fileDir = __DIR__.'/../../../tests/AppBundle/uploads/';

            copy($fileDir.'goodTrickImg.jpg', $fileDir.'trickImg-update-1.jpg');
            copy($fileDir.'otherGoodTrickImg.jpeg', $fileDir.'trickImg-update-2.jpeg');

            copy($fileDir.'goodTrickImg.jpg', $fileDir.'trickImg-view-1.jpg');

            copy($fileDir.'goodTrickImg.jpg', $fileDir.'trickImg-delete-1.jpg');
            copy($fileDir.'goodTrickImg.jpg', $fileDir.'trickImg-delete-2.jpg');

            copy($fileDir.'goodTrickImg.jpg', $fileDir.'trickImg-delete-ajax-1.jpg');
            copy($fileDir.'goodTrickImg.jpg', $fileDir.'trickImg-delete-ajax-2.jpg');

            copy($fileDir.'goodTrickImg.jpg', $fileDir.'trickImg-home.jpg');

            $firstTrickImgTrickUpdate = new TrickImage;
            $secondTrickImgTrickUpdate = new TrickImage;

            $trickImgTrickView = new TrickImage;
            
            $firstTrickImgTrickDelete = new TrickImage;
            $secondTrickImgTrickDelete = new TrickImage;

            $firstTrickImgTrickDeleteAjax = new TrickImage;
            $secondTrickImgTrickDeleteAjax = new TrickImage;

            $trickImgHome = new TrickImage;

            $firstFileTrickUpdate = new UploadedFile(
                $fileDir.'trickImg-update-1.jpg',
                'trickImg-update-1.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $secondFileTrickUpdate = new UploadedFile(
                $fileDir.'trickImg-update-2.jpeg',
                'trickImg-update-2.jpeg',
                'image/jpeg',
                null,
                null,
                true
            );

            $fileTrickView = new UploadedFile(
                $fileDir.'trickImg-view-1.jpg',
                'trickImg-view-1.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $firstFileTrickDelete = new UploadedFile(
                $fileDir.'trickImg-delete-1.jpg',
                'trickImg-delete-1.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $secondFileTrickDelete = new UploadedFile(
                $fileDir.'trickImg-delete-2.jpg',
                'trickImg-delete-2.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $firstFileTrickDeleteAjax = new UploadedFile(
                $fileDir.'trickImg-delete-ajax-1.jpg',
                'trickImg-delete-ajax-1.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $secondFileTrickDeleteAjax = new UploadedFile(
                $fileDir.'trickImg-delete-ajax-2.jpg',
                'trickImg-delete-ajax-2.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $trickFileHome = new UploadedFile(
                $fileDir.'trickImg-home.jpg',
                'trickImg-home.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $firstTrickImgTrickUpdate->setFile($firstFileTrickUpdate);
            $secondTrickImgTrickUpdate->setFile($secondFileTrickUpdate);

            $trickImgTrickView->setFile($fileTrickView);

            $firstTrickImgTrickDelete->setFile($firstFileTrickDelete);
            $secondTrickImgTrickDelete->setFile($secondFileTrickDelete);

            $firstTrickImgTrickDeleteAjax->setFile($firstFileTrickDeleteAjax);
            $secondTrickImgTrickDeleteAjax->setFile($secondFileTrickDeleteAjax);

            $trickImgHome->setFile($trickFileHome);

            $firstTrickImgTrickUpdate->setTrick($this->getReference(TrickFixtures::TRICK_UPDATE_TEST_REFERENCE));
            $secondTrickImgTrickUpdate->setTrick($this->getReference(TrickFixtures::TRICK_UPDATE_TEST_REFERENCE));

            $trickImgTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_TEST_REFERENCE));

            $firstTrickImgTrickDelete->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_TEST_REFERENCE));
            $secondTrickImgTrickDelete->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_TEST_REFERENCE));

            $firstTrickImgTrickDeleteAjax->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_AJAX_TEST_REFERENCE));
            $secondTrickImgTrickDeleteAjax->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_AJAX_TEST_REFERENCE));

            $trickImgHome->setTrick($this->getReference(TrickFixtures::TRICK_HOME_TEST_REFERENCE));

            $manager->persist($firstTrickImgTrickUpdate);
            $manager->persist($secondTrickImgTrickUpdate);

            $manager->persist($trickImgTrickView);

            $manager->persist($firstTrickImgTrickDelete);
            $manager->persist($secondTrickImgTrickDelete);

            $manager->persist($firstTrickImgTrickDeleteAjax);
            $manager->persist($secondTrickImgTrickDeleteAjax);

            $manager->persist($trickImgHome);
        }

        if ($env == 'dev') {
            $fileDir = __DIR__.'/../../../web/img/assets/trick/';

            copy($fileDir.'first-japan-air.jpg', $fileDir.'first-japan-air-copy.jpg');
            copy($fileDir.'second-japan-air.jpg', $fileDir.'second-japan-air-copy.jpg');

            copy($fileDir.'first-one-hundred-eighty.jpg', $fileDir.'first-one-hundred-eighty-copy.jpg');
            copy($fileDir.'second-one-hundred-eighty.jpg', $fileDir.'second-one-hundred-eighty-copy.jpg');

            copy($fileDir.'back-flip.jpg', $fileDir.'back-flip-copy.jpg');

            copy($fileDir.'cork-screw.jpg', $fileDir.'cork-screw-copy.jpg');

            copy($fileDir.'tail-slide.jpg', $fileDir.'tail-slide-copy.jpg');

            copy($fileDir.'rocket-air.jpeg', $fileDir.'rocket-air-copy.jpeg');
            
            copy($fileDir.'stal-fish.jpg', $fileDir.'stal-fish-copy.jpg');

            copy($fileDir.'haakon-flip.jpg', $fileDir.'haakon-flip-copy.jpg');

            copy($fileDir.'truck-driver.jpg', $fileDir.'truck-driver-copy.jpg');

            copy($fileDir.'seat-belt.jpeg', $fileDir.'seat-belt-copy.jpeg');

            copy($fileDir.'nose-grab.jpeg', $fileDir.'nose-grab-copy.jpeg');

            copy($fileDir.'tail-grab.jpg', $fileDir.'tail-grab-copy.jpg');

            copy($fileDir.'indy.jpg', $fileDir.'indy-copy.jpg');

            copy($fileDir.'sad.jpg', $fileDir.'sad-copy.jpg');

            copy($fileDir.'first-mute.jpg', $fileDir.'first-mute-copy.jpg');
            copy($fileDir.'second-mute.jpg', $fileDir.'second-mute-copy.jpg');
            copy($fileDir.'third-mute.jpg', $fileDir.'third-mute-copy.jpg');

            $firstImgJapanAir = new TrickImage;
            $secondImgJapanAir = new TrickImage;
            
            $firstImgOneHundredEighty = new TrickImage;
            $secondImgOneHundredEighty = new TrickImage;

            $imgBackFlip = new TrickImage;

            $imgCorkScrew = new TrickImage;

            $imgTailSlide = new TrickImage;

            $imgRocketAir = new TrickImage;

            $imgStalFish = new TrickImage;

            $imgHaakonFlip = new TrickImage;

            $imgTruckDriver = new TrickImage;

            $imgSeatBelt = new TrickImage;

            $imgNoseGrab = new TrickImage;

            $imgTailGrab = new TrickImage;

            $imgIndy = new TrickImage;

            $imgSad = new TrickImage;

            $imgFirstMute = new TrickImage;
            $imgSecondMute = new TrickImage;
            $imgThirdMute = new TrickImage;

            $firstFileJapanAir = new UploadedFile(
                $fileDir.'first-japan-air-copy.jpg',
                'first-japan-air-copy.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $secondFileJapanAir = new UploadedFile(
                $fileDir.'second-japan-air-copy.jpg',
                'second-japan-air-copy.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $firstFileOneHundredEighty = new UploadedFile(
                $fileDir.'first-one-hundred-eighty-copy.jpg',
                'first-one-hundred-eighty-copy.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $secondFileOneHundredEighty = new UploadedFile(
                $fileDir.'second-one-hundred-eighty-copy.jpg',
                'second-one-hundred-eighty-copy.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $fileBackFlip = new UploadedFile(
                $fileDir.'back-flip-copy.jpg',
                'back-flip-copy.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $fileCorkScrew = new UploadedFile(
                $fileDir.'cork-screw-copy.jpg',
                'cork-screw-copy.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $fileTailSlide = new UploadedFile(
                $fileDir.'tail-slide-copy.jpg',
                'tail-slide-copy.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $fileRocketAir = new UploadedFile(
                $fileDir.'rocket-air-copy.jpeg',
                'rocket-air-copy.jpeg',
                'image/jpeg',
                null,
                null,
                true
            );

            $fileStalFish = new UploadedFile(
                $fileDir.'stal-fish-copy.jpg',
                'stal-fish-copy.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $fileHaakonFlip = new UploadedFile(
                $fileDir.'haakon-flip-copy.jpg',
                'haakon-flip-copy.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $fileTruckDriver = new UploadedFile(
                $fileDir.'truck-driver-copy.jpg',
                'truck-driver-copy.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $fileSeatBelt = new UploadedFile(
                $fileDir.'seat-belt-copy.jpeg',
                'seat-belt-copy.jpeg',
                'image/jpeg',
                null,
                null,
                true
            );

            $fileNoseGrab = new UploadedFile(
                $fileDir.'nose-grab-copy.jpeg',
                'nose-grab-copy.jpeg',
                'image/jpeg',
                null,
                null,
                true
            );

            $fileTailGrab = new UploadedFile(
                $fileDir.'tail-grab-copy.jpg',
                'tail-grab-copy.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $fileIndy = new UploadedFile(
                $fileDir.'indy-copy.jpg',
                'indy-copy.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $fileSad = new UploadedFile(
                $fileDir.'sad-copy.jpg',
                'sad-copy.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $fileFirstMute = new UploadedFile(
                $fileDir.'first-mute-copy.jpg',
                'first-mute-copy.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $fileSecondMute = new UploadedFile(
                $fileDir.'second-mute-copy.jpg',
                'second-mute-copy.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $fileThirdMute = new UploadedFile(
                $fileDir.'third-mute-copy.jpg',
                'third-mute-copy.jpg',
                'image/jpeg',
                null,
                null,
                true
            );

            $firstImgJapanAir->setFile($firstFileJapanAir);
            $secondImgJapanAir->setFile($secondFileJapanAir);

            $firstImgOneHundredEighty->setFile($firstFileOneHundredEighty);
            $secondImgOneHundredEighty->setFile($secondFileOneHundredEighty);

            $imgBackFlip->setFile($fileBackFlip);

            $imgCorkScrew->setFile($fileCorkScrew);

            $imgTailSlide->setFile($fileTailSlide);

            $imgRocketAir->setFile($fileRocketAir);

            $imgStalFish->setFile($fileStalFish);

            $imgHaakonFlip->setFile($fileHaakonFlip);

            $imgTruckDriver->setFile($fileTruckDriver);

            $imgSeatBelt->setFile($fileSeatBelt);

            $imgNoseGrab->setFile($fileNoseGrab);
            
            $imgTailGrab->setFile($fileTailGrab);

            $imgIndy->setFile($fileIndy);

            $imgSad->setFile($fileSad);

            $imgFirstMute->setFile($fileFirstMute);
            $imgSecondMute->setFile($fileSecondMute);
            $imgThirdMute->setFile($fileThirdMute);

            $firstImgJapanAir->setTrick($this->getReference(TrickFixtures::TRICK_JAPAN_AIR_DEMO_REFERENCE));
            $secondImgJapanAir->setTrick($this->getReference(TrickFixtures::TRICK_JAPAN_AIR_DEMO_REFERENCE));

            $firstImgOneHundredEighty->setTrick($this->getReference(TrickFixtures::TRICK_ONE_HUNDRED_EIGHTY_DEMO_REFERENCE));
            $secondImgOneHundredEighty->setTrick($this->getReference(TrickFixtures::TRICK_ONE_HUNDRED_EIGHTY_DEMO_REFERENCE));

            $imgBackFlip->setTrick($this->getReference(TrickFixtures::TRICK_BACK_FLIP_DEMO_REFERENCE));

            $imgCorkScrew->setTrick($this->getReference(TrickFixtures::TRICK_CORK_SCREW_DEMO_REFERENCE));

            $imgTailSlide->setTrick($this->getReference(TrickFixtures::TRICK_TAIL_SLIDE_DEMO_REFERENCE));

            $imgRocketAir->setTrick($this->getReference(TrickFixtures::TRICK_ROCKET_AIR_DEMO_REFERENCE));

            $imgStalFish->setTrick($this->getReference(TrickFixtures::TRICK_STALFISH_DEMO_REFERENCE));

            $imgHaakonFlip->setTrick($this->getReference(TrickFixtures::TRICK_HAAKON_FLIP_DEMO_REFERENCE));

            $imgTruckDriver->setTrick($this->getReference(TrickFixtures::TRICK_TRUCK_DRIVER_DEMO_REFERENCE));

            $imgSeatBelt->setTrick($this->getReference(TrickFixtures::TRICK_SEAT_BELT_DEMO_REFERENCE));

            $imgNoseGrab->setTrick($this->getReference(TrickFixtures::TRICK_NOSE_GRAB_DEMO_REFERENCE));

            $imgTailGrab->setTrick($this->getReference(TrickFixtures::TRICK_TAIL_GRAB_DEMO_REFERENCE));

            $imgIndy->setTrick($this->getReference(TrickFixtures::TRICK_INDY_DEMO_REFERENCE));

            $imgSad->setTrick($this->getReference(TrickFixtures::TRICK_SAD_DEMO_REFERENCE));

            $imgFirstMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $imgSecondMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
            $imgThirdMute->setTrick($this->getReference(TrickFixtures::TRICK_MUTE_DEMO_REFERENCE));
        
            $manager->persist($firstImgJapanAir);
            $manager->persist($secondImgJapanAir);

            $manager->persist($firstImgOneHundredEighty);
            $manager->persist($secondImgOneHundredEighty);

            $manager->persist($imgBackFlip);

            $manager->persist($imgCorkScrew);

            $manager->persist($imgTailSlide);

            $manager->persist($imgRocketAir);

            $manager->persist($imgStalFish);

            $manager->persist($imgHaakonFlip);
            
            $manager->persist($imgTruckDriver);
            
            $manager->persist($imgSeatBelt);

            $manager->persist($imgNoseGrab);

            $manager->persist($imgTailGrab);

            $manager->persist($imgIndy);

            $manager->persist($imgSad);

            $manager->persist($imgFirstMute);
            $manager->persist($imgSecondMute);
            $manager->persist($imgThirdMute);
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