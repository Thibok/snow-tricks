<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\UserImage;
use AppBundle\Uploader\ImageUploader;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class UserImageListener
{
    private $uploader;

    public function __construct(ImageUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $userImage = $args->getObject();

        if (!$userImage instanceof UserImage) {
            return;
        }

        $file = $userImage->getFile();
        $extension = $file->guessExtension();
        $userImage->setExtension($extension);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $userImage = $args->getObject();

        if (!$userImage instanceof UserImage) {
            return;
        }

        $filename = $this->uploader->upload($userImage->getFile());
        $this->uploader->setTargetDir($userImage->getUploadRootDir());
        $thumbName = 'user-thumb-'.$userImage->getId();
        $name = 'user-'.$userImage->getid();

        $this->uploader->resize($filename, 50, 50, $thumbName);
        $this->uploader->resize($filename, 300, 360, $name);
        $this->uploader->remove($filename);
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $userImage = $args->getObject();

        if (!$userImage instanceof UserImage) {
            return;
        }

        $id = $userImage->getId();
        $extension = $userImage->getExtension();

        $userImage->setTempFilename('user-'.$id.'.'.$extension);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $userImage = $args->getObject();

        if (!$userImage instanceof UserImage) {
            return;
        }

        $filename = $userImage->getTempFilename();
        $thumb = str_replace('-', '-thumb-', $filename);
        $this->uploader->setTargetDir($userImage->getUploadRootDir());

        $this->uploader->remove($filename);
        $this->uploader->remove($thumb);
    }
}