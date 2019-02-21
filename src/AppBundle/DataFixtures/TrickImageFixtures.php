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

        copy($fileDir.'goodTrickImg.jpg', $fileDir.'goodTrickImg-copy.jpg');
        copy($fileDir.'goodTrickImg.jpg', $fileDir.'goodTrickImg-copy-1.jpg');
        copy($fileDir.'otherGoodTrickImg.jpeg', $fileDir.'otherGoodTrickImg-copy.jpeg');

        $firstTrickImgTrickUpdate = new TrickImage;
        $secondTrickImgTrickUpdate = new TrickImage;
        $trickImgTrickView = new TrickImage;

        $firstFileTrickUpdate = new UploadedFile(
            $fileDir.'goodTrickImg-copy.jpg',
            'goodTrickImg-copy.jpg',
            'image/jpeg',
            null,
            null,
            true
        );

        $secondFileTrickUpdate = new UploadedFile(
            $fileDir.'otherGoodTrickImg-copy.jpeg',
            'otherGoodTrickImg-copy.jpeg',
            'image/jpeg',
            null,
            null,
            true
        );

        $fileTrickView = new UploadedFile(
            $fileDir.'goodTrickImg-copy-1.jpg',
            'goodTrickImg-copy-1.jpg',
            'image/jpeg',
            null,
            null,
            true
        );

        $firstTrickImgTrickUpdate->setFile($firstFileTrickUpdate);
        $secondTrickImgTrickUpdate->setFile($secondFileTrickUpdate);
        $trickImgTrickView->setFile($fileTrickView);
        $firstTrickImgTrickUpdate->setTrick($this->getReference(TrickFixtures::TRICK_UPDATE_REFERENCE));
        $secondTrickImgTrickUpdate->setTrick($this->getReference(TrickFixtures::TRICK_UPDATE_REFERENCE));
        $trickImgTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));

        $manager->persist($firstTrickImgTrickUpdate);
        $manager->persist($secondTrickImgTrickUpdate);
        $manager->persist($trickImgTrickView);

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