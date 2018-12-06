<?php

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class UserPostForgotEvent extends Event
{
    private $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}