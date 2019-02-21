<?php

/**
 * TrickImage Entity
 */

namespace AppBundle\Entity;

use AppBundle\Entity\Trick;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\ImageInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * TrickImage
 *
 * @ORM\Table(name="st_trick_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrickImageRepository")
 */
class TrickImage implements ImageInterface
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
     *      maxSize = "6M",
     *      maxSizeMessage = "The image can be up to 6 MB",
     *      disallowEmptyMessage = "The file can't be empty !",
     *      mimeTypes = { "image/jpeg", "image/png", "image/pjpeg", "image/x-png" },
     *      mimeTypesMessage = "Allowed extensions : jpg, jpeg, png",
     *      uploadErrorMessage = "An error occured, try again",
     *      detectCorrupted = true,
     *      corruptedMessage = "The file is corrupt",
     *      sizeNotDetectedMessage = "The file size is not detected"
     * )
     */
    private $file;

    /**
     * @var string
     * @access private
     */
    private $tempFilename;

    /**
     * @var Trick
     * @access private
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Trick", inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trick;


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
     * Set extension
     * @access public
     * @param string $extension
     *
     * @return TrickImage
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     * @access public
     *
     * @return string
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
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        if ($this->extension !== null) {
            $this->tempFilename = $this->id . '.' . $this->extension;
            $this->extension = null;
        }

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
    public function getUploadRootDir()
    {
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    /**
     * {@inheritdoc}
     */
    public function getUploadRootTestDir()
    {
        return __DIR__.'/../../../web/'.$this->getUploadTestDir();
    }

    /**
     * {@inheritdoc}
     */
    public function getUploadWebThumbPath()
    {
        return $this->getUploadDir().'/trick-thumb-'.$this->getId().'.'.$this->getExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function getUploadWebLargePath()
    {
        return $this->getUploadDir().'/trick-'.$this->getId().'.'.$this->getExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function getUploadWebTestThumbPath()
    {
        return $this->getUploadTestDir().'/trick-thumb-'.$this->getId().'.'.$this->getExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function getUploadWebTestLargePath()
    {
        return $this->getUploadTestDir().'/trick-'.$this->getId().'.'.$this->getExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function getUploadDir()
    {
        return 'uploads/img/trick';
    }

    /**
     * {@inheritdoc}
     */
    public function getUploadTestDir()
    {
        return 'uploads/img/tests/trick';
    }

    /**
     * Set trick
     * @access public
     * @param Trick $trick
     *
     * @return TrickImage
     */
    public function setTrick(Trick $trick)
    {
        $this->trick = $trick;

        return $this;
    }

    /**
     * Get trick
     * @access public
     *
     * @return Trick
     */
    public function getTrick()
    {
        return $this->trick;
    }
}
