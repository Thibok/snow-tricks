<?php

/**
 * User Entity
 */

namespace AppBundle\Entity;

use AppBundle\Entity\Token;
use AppBundle\Entity\UserImage;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\NoSql;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * User
 *
 * @ORM\Table(name="st_user", indexes={@ORM\Index(name="search_inactive", columns={"is_active", "registration_date"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="This email address is already in use !")
 * @UniqueEntity(fields="username", message="This username is already in use !")
 */
class User implements AdvancedUserInterface, \Serializable
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
     * @ORM\Column(name="username", type="string", length=30, unique=true)
     * @Assert\NotBlank(message = "You must enter an username !")
     * @Assert\Length(
     *      min = 4,
     *      max = 30,
     *      minMessage = "The username must be at least 4 characters",
     *      maxMessage = "The username must be at most 30 characters"
     * )
     * @Assert\Regex(
     *      pattern = "/^[a-zA-Z0-9_-]{4,}$/",
     *      message = "The username can contains letters, numbers, and dash (- _)"
     * )
     */
    private $username;

    /**
     * @var string
     * @access private
     * @ORM\Column(name="password", type="string", length=64)
     * @Assert\NotBlank(message = "You must enter an password !")
     * @Assert\Length(
     *      min = 8,
     *      max = 48,
     *      minMessage = "The password must be at least 8 characters",
     *      maxMessage = "The password must be at most 48 characters"
     * )
     * @Assert\Regex(
     *      pattern = "/^(?=.*[0-9])(?=.*[a-zA-Z]).{8,}$/",
     *      message = "The password must contain at least one letter and one number"
     * )
     */
    private $password;

    /**
     * @var string
     * @access private
     * @ORM\Column(name="email", type="string", length=70, unique=true)
     * @Assert\NotBlank(message = "You must enter an email !")
     * @Assert\Length(
     *      min = 7,
     *      max = 70,
     *      minMessage = "The email must be at least 7 characters",
     *      maxMessage = "The email must be at most 70 characters"
     * )
     * @Assert\Email(message = "Please enter a valid email address !")
     */
    private $email;

    /**
     * @var string
     * @access private
     * @ORM\Column(name="name", type="string", length=40)
     * @Assert\NotBlank(message = "You must enter an name !")
     * @Assert\Length(
     *      min = 2,
     *      max = 40,
     *      minMessage = "The name must be at least 2 characters",
     *      maxMessage = "The name must be at least 40 characters"
     * )
     * @Assert\Regex(
     *      pattern = "/^[a-zA-Z]+-?[a-zA-Z]{1,}/",
     *      message = "The name can only contain letters and a dash"
     * )
     */
    private $name;

    /**
     * @var string
     * @access private
     * @ORM\Column(name="first_name", type="string", length=40)
     * @Assert\NotBlank(message = "You must enter an first name !")
     * @Assert\Length(
     *      min = 2,
     *      max = 40,
     *      minMessage = "The first name must be at least 2 characters",
     *      maxMessage = "The first name must be at most 40 characters"
     * )
     * @Assert\Regex(
     *      pattern = "/^[a-zA-Z]+-?[a-zA-Z]{1,}/",
     *      message = "The first name can only contain letters and a dash"
     * )
     */
    private $firstName;

    /**
     * @var bool
     * @access private
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var array
     * @access private
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;

    /**
     * @var UserImage
     * @access private
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\UserImage", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $image;

    /**
     * @var Token
     * @access private
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Token", inversedBy="user", cascade={"persist"})
     */
    private $token;

    /**
     * @var \DateTime
     * @access private
     * @ORM\Column(name="registration_date", type="datetime")
     */
    private $registrationDate;

    /**
     * Undocumented function
     */
    public function __construct()
    {
        $this->isActive = false;
        $this->registrationDate = new \DateTime;      
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
     * Set username
     * @access public
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     * @access public
     * 
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     * @access public
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     * @access public
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     * @access public
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     * @access public
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set name
     * @access public
     * @param string $name
     *
     * @return User
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
     * Set firstName
     * @access public
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     * @access public
     * 
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set isActive
     * @access public
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function IsEnabled()
    {
        return $this->isActive;
    }

    /**
     * Set roles
     * @access public
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     * @access public
     * 
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set image
     * @access public
     * @param UserImage $image
     * 
     * @return User
     */
    public function setImage(UserImage $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     * @access public
     * 
     * @return UserImage
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set token
     * @access public
     * @param Token $token
     *
     * @return User
     */
    public function setToken(Token $token = null)
    {
        $this->token = $token;

        if ($token != null) {
            $token->setUser($this);
        }

        return $this;
    }

    /**
     * Get token
     * @access public
     * 
     * @return Token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * {@inheritDoc}
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
        ) = unserialize($serialized);
    }

    /**
     * {@inheritDoc}
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function eraseCredentials()
    {

    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set registrationDate
     * @access public
     * @param \DateTime $registrationDate
     *
     * @return User
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate
     * @access public
     *
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }
}
