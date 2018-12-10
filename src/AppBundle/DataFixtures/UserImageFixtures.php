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
     * @var string
     */
    const USERIMAGE_RESET_PASS_USER_REFERENCE = 'userimage-reset-pass-user';

    /**
     * @var string
     */
    const USERIMAGE_RESET_PASS_OTHER_USER_REFERENCE = 'userimage-reset-pass-other-user';

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
        copy($fileDir.'userimage.png', $fileDir.'userimage-copy3.png');
        copy($fileDir.'userimage.png', $fileDir.'userimage-copy4.png');

        $userImage = new UserImage;
        $userImageEnabledUser = new UserImage;
        $userImageInactiveUser = new UserImage;
        $userImageResetPassUser = new UserImage;
        $userImageResetPassOtherUser = new UserImage;

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

        $fileResetPassUser = new UploadedFile(
            __DIR__.'/../../../tests/AppBundle/uploads/userimage-copy3.png',
            'userimage.png',
            'image/png',
            null,
            null,
            true
        );

        $fileResetPassOtherUser = new UploadedFile(
            __DIR__.'/../../../tests/AppBundle/uploads/userimage-copy4.png',
            'userimage.png',
            'image/png',
            null,
            null,
            true
        );

        $userImage->setFile($file);
        $userImageEnabledUser->setFile($fileEnabledUser);
        $userImageInactiveUser->setFile($fileInactiveUser);
        $userImageResetPassUser->setFile($fileResetPassUser);
        $userImageResetPassOtherUser->setFile($fileResetPassOtherUser);

        $manager->persist($userImage);
        $manager->persist($userImageEnabledUser);
        $manager->persist($userImageInactiveUser);
        $manager->persist($userImageResetPassUser);
        $manager->persist($userImageResetPassOtherUser);
        $manager->flush();

        $this->addReference(self::USERIMAGE_REFERENCE, $userImage);
        $this->addReference(self::USERIMAGE_ENABLED_USER_REFERENCE, $userImageEnabledUser);
        $this->addReference(self::USERIMAGE_INACTIVE_USER_REFERENCE, $userImageInactiveUser);
        $this->addReference(self::USERIMAGE_RESET_PASS_USER_REFERENCE, $userImageResetPassUser);
        $this->addReference(self::USERIMAGE_RESET_PASS_OTHER_USER_REFERENCE, $userImageResetPassOtherUser);
    }
}