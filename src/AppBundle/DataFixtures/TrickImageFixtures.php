<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\TrickImage;
use AppBundle\DataFixtures\TrickFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class TrickImageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $fileDir = __DIR__.'/../../../tests/AppBundle/uploads/';

        copy($fileDir.'goodTrickImg.jpg', $fileDir.'trickImg-update-1.jpg');
        copy($fileDir.'otherGoodTrickImg.jpeg', $fileDir.'trickImg-update-2.jpeg');

        copy($fileDir.'goodTrickImg.jpg', $fileDir.'trickImg-view-1.jpg');

        copy($fileDir.'goodTrickImg.jpg', $fileDir.'trickImg-delete-1.jpg');
        copy($fileDir.'goodTrickImg.jpg', $fileDir.'trickImg-delete-2.jpg');

        copy($fileDir.'goodTrickImg.jpg', $fileDir.'trickImg-delete-ajax-1.jpg');
        copy($fileDir.'goodTrickImg.jpg', $fileDir.'trickImg-delete-ajax-2.jpg');

        $firstTrickImgTrickUpdate = new TrickImage;
        $secondTrickImgTrickUpdate = new TrickImage;

        $trickImgTrickView = new TrickImage;
        
        $firstTrickImgTrickDelete = new TrickImage;
        $secondTrickImgTrickDelete = new TrickImage;

        $firstTrickImgTrickDeleteAjax = new TrickImage;
        $secondTrickImgTrickDeleteAjax = new TrickImage;

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

        $firstTrickImgTrickUpdate->setFile($firstFileTrickUpdate);
        $secondTrickImgTrickUpdate->setFile($secondFileTrickUpdate);

        $trickImgTrickView->setFile($fileTrickView);

        $firstTrickImgTrickDelete->setFile($firstFileTrickDelete);
        $secondTrickImgTrickDelete->setFile($secondFileTrickDelete);

        $firstTrickImgTrickDeleteAjax->setFile($firstFileTrickDeleteAjax);
        $secondTrickImgTrickDeleteAjax->setFile($secondFileTrickDeleteAjax);

        $firstTrickImgTrickUpdate->setTrick($this->getReference(TrickFixtures::TRICK_UPDATE_REFERENCE));
        $secondTrickImgTrickUpdate->setTrick($this->getReference(TrickFixtures::TRICK_UPDATE_REFERENCE));

        $trickImgTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));

        $firstTrickImgTrickDelete->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_REFERENCE));
        $secondTrickImgTrickDelete->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_REFERENCE));

        $firstTrickImgTrickDeleteAjax->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_AJAX_REFERENCE));
        $secondTrickImgTrickDeleteAjax->setTrick($this->getReference(TrickFixtures::TRICK_DELETE_AJAX_REFERENCE));

        $manager->persist($firstTrickImgTrickUpdate);
        $manager->persist($secondTrickImgTrickUpdate);

        $manager->persist($trickImgTrickView);

        $manager->persist($firstTrickImgTrickDelete);
        $manager->persist($secondTrickImgTrickDelete);

        $manager->persist($firstTrickImgTrickDeleteAjax);
        $manager->persist($secondTrickImgTrickDeleteAjax);

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
            TrickFixtures::class,
        );
    }
}