<?php

namespace AppBundle\Mailer;

class Mailer
{
    private $swiftMailer;
    private $twig;
    private $sender;

    public function __construct(\Swift_Mailer $swiftMailer, \Twig_Environment $twig, $sender)
    {
        $this->swiftMailer = $swiftMailer;
        $this->twig = $twig;
        $this->sender = $sender;
    }

    public function send(\Swift_Message $message)
    {
        $this->swiftMailer->send($message);
    }

    public function getTwig()
    {
        return $this->twig;
    }

    public function getSender()
    {
        return $this->sender;
    }
}