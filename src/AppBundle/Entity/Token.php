<?php

/**
 * Token Entity
 */

namespace AppBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Token
 *
 * @ORM\Table(name="st_token", indexes={@ORM\Index(name="search_expired", columns={"expiration_date"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TokenRepository")
 */
class Token
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
     * @ORM\Column(name="code", type="string", length=80, unique=true)
     */
    private $code;

    /**
     * @var string
     * @access private
     * @ORM\Column(name="type", type="string", length=20)
     */
    private $type;

    /**
     * @var \DateTime
     * @access private
     * @ORM\Column(name="expiration_date", type="datetime")
     */
    private $expirationDate;

    /**
     * @var User
     * @access private
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", mappedBy="user")
     */
    private $user;

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
     * Set code
     * @access public
     * @param string $code
     *
     * @return Token
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     * @access public
     * 
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set type
     * @access public
     * @param string $type
     *
     * @return Token
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     * @access public
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set expirationDate
     * @access public
     * @param \DateTime $expirationDate
     *
     * @return Token
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * Get expirationDate
     * @access public
     * 
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Set user
     * @access public
     * @param User $user
     *
     * @return Token
     */
    public function setUser(User $user = null)
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
}
