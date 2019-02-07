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
        copy($fileDir.'otherGoodTrickImg.jpeg', $fileDir.'otherGoodTrickImg-copy.jpeg');

        $trickImg = new TrickImage;
        $otherTrickImg = new TrickImage;

        $file = new UploadedFile(
            $fileDir.'goodTrickImg-copy.jpg',
            'goodTrickImg-copy.jpg',
            'image/jpeg',
            null,
            null,
            true
        );

        $otherFile = new UploadedFile(
            $fileDir.'otherGoodTrickImg-copy.jpeg',
            'otherGoodTrickImg-copy.jpeg',
            'image/jpeg',
            null,
            null,
            true
        );

        $trickImg->setFile($file);
        $otherTrickImg->setFile($otherFile);
        $trickImg->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE));
        $otherTrickImg->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE));

        $manager->persist($trickImg);
        $manager->persist($otherTrickImg);

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