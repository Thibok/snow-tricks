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
     * @Assert\Url(
     *      protocols={"http", "https"},
     *      message="Please enter a valid url !"
     * )
     * @Assert\Regex(
     *      pattern="/(embed)+/",
     *      message="You must enter an embed url in this style : https://www.example.domain/embed/wqeJ5Vkb6JE "
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
