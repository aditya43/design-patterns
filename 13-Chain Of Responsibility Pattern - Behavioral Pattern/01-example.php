<?php
/*
A method called in one object will move up a chain of objects until one is found that can properly handle the call.

 * Avoid coupling the sender of a request to its receiver by giving more than one object a chance to handle the request. Chain the receiving objects and pass the request along the chain until an object handles it.

 * Launch-and-leave requests with a single processing pipeline that contains many possible handlers.

 * An object-oriented linked list with recursive traversal.4
 */

interface BookTopicInterface
{
    public function getTopic();
    public function getTitle();
    public function setTitle($title_in);
}

class BookTopic implements BookTopicInterface
{
    private $topic;
    private $title;

    public function __construct($topic_in)
    {
        $this->topic = $topic_in;
        $this->title = null;
    }

    public function getTopic()
    {
        return $this->topic;
    }

    //this is the end of the chain - returns title or says there is none
    public function getTitle()
    {
        if (null != $this->title)
        {
            return $this->title;
        }
        else
        {
            return 'there is no title available';
        }
    }

    public function setTitle($title_in)
    {
        $this->title = $title_in;
    }
}

class BookSubTopic implements BookTopicInterface
{
    private $topic;
    private $parentTopic;
    private $title;

    public function __construct($topic_in, BookTopic $parentTopic_in)
    {
        $this->topic       = $topic_in;
        $this->parentTopic = $parentTopic_in;
        $this->title       = null;
    }

    public function getTopic()
    {
        return $this->topic;
    }

    public function getParentTopic()
    {
        return $this->parentTopic;
    }

    public function getTitle()
    {
        if (null != $this->title)
        {
            return $this->title;
        }
        else
        {
            return $this->parentTopic->getTitle();
        }
    }

    public function setTitle($title_in)
    {
        $this->title = $title_in;}
}

class BookSubSubTopic implements BookTopicInterface
{
    private $topic;
    private $parentTopic;
    private $title;

    public function __construct($topic_in, BookSubTopic $parentTopic_in)
    {
        $this->topic       = $topic_in;
        $this->parentTopic = $parentTopic_in;
        $this->title       = null;
    }

    public function getTopic()
    {
        return $this->topic;
    }

    public function getParentTopic()
    {
        return $this->parentTopic;
    }

    public function getTitle()
    {
        if (null != $this->title)
        {
            return $this->title;
        }
        else
        {
            return $this->parentTopic->getTitle();
        }
    }

    public function setTitle($title_in)
    {
        $this->title = $title_in;}
}

writeln("BEGIN TESTING CHAIN OF RESPONSIBILITY PATTERN");
writeln("");

$bookTopic = new BookTopic("PHP 5");
writeln("bookTopic before title is set:");
writeln("topic: " . $bookTopic->getTopic());
writeln("title: " . $bookTopic->getTitle());
writeln("");

$bookTopic->setTitle("PHP 5 Recipes by Babin, Good, Kroman, and Stephens");
writeln("bookTopic after title is set: ");
writeln("topic: " . $bookTopic->getTopic());
writeln("title: " . $bookTopic->getTitle());
writeln("");

$bookSubTopic = new BookSubTopic("PHP 5 Patterns", $bookTopic);
writeln("bookSubTopic before title is set: ");
writeln("topic: " . $bookSubTopic->getTopic());
writeln("title: " . $bookSubTopic->getTitle());
writeln("");

$bookSubTopic->setTitle("PHP 5 Objects Patterns and Practice by Zandstra");
writeln("bookSubTopic after title is set: ");
writeln("topic: " . $bookSubTopic->getTopic());
writeln("title: " . $bookSubTopic->getTitle());
writeln("");

$bookSubSubTopic = new BookSubSubTopic("PHP 5 Patterns for Cats",
    $bookSubTopic);
writeln("bookSubSubTopic with no title set: ");
writeln("topic: " . $bookSubSubTopic->getTopic());
writeln("title: " . $bookSubSubTopic->getTitle());
writeln("");

$bookSubTopic->setTitle(null);
writeln("bookSubSubTopic with no title set for bookSubTopic either:");
writeln("topic: " . $bookSubSubTopic->getTopic());
writeln("title: " . $bookSubSubTopic->getTitle());
writeln("");

writeln("END TESTING CHAIN OF RESPONSIBILITY PATTERN");

function writeln($line_in)
{
    echo $line_in . "<br/>";
}
