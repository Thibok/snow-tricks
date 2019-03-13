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