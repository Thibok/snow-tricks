<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\TrickImage;
use AppBundle\Uploader\ImageUploader;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class TrickImageListener
{
    private $uploader;
    private $env;

    public function __construct(ImageUploader $uploader, $env)
    {
        $this->uploader = $uploader;
        $this->env = $env;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $trickImage = $args->getObject();

        if (!$trickImage instanceof TrickImage) {
            return;
        }

        $file = $trickImage->getFile();

        if ($file !== null) {
            $extension = $file->guessExtension();
            $trickImage->setExtension($extension);
        }
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $trickImage = $args->getObject();

        if (!$trickImage instanceof TrickImage) {
            return;
        }

        $file = $trickImage->getFile();

        if ($file !== null) {
            if ($this->env == 'test') {
                $targetDir = $trickImage->getUploadRootTestDir();
            } else {
                $targetDir = $trickImage->getUploadRootDir();
            }
    
            $filename = $this->uploader->upload($file);
            $this->uploader->setTargetDir($targetDir);
            $thumbName = 'trick-thumb-'.$trickImage->getId();
            $name = 'trick-'.$trickImage->getId();
    
            $this->uploader->resize($filename, 200, 100, $thumbName);
            $this->uploader->resize($filename, 1200, 500, $name);
            $this->uploader->remove($filename);
        }
    }
}