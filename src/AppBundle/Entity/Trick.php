<?php

/**
 * Trick Entity
 */

namespace AppBundle\Entity;

use AppBundle\Entity\User;
use AppBundle\Entity\Video;
use AppBundle\Entity\Category;
use AppBundle\Entity\TrickImage;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Trick
 *
 * @ORM\Table(name="st_trick")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrickRepository")
 * @UniqueEntity(fields="name", message="A trick already exists with this name !")
 */
class Trick
{
    /**
     * @var int
     */
    const TRICKS_PER_PAGE = 15;

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
     * @ORM\Column(name="name", type="string", length=60, unique=true)
     * @Assert\NotBlank(message="You must enter a name for the trick !")
     * @Assert\Length(
     *      min=2,
     *      max=60,
     *      minMessage="The name must be at least 2 characters",
     *      maxMessage="The name must be at most 60 characters",
     * )
     * @Assert\Regex(
     *      pattern="/^([a-zA-Z0-9]+ ?[a-zA-Z0-9]+)+$/",
     *      message="The name can contain letters, numbers and spaces"
     * )
     */
    private $name;

    /**
     * @var string
     * @access private
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Assert\Length(
     *      max=3000,
     *      maxMessage="The description must be at most 3000 characters"
     * )
     * @Assert\Regex(
     *      pattern="/[<>]/",
     *      match=false,
     *      message="The description can't contain < or >"
     * )
     */
    private $description;

    /**
     * @var \DateTime
     * @access private
     * @ORM\Column(name="addAt", type="datetime")
     */
    private $addAt;

    /**
     * @var \DateTime
     * @access private
     * @ORM\Column(name="updateAt", type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @var string
     * @access private
     * @ORM\Column(name="slug", type="string", length=60, unique=true)
     */
    private $slug;

    /**
     * @var Collection
     * @access private
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\TrickImage", mappedBy="trick", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $images;

    /**
     * @var User
     * @access private
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var Category
     * @access private
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $category;

    /**
     * @var Collection
     * @access private
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Video", mappedBy="trick", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $videos;

    /**
     * Constructor
     * @access public
     * 
     * @return void
     */
    public function __construct()
    {
        $this->images = new ArrayCollection;
        $this->videos = new ArrayCollection;
        $this->addAt = new \DateTime;
    }

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
     * Set name
     * @access public
     * @param string $name
     *
     * @return Trick
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     * @access public
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     * @access public
     * @param string $description
     *
     * @return Trick
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     * @access public
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set addAt
     * @access public
     * @param \DateTime $addAt
     *
     * @return Trick
     */
    public function setAddAt($addAt)
    {
        $this->addAt = $addAt;

        return $this;
    }

    /**
     * Get addAt
     * @access public
     *
     * @return \DateTime
     */
    public function getAddAt()
    {
        return $this->addAt;
    }

    /**
     * Set updateAt
     * @access public
     * @param \DateTime $updateAt
     *
     * @return Trick
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     * @access public
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set slug
     * @access public
     * @param string $slug
     *
     * @return Trick
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     * @access public
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add image
     * @access public
     * @param TrickImage $image
     *
     * @return Trick
     */
    public function addImage(TrickImage $image)
    {
        $this->images[] = $image;

        $image->setTrick($this);

        return $this;
    }

    /**
     * Remove image
     * @access public
     * @param TrickImage $image
     * 
     * @return void
     */
    public function removeImage(TrickImage $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     * @access public
     * 
     * @return Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set user
     * @access public
     * @param User $user
     *
     * @return Trick
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     * @access public
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set category
     * @access public
     * @param Category $category
     *
     * @return Trick
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     * @access public
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add video
     * @access public
     * @param Video $video
     *
     * @return Trick
     */
    public function addVideo(Video $video)
    {
        $this->videos[] = $video;
        $video->setTrick($this);

        return $this;
    }

    /**
     * Remove video
     * @access public
     * @param Video $video
     * 
     * @return void
     */
    public function removeVideo(Video $video)
    {
        $this->videos->removeElement($video);
    }

    /**
     * Get videos
     * @access public
     *
     * @return Collection
     */
    public function getVideos()
    {
        return $this->videos;
    }
}
