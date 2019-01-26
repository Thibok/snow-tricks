<?php

/**
 * UserImage listener
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\UserImage;
use AppBundle\Uploader\ImageUploader;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

/**
 * UserImageListener
 */
class UserImageListener
{
    /**
     * @var ImageUploader
     * @access private
     */
    private $uploader;

    /**
     * @var string
     * @access private
     */
    private $env;

    /**
     * Constructor
     * @access public
     * @param ImageUploader $uploader
     * @param string $env
     * 
     * @return void
     */
    public function __construct(ImageUploader $uploader, $env)
    {
        $this->uploader = $uploader;
        $this->env = $env;
    }

    /**
     * Listen Pre Persist event of UserImage
     * @access public
     * @param LifecycleEventArgs $args
     * 
     * @return void
     */
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

    /**
     * Listen Post Persist event of UserImage
     * @access public
     * @param LifecycleEventArgs $args
     * 
     * @return void
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $userImage = $args->getObject();

        if (!$userImage instanceof UserImage) {
            return;
        }

        if ($this->env == 'test') {
            $targetDir = $userImage->getUploadRootTestDir();
        } else {
            $targetDir = $userImage->getUploadRootDir();
        }

        $filename = $this->uploader->upload($userImage->getFile());
        $this->uploader->setTargetDir($targetDir);
        $thumbName = 'user-thumb-'.$userImage->getId();
        $name = 'user-'.$userImage->getId();

        $this->uploader->resize($filename, 50, 50, $thumbName);
        $this->uploader->resize($filename, 300, 360, $name);
        $this->uploader->remove($filename);
    }

    /**
     * Listen Pre Remove event of UserImage
     * @access public
     * @param LifecycleEventArgs $args
     * 
     * @return void
     */
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

    /**
     * Listen Pre Remove event of UserImage
     * @access public
     * @param LifecycleEventArgs $args
     * 
     * @return void
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $userImage = $args->getObject();

        if (!$userImage instanceof UserImage) {
            return;
        }

        if ($this->env == 'test') {
            $targetDir = $userImage->getUploadRootTestDir();
        } else {
            $targetDir = $userImage->getUploadRootDir();
        }

        $filename = $userImage->getTempFilename();
        $thumb = str_replace('-', '-thumb-', $filename);
        $this->uploader->setTargetDir($targetDir);

        $this->uploader->remove($filename);
        $this->uploader->remove($thumb);
    }
}