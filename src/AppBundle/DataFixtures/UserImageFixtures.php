<?php

/**
 * Load UserImage Fixtures
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\UserImage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * UserImageFixtures
 */
class UserImageFixtures extends Fixture implements ContainerAwareInterface
{
    /**
     * @var string
     */
    const VALID_REGISTRATION_USERIMAGE_TEST_REFERENCE = 'userimage-valid-registration-test';

    /**
     * @var string
     */
    const USERIMAGE_ENABLED_USER_TEST_REFERENCE = 'userimage-enabled-user-test';

    /**
     * @var string
     */
    const USERIMAGE_INACTIVE_USER_TEST_REFERENCE = 'userimage-inactive-user-test';

    /**
     * @var string
     */
    const USERIMAGE_RESET_PASS_USER_TEST_REFERENCE = 'userimage-reset-pass-user-test';

    /**
     * @var string
     */
    const USERIMAGE_RESET_PASS_BAD_TEST_REFERENCE = 'userimage-reset-pass-bad-user-test';

    /**
     * @var string
     */
    const USERIMAGE_RESET_PASS_EXPIRED_TEST_REFERENCE = 'userimage-reset-pass-expired-test';

    /**
     * @var string
     */
    const USERIMAGE_VALID_REGISTRATION_EXPIRED_TEST_REFERENCE = 'userimage-valid-registration-expired-test';

    /**
     * @var string
     */
    const USERIMAGE_DEMO_REFERENCE = 'userimage-demo';

    /**
     * @var ContainerInterface
     * @access private
     */
    private $container;

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $env = $this->container->get('kernel')->getEnvironment();

        if ($env == 'test') {
            $fileDir = __DIR__.'/../../../tests/AppBundle/uploads/';

            copy($fileDir.'userimage.png', $fileDir.'img-valid-registration.png');
            copy($fileDir.'userimage.png', $fileDir.'img-valid-registration-expired.png');

            copy($fileDir.'userimage.png', $fileDir.'img-enabled-user.png');

            copy($fileDir.'userimage.png', $fileDir.'img-inactive-user.png');

            copy($fileDir.'userimage.png', $fileDir.'img-reset-pass-user.png');
            copy($fileDir.'userimage.png', $fileDir.'img-bad-reset-pass-user.png');
            copy($fileDir.'userimage.png', $fileDir.'img-expired-reset-pass-user');

            $imgValidRegistration = new UserImage;
            $imgValidRegistrationExpired = new UserImage;

            $imgEnabledUser = new UserImage;

            $imgInactiveUser = new UserImage;

            $imgResetPassUser = new UserImage;
            $imgResetPassBadUser = new UserImage;
            $imgResetPassExpired = new UserImage;

            $fileValidRegistration = new UploadedFile(
                $fileDir.'img-valid-registration.png',
                'img-valid-registration.png',
                'image/png',
                null,
                null,
                true
            );

            $fileValidRegistrationExpired = new UploadedFile(
                $fileDir.'img-valid-registration-expired.png',
                'img-valid-registration-expired.png',
                'image/png',
                null,
                null,
                true
            );

            $fileEnabledUser = new UploadedFile(
                $fileDir.'img-enabled-user.png',
                'img-enabled-user.png',
                'image/png',
                null,
                null,
                true
            );

            $fileInactiveUser = new UploadedFile(
                $fileDir.'img-inactive-user.png',
                'img-inactive-user.png',
                'image/png',
                null,
                null,
                true
            );

            $fileResetPassUser = new UploadedFile(
                $fileDir.'img-reset-pass-user.png',
                'img-reset-pass-user.png',
                'image/png',
                null,
                null,
                true
            );

            $fileResetPassBadUser = new UploadedFile(
                $fileDir.'img-bad-reset-pass-user.png',
                'img-bad-reset-pass-user.png',
                'image/png',
                null,
                null,
                true
            );

            $fileResetPassExpired = new UploadedFile(
                $fileDir.'img-expired-reset-pass-user',
                'img-expired-reset-pass-user',
                'image/png',
                null,
                null,
                true
            );

            $imgValidRegistration->setFile($fileValidRegistration);
            $imgValidRegistrationExpired->setFile($fileValidRegistrationExpired);

            $imgEnabledUser->setFile($fileEnabledUser);

            $imgInactiveUser->setFile($fileInactiveUser);

            $imgResetPassUser->setFile($fileResetPassUser);
            $imgResetPassBadUser->setFile($fileResetPassBadUser);
            $imgResetPassExpired->setFile($fileResetPassExpired);

            $manager->persist($imgValidRegistration);
            $manager->persist($imgValidRegistrationExpired);

            $manager->persist($imgEnabledUser);

            $manager->persist($imgInactiveUser);

            $manager->persist($imgResetPassUser);
            $manager->persist($imgResetPassBadUser);
            $manager->persist($imgResetPassExpired);
        }

        if ($env == 'dev') {
            $fileDir = __DIR__.'/../../../web/img/assets/user/';

            $imgDemo = new UserImage;

            copy($fileDir.'demo-user-img.png', $fileDir.'demo-user-img-copy.png');

            $fileDemoUserImg = new UploadedFile(
                $fileDir.'demo-user-img-copy.png',
                'demo-user-img-copy.png',
                'image/png',
                null,
                null,
                true
            );

            $imgDemo->setFile($fileDemoUserImg);

            $manager->persist($imgDemo);
        }

        $manager->flush();

        if ($env == 'test') {
            $this->addReference(self::VALID_REGISTRATION_USERIMAGE_TEST_REFERENCE, $imgValidRegistration);
            $this->addReference(self::USERIMAGE_VALID_REGISTRATION_EXPIRED_TEST_REFERENCE, $imgValidRegistrationExpired);

            $this->addReference(self::USERIMAGE_ENABLED_USER_TEST_REFERENCE, $imgEnabledUser);

            $this->addReference(self::USERIMAGE_INACTIVE_USER_TEST_REFERENCE, $imgInactiveUser);

            $this->addReference(self::USERIMAGE_RESET_PASS_USER_TEST_REFERENCE, $imgResetPassUser);
            $this->addReference(self::USERIMAGE_RESET_PASS_BAD_TEST_REFERENCE, $imgResetPassBadUser);
            $this->addReference(self::USERIMAGE_RESET_PASS_EXPIRED_TEST_REFERENCE, $imgResetPassExpired);
        }

        if ($env == 'dev') {
            $this->addReference(self::USERIMAGE_DEMO_REFERENCE, $imgDemo);
        }
    }

    /**
     * @inheritDoc
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}