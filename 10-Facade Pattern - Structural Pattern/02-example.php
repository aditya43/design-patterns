<?php

/*
 * What is the facade pattern :
The purpose of a facade in development and the real world, is to mask something ugly with something attractive. Taking this information, the facade pattern, is a means of converting the ugly interface of one or more classes into a pretty interface, that you will love to work with (hopefully). This is frequently described as creating a unified interface to a sub system or multiple sub systems.

 * When to use the facade pattern
The facades patterns ideal use case is when you have legacy code to work with, or when you are working with a 3rd party code. As is usually the case, the code is usually impossible to re-factor as there are no tests. Instead you should create a facade (wrapper) around the original classes to simplify their usage.

 * How to use the facade pattern
- Create a wrapper class, this is the facade.
- Pass the original ugly class instances to the facade.
- Use the facade to abstract away the entire sub system and produce a new beautiful API.
 */

/**
 * Ok so this looks pretty terrible, right? Everything is public and crappy method names!
 */
interface SendMailInterface
{
    public function setSendToEmailAddress($emailAddress);
    public function setSubjectName($subject);
    public function setTheEmailContents($body);
    public function setTheHeaders($headers);
    public function getTheHeaders();
    public function getTheHeadersText();
    public function sendTheEmailNow();
}

/**
 * Implementing that crappy interface
 */
class SendMail implements SendMailInterface
{
    public $to;
    public $subject;
    public $body;
    public $headers = [];

    public function setSendToEmailAddress($emailAddress)
    {
        $this->to = $emailAddress;
    }

    public function setSubjectName($subject)
    {
        $this->subject = $subject;
    }

    public function setTheEmailContents($body)
    {
        $this->body = $body;
    }

    public function setTheHeaders($headers)
    {
        $this->headers = $headers;
    }

    public function getTheHeaders()
    {
        return $this->headers;
    }

    public function getTheHeadersText()
    {
        $headers = "";
        foreach ($this->getTheHeaders() as $header)
        {
            $headers .= $header . "\r\n";
        }
    }

    public function sendTheEmailNow()
    {
        mail($this->to, $this->subject, $this->body, $this->getTheHeadersText());
    }
}

/**
 * A facade wrapper around the crappy SendMail, to improve method names.
 */
class SendMailFacade
{
    private $sendMail;

    public function __construct(SendMailInterface $sendMail)
    {
        $this->sendMail = $sendMail;
    }

    public function setTo($to)
    {
        $this->sendMail->setSendToEmailAddress($to);
        return $this;
    }

    public function setSubject($subject)
    {
        $this->sendMail->setSubjectName($subject);
        return $this;
    }

    public function setBody($body)
    {
        $this->sendMail->setTheEmailContents($body);
        return $this;
    }

    public function setHeaders($headers)
    {
        $this->sendMail->setTheHeaders($headers);
        return $this;
    }

    public function send()
    {
        $this->sendMail->sendTheEmailNow();
    }
}

$to      = "bob@marley.com";
$subject = "Bob Marley and the Wailers";
$body    = "Bob Marley and the Wailers were a Jamaican reggae band created by Bob Marley, Peter Tosh and Bunny Wailer.";
$headers = [
    "From: Steve@Irwin.com"
];

// Using the minging SendMail class
$sendMail = new SendMail();
$sendMail->setSendToEmailAddress($to);
$sendMail->setSubjectName($subject);
$sendMail->setTheEmailContents($body);
$sendMail->setTheHeaders($headers);
$sendMail->sendTheEmailNow();

// Using the sexy SendMailFacade class
$sendMail       = new SendMail();
$sendMailFacade = new sendMailFacade($sendMail);
$sendMailFacade->setTo($to)->setSubject($subject)->setBody($body)->setHeaders($headers)->send();
