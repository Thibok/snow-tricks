<?php

/**
 * Mailer
 */

namespace AppBundle\Mailer;

/**
 * Mailer
 */
class Mailer
{
    /**
     * @var \Swift_Mailer
     * @access private
     */
    private $swiftMailer;

    /**
     * @var \Twig_Environment
     * @access private
     */
    private $twig;

    /**
     * @var string
     * @access private
     */
    private $sender;

    /**
     * Constructor
     * @access public
     * @param \Swift_Mailer $swiftMailer
     * @param \Twig_Environment $twig
     * @param string $sender
     * 
     * @return void
     */
    public function __construct(\Swift_Mailer $swiftMailer, \Twig_Environment $twig, $sender)
    {
        $this->swiftMailer = $swiftMailer;
        $this->twig = $twig;
        $this->sender = $sender;
    }

    /**
     * Send email
     * @access public
     * @param \Swift_Message $message
     * 
     * @return void
     */
    public function send(\Swift_Message $message)
    {
        $this->swiftMailer->send($message);
    }

    /**
     * Get Twig Environment
     * @access public
     * 
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }

    /**
     * Get the send of email
     * @access public
     * 
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }
}