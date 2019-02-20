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
        $firstVideoTrickUpdate = new Video;
        $secondVideoTrickUpdate = new Video;
        $thirdVideoTrickUpdate = new Video;
        $videoTrickView = new Video;

        $firstVideoTrickUpdate->setUrl('https://www.youtube.com/watch?v=SQyTWk7OxSI');
        $secondVideoTrickUpdate->setUrl('https://www.youtube.com/watch?v=8CtWgw9xYRE');
        $thirdVideoTrickUpdate->setUrl('https://www.youtube.com/watch?v=dSZ7_TXcEdM');
        $videoTrickView->setUrl('https://www.youtube.com/watch?v=dSZ7_TXcEdM');

        $firstVideoTrickUpdate->setTrick($this->getReference(TrickFixtures::TRICK_UPDATE_REFERENCE));
        $secondVideoTrickUpdate->setTrick($this->getReference(TrickFixtures::TRICK_UPDATE_REFERENCE));
        $thirdVideoTrickUpdate->setTrick($this->getReference(TrickFixtures::TRICK_UPDATE_REFERENCE));
        $videoTrickView->setTrick($this->getReference(TrickFixtures::TRICK_VIEW_REFERENCE));

        $manager->persist($firstVideoTrickUpdate);
        $manager->persist($secondVideoTrickUpdate);
        $manager->persist($thirdVideoTrickUpdate);
        $manager->persist($videoTrickView);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            TrickFixtures::class,
        );
    }
}