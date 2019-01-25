<?php

/**
 * Video Entity
 */

namespace AppBundle\Entity;

use AppBundle\Entity\Trick;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Video
 *
 * @ORM\Table(name="st_video")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VideoRepository")
 */
class Video
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
     * @ORM\Column(name="url", type="text")
     * @Assert\NotBlank(message="Url of the video can not be empty !")
     * @Assert\Url(
     *      protocols={"https"},
     *      message="Please enter a valid url !"
     * )
     * @Assert\Regex(
     *      pattern="/^(https\:\/\/){1}(www\.youtube\.com\/embed\/[a-zA-Z0-9\?\=\&_-]{1,2053}|www\.dailymotion\.com\/embed\/video\/[a-zA-Z0-9\?\=\&_-]{1,2043}|player\.vimeo\.com\/video\/[a-zA-Z0-9\?\=\#\&_-]{1,2052}|youtu\.be\/[a-zA-Z0-9\?\=\&_-]{1,2066}|www\.youtube\.com\/watch\?v\=[a-zA-Z0-9\?\=\&_-]{1,2051}|www\.dailymotion\.com\/video\/[a-zA-Z0-9\?\=\&_-]{1,2049}|dai\.ly\/[a-zA-Z0-9\?\=\&_-]{1,2068}|vimeo\.com\/[a-zA-Z0-9\?\=\#\&_-]{1,2065})$/",
     *      message="The video must come from Youtube, Dailymotion or Vimeo"
     * )
     * @Assert\Length(
     *      max=2083,
     *      maxMessage="The url must be at most 2083 characters !"
     * )
     */
    private $url;

    /**
     * @var Trick
     * @access private
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Trick", inversedBy="videos")
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
     * Set url
     * @access public
     * @param string $url
     *
     * @return Video
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     * @access public
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set trick
     * @access public
     * @param Trick $trick
     *
     * @return Video
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
