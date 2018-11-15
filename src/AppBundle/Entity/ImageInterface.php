<?php

/**
 * Interface that represents the functions that an image class must implement. 
 */

namespace AppBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image interface
 */
interface ImageInterface
{
    /**
     * Set extension
     * @access public
     * @param string $extension
     */
    public function setExtension($extension);

    /**
     * Get extension
     * @access public
     * @return string
     */
    public function getExtension();

    /**
     * Set file
     * @access public
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file);

    /**
     * Get file
     * @access public
     * @return UploadedFile
     */
    public function getFile();

    /**
     * Set tempFilename
     * @access public
     * @param string $tempFilename
     */
    public function setTempFilename($tempFilename);

    /**
     * Get tempFilename
     * @access public
     * @return string
     */
    public function getTempFilename();

    /**
     * Get uploadDir (web path)
     * @access public
     * @return string
     */
    public function getUploadDir();

    /**
     * Get uploadRootDir
     * @access public
     * @return string
     */
    public function getUploadRootDir();
}