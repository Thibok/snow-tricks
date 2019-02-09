<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Video;
use AppBundle\DataFixtures\TrickFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class VideoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $video = new Video;
        $otherVideo = new Video;
        $goodVideo = new Video;

        $video->setUrl('https://www.youtube.com/watch?v=SQyTWk7OxSI');
        $otherVideo->setUrl('https://www.youtube.com/watch?v=8CtWgw9xYRE');
        $goodVideo->setUrl('https://www.youtube.com/watch?v=dSZ7_TXcEdM');

        $video->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE));
        $otherVideo->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE));
        $goodVideo->setTrick($this->getReference(TrickFixtures::TRICK_REFERENCE));

        $manager->persist($video);
        $manager->persist($otherVideo);
        $manager->persist($goodVideo);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            TrickFixtures::class,
        );
    }
}