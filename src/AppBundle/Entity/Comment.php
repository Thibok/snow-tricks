<?php

/**
 * Comment Entity
 */

namespace AppBundle\Entity;

use AppBundle\Entity\User;
use AppBundle\Entity\Trick;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comment
 *
 * @ORM\Table(name="st_comment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @var int
     */
    const COMMENT_PER_PAGE = 10;

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
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank(message="You must enter a comment !")
     * @Assert\Length(
     *     min=2,
     *     max=500,
     *     minMessage="Comment must be at least 2 characters",
     *     maxMessage="Comment must be at most 500 characters",
     * )
     * @Assert\Regex(
     *      pattern="/[<>]/",
     *      match=false,
     *      message="Comment can't contain < or >"
     * )
     */
    private $content;

    /**
     * @var \DateTime
     * @access private
     * @ORM\Column(name="add_at", type="datetime")
     */
    private $addAt;

    /**
     * @var User
     * @access private
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    
    /**
     * @var Trick
     * @access private
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Trick")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     */
    private $trick;

    /**
     * Constructor
     * @access public
     * 
     * @return void
     */
    public function __construct()
    {
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
     * Set content
     * @access public
     * @param string $content
     *
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     * @access public
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set addAt
     * @access public
     * @param \DateTime $addAt
     *
     * @return Comment
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
     * Set user
     * @access public
     * @param User $user
     *
     * @return Comment
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
     * Set trick
     * @access public
     * @param Trick $trick
     *
     * @return Comment
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
