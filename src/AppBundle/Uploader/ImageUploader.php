<?php

namespace AppBundle\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploader
{
    const BASE_DIR = __DIR__.'/../../../web/uploads/img';

    private $targetDir;

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move(self::BASE_DIR, $fileName);

        return $fileName;
    }

    public function resize($filename, $width, $height, $newName = null)
    {
        if (file_exists(self::BASE_DIR.'/'.$filename)) {
            $path = self::BASE_DIR.'/'.$filename;
        } else if (file_exists($this->targetDir.'/'.$filename)) {
            $path = $this->targetDir.'/'.$filename;
        } else {
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

        imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);

        if ($this->targetDir !== null) {
            $destinationDir = $this->targetDir;
        } else {
            $destinationDir = self::BASE_DIR;
        }

        if ($newName != null) {
            $method($destination, $destinationDir.'/'.$newName.'.'.$extension);
        } else {
            $method($destination, $destinationDir.'/'.$filename);
        }
    }

    public function remove($filename)
    {
        if (file_exists(self::BASE_DIR.'/'.$filename)) {
            $path = self::BASE_DIR.'/'.$filename;
        } else if (file_exists($this->targetDir.'/'.$filename)) {
            $path = $this->targetDir.'/'.$filename;
        } else {
            return;
        }

        unlink($path);
        
    }

    public function setTargetDir($targetDir)
    {
        $this->targetDir = $targetDir;
    }
}