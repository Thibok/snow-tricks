<?php

/**
 * Post forgot pass event of User
 */

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * UserPostForgotEvent
 */
class UserPostForgotEvent extends Event
{
    /**
     * @var UserInterface
     * @access private
     */
    private $user;

    /**
     * Constructor
     * @access public
     * @param UserInterface $user
     *
     * @return void
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * Get User
     * @access public
     *
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
}