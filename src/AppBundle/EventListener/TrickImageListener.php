<?php

/**
 * Trick image listener
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\TrickImage;
use AppBundle\Uploader\ImageUploader;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

/**
 * TrickImageListener
 */
class TrickImageListener
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
     * Listen prePersist event of TrickImage
     * @access public
     * @param LifecycleEventArgs $args
     * 
     * @return void
     */
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

    /**
     * Listen postPersist event of TrickImage
     * @access public
     * @param LifecycleEventArgs $args
     * 
     * @return void
     */
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