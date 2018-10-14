<?php

/**
 * UserImage Entity
 */

namespace AppBundle\Entity;

use AppBundle\Model\Image;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * UserImage
 *
 * @ORM\Table(name="st_user_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserImageRepository")
 */
class UserImage implements Image
{
    /**
     * @var int
     * @access private
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @access private
     * @ORM\Column(name="extension", type="string", length=5)
     */
    private $extension;

    /**
     * @var UploadedFile
     * @access private
     * @Assert\Image(
     *      maxSize = "16m",
     *      maxSizeMessage = "L'image peut faire 2 Mb maximum",
     *      disallowEmptyMessage = "Le fichier ne peut être vide",
     *      mimeTypes = { "image/jpeg", "image/png", "image/pjpeg", "image/x-png" },
     *      mimeTypesMessage = "Extension autorisé : jpg, jpeg, png",
     *      uploadErrorMessage = "Une erreur est survenue, réessayez",
     *      detectCorrupted = true,
     *      corruptedMessage = "Le fichier est corrompu",
     *      sizeNotDetectedMessage = "La taille du fichier n'est pas détecter"
     * )
     */
    private $file;

    /**
     * @var string
     * @access private
     */
    private $tempFilename;

    /**
     * Get id
     * @access public
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     *
     * @return UserImage
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * {@inheritdoc}
     * 
     * @return UserImage
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * {@inheritdoc}
     * 
     * @return UserImage
     */
    public function setTempFilename($tempFilename)
    {
        $this->tempFilename = $tempFilename;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTempFilename()
    {
        return $this->tempFilename;
    }

    /**
     * {@inheritdoc}
     */
    public function getUploadDir()
    {
        return __DIR__.'/../../../web/uploads/images';
    }
}


