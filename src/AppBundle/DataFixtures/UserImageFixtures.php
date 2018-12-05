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

    /**
     * @var string
     */
    const USERIMAGE_ENABLED_USER_REFERENCE = 'userimage-enabled-user';

    /**
     * @var string
     */
    const USERIMAGE_INACTIVE_USER_REFERENCE = 'userimage-inactive-user';

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
        copy($fileDir.'userimage.png', $fileDir.'userimage-copy2.png');

        $userImage = new UserImage;
        $userImageEnabledUser = new UserImage;
        $userImageInactiveUser = new UserImage;

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
        $fileInactiveUser = new UploadedFile(
            __DIR__.'/../../../tests/AppBundle/uploads/userimage-copy2.png',
            'userimage.png',
            'image/png',
            null,
            null,
            true
        );

        $userImage->setFile($file);
        $userImageEnabledUser->setFile($fileEnabledUser);
        $userImageInactiveUser->setFile($fileInactiveUser);

        $manager->persist($userImage);
        $manager->persist($userImageEnabledUser);
        $manager->persist($userImageInactiveUser);
        $manager->flush();

        $this->addReference(self::USERIMAGE_REFERENCE, $userImage);
        $this->addReference(self::USERIMAGE_ENABLED_USER_REFERENCE, $userImageEnabledUser);
        $this->addReference(self::USERIMAGE_INACTIVE_USER_REFERENCE, $userImageInactiveUser);
    }
}