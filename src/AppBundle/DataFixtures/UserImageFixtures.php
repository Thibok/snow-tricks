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
    const VALID_REGISTRATION_USERIMAGE_REFERENCE = 'userimage-valid-registration';

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
    const USERIMAGE_RESET_PASS_BAD_REFERENCE = 'userimage-reset-pass-bad-user';

    /**
     * @var string
     */
    const USERIMAGE_RESET_PASS_EXPIRED_REFERENCE = 'userimage-reset-pass-expired';

    /**
     * @var string
     */
    const USERIMAGE_VALID_REGISTRATION_EXPIRED_REFERENCE = 'userimage-valid-registration-expired';

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

        copy($fileDir.'userimage.png', $fileDir.'img-valid-registration.png');
        copy($fileDir.'userimage.png', $fileDir.'img-valid-registration-expired.png');

        copy($fileDir.'userimage.png', $fileDir.'img-enabled-user.png');

        copy($fileDir.'userimage.png', $fileDir.'img-inactive-user.png');

        copy($fileDir.'userimage.png', $fileDir.'img-reset-pass-user.png');
        copy($fileDir.'userimage.png', $fileDir.'img-bad-reset-pass-user.png');
        copy($fileDir.'userimage.png', $fileDir.'img-expired-reset-pass-user');

        $userImgValidRegistration = new UserImage;
        $userImgValidRegistrationExpired = new UserImage;

        $userImgEnabledUser = new UserImage;

        $userImgInactiveUser = new UserImage;

        $userImgResetPassUser = new UserImage;
        $userImgResetPassBadUser = new UserImage;
        $userImgResetPassExpired = new UserImage;

        $fileValidRegistration = new UploadedFile(
            __DIR__.'/../../../tests/AppBundle/uploads/img-valid-registration.png',
            'img-valid-registration.png',
            'image/png',
            null,
            null,
            true
        );

        $fileValidRegistrationExpired = new UploadedFile(
            __DIR__.'/../../../tests/AppBundle/uploads/img-valid-registration-expired.png',
            'img-valid-registration-expired.png',
            'image/png',
            null,
            null,
            true
        );

        $fileEnabledUser = new UploadedFile(
            __DIR__.'/../../../tests/AppBundle/uploads/img-enabled-user.png',
            'img-enabled-user.png',
            'image/png',
            null,
            null,
            true
        );

        $fileInactiveUser = new UploadedFile(
            __DIR__.'/../../../tests/AppBundle/uploads/img-inactive-user.png',
            'img-inactive-user.png',
            'image/png',
            null,
            null,
            true
        );

        $fileResetPassUser = new UploadedFile(
            __DIR__.'/../../../tests/AppBundle/uploads/img-reset-pass-user.png',
            'img-reset-pass-user.png',
            'image/png',
            null,
            null,
            true
        );

        $fileResetPassBadUser = new UploadedFile(
            __DIR__.'/../../../tests/AppBundle/uploads/img-bad-reset-pass-user.png',
            'img-bad-reset-pass-user.png',
            'image/png',
            null,
            null,
            true
        );

        $fileResetPassExpired = new UploadedFile(
            __DIR__.'/../../../tests/AppBundle/uploads/img-expired-reset-pass-user',
            'img-expired-reset-pass-user',
            'image/png',
            null,
            null,
            true
        );

        $userImgValidRegistration->setFile($fileValidRegistration);
        $userImgValidRegistrationExpired->setFile($fileValidRegistrationExpired);

        $userImgEnabledUser->setFile($fileEnabledUser);

        $userImgInactiveUser->setFile($fileInactiveUser);

        $userImgResetPassUser->setFile($fileResetPassUser);
        $userImgResetPassBadUser->setFile($fileResetPassBadUser);
        $userImgResetPassExpired->setFile($fileResetPassExpired);

        $manager->persist($userImgValidRegistration);
        $manager->persist($userImgValidRegistrationExpired);

        $manager->persist($userImgEnabledUser);

        $manager->persist($userImgInactiveUser);

        $manager->persist($userImgResetPassUser);
        $manager->persist($userImgResetPassBadUser);
        $manager->persist($userImgResetPassExpired);

        $manager->flush();

        $this->addReference(self::VALID_REGISTRATION_USERIMAGE_REFERENCE, $userImgValidRegistration);
        $this->addReference(self::USERIMAGE_VALID_REGISTRATION_EXPIRED_REFERENCE, $userImgValidRegistrationExpired);

        $this->addReference(self::USERIMAGE_ENABLED_USER_REFERENCE, $userImgEnabledUser);

        $this->addReference(self::USERIMAGE_INACTIVE_USER_REFERENCE, $userImgInactiveUser);

        $this->addReference(self::USERIMAGE_RESET_PASS_USER_REFERENCE, $userImgResetPassUser);
        $this->addReference(self::USERIMAGE_RESET_PASS_BAD_REFERENCE, $userImgResetPassBadUser);
        $this->addReference(self::USERIMAGE_RESET_PASS_EXPIRED_REFERENCE, $userImgResetPassExpired);
    }
}