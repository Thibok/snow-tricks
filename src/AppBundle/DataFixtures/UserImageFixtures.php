<?php

/**
 * UserImage Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\UserImage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * UserImageFixtures
 */
class UserImageFixtures extends Fixture
{
    /**
     * @var string
     */
    const USERIMAGE_REFERENCE = 'userimage';
    const USERIMAGE_ENABLED_USER_REFERENCE = 'userimage-enabled-user';

    /**
     * Load fixtures
     * @access public
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $fileDir = __DIR__.'/../../../tests/AppBundle/uploads/';

        copy($fileDir.'userimage.png', $fileDir.'userimage-copy.png');
        copy($fileDir.'userimage.png', $fileDir.'userimage-copy1.png');

        $userImage = new UserImage;
        $userImageEnabledUser = new UserImage;

        $file = new UploadedFile(
            __DIR__.'/../../../tests/AppBundle/uploads/userimage-copy.png',
            'userimage.png',
            'image/png',
            null,
            null,
            true
        );
        $fileEnabledUser = new UploadedFile(
            __DIR__.'/../../../tests/AppBundle/uploads/userimage-copy1.png',
            'userimage.png',
            'image/png',
            null,
            null,
            true
        );

        $userImage->setFile($file);
        $userImageEnabledUser->setFile($fileEnabledUser);

        $manager->persist($userImage);
        $manager->persist($userImageEnabledUser);
        $manager->flush();

        $this->addReference(self::USERIMAGE_REFERENCE, $userImage);
        $this->addReference(self::USERIMAGE_ENABLED_USER_REFERENCE, $userImageEnabledUser);
    }
}