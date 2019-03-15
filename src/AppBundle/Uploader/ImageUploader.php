<?php

/**
 * Image Uploader
 */

namespace AppBundle\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * ImageUploader
 */
class ImageUploader
{
    /**
     * @var string
     */
    const BASE_DIR = __DIR__.'/../../../web/uploads/img';

    /**
     * @var string
     */
    const BASE_TEST_DIR = __DIR__.'/../../../web/uploads/img/tests';

    /**
     * @var string
     * @access private
     */
    private $targetDir;

    /**
     * @var string
     * @access private
     */
    private $env;

    /**
     * Constructor
     * @access public
     * @param string $env
     * 
     * @return void
     */
    public function __construct($env)
    {
        $this->env = $env;
    }

    /**
     * Upload an image
     * @access public
     * @param UploadedFile $file
     * 
     * @return string
     */
    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        if ($this->env == 'test') {
            $dir = self::BASE_TEST_DIR;
        } else {
            $dir = self::BASE_DIR;
        }

        $file->move($dir, $fileName);

        return $fileName;
    }
    
    /**
     * Resize an image
     * @access public
     * @param string $filename
     * @param int $width
     * @param int $height
     * @param mixed string | null $newName
     * 
     * @return void
     */
    public function resize($filename, $width, $height, $newName = null)
    {
        if ($this->env == 'test') {
            $baseDir = self::BASE_TEST_DIR;
        } else {
            $baseDir = self::BASE_DIR;
        }

        $path = $baseDir.'/'.$filename;
        
        if (!file_exists($path)) {
            return;
        }
        
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        if ($extension == 'jpg' || $extension == 'jpeg') {
            $source = imagecreatefromjpeg($path);
            $method = 'imagejpeg';
        } elseif ($extension == 'png') {
            $source = imagecreatefrompng($path);
            $method = 'imagepng';
        } else {
            return;
        }

        $destination = imagecreatetruecolor($width, $height);

        $width_source = imagesx($source);
        $height_source = imagesy($source);
        $width_destination = imagesx($destination);
        $height_destination = imagesy($destination);

        imagecopyresampled($destination, $source, 0, 0, 0, 0, $width_destination, $height_destination, $width_source, $height_source);

        if ($this->targetDir !== null) {
            $destinationDir = $this->targetDir;
        } else {
            $destinationDir = $baseDir;
        }

        if ($newName != null) {
            $method($destination, $destinationDir.'/'.$newName.'.'.$extension);
        } else {
            $method($destination, $destinationDir.'/'.$filename);
        }
    }

    /**
     * Remove an image
     * @access public
     * @param string $filename
     * 
     * @return void
     */
    public function remove($filename)
    {
        if ($this->env == 'test') {
            $basePath = self::BASE_TEST_DIR.'/'.$filename;
        } else {
            $basePath = self::BASE_DIR.'/'.$filename;
        }
        
        $targetPath = $this->targetDir.'/'.$filename;

        if (file_exists($basePath)) {
            unlink($basePath);
        } else if (file_exists($targetPath)) {
            unlink($targetPath);
        }
        
        return;
    }

    /**
     * Set the target directory
     * @access public
     * @param string $targetDir
     * 
     * @return void
     */
    public function setTargetDir($targetDir)
    {
        $this->targetDir = $targetDir;
    }
}