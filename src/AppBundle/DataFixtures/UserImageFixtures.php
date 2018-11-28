<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\UserImage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserImageFixtures extends Fixture
{
    const USERIMAGE_REFERENCE = 'userimage';

    public function load(ObjectManager $manager)
    {
        $fileDir = __DIR__.'/../../../tests/AppBundle/uploads/';

        copy($fileDir.'userimage.png', $fileDir.'userimage-copy.png');

        $userImage = new UserImage;
        $file = new UploadedFile(
            __DIR__.'/../../../tests/AppBundle/uploads/userimage-copy.png',
            'userimage.png',
            'image/png',
            null,
            null,
            true
        );

        $userImage->setFile($file);

        $manager->persist($userImage);
        $manager->flush();

        $this->addReference(self::USERIMAGE_REFERENCE, $userImage);
    }
}