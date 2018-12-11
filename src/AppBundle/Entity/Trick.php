<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

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
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=60, unique=true)
     * @Assert\NotBlank(message="You must enter a name for the trick !")
     * @Assert\Length(
     *      min=2,
     *      max=60,
     *      minMessage="The name must be at least 2 characters",
     *      maxMessage="The name must be at most 60 characters",
     * )
     * @Assert\Regex(
     *      pattern="/^[a-zA-Z0-9 ]{2,60}$/",
     *      message="The name can contain letters, numbers and spaces"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Assert\Length(
     *      max=3000,
     *      maxMessage="The description must be at most 3000 characters"
     * )
     * @Assert\Regex(
     *      pattern="/^[<>]$/",
     *      match=false,
     *      message="The description can't contain < or >"
     * )
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="addAt", type="datetime")
     */
    private $addAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updateAt", type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=60, unique=true)
     */
    private $slug;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
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
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
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
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set addAt
     *
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
     *
     * @return \DateTime
     */
    public function getAddAt()
    {
        return $this->addAt;
    }

    /**
     * Set updateAt
     *
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
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set slug
     *
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
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}

