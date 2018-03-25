<?php
/*
An object passes all interaction between a number of other objects through itself.

 * Define an object that encapsulates how a set of objects interact. Mediator promotes loose coupling by keeping objects from referring to each other explicitly, and it lets you vary their interaction independently.

 * Design an intermediary to decouple many peers.

 * Promote the many-to-many relationships between interacting peers to "full object status".

In this example, BookMediator is notified by BookAuthorColleague or BookTitleColleague if they change to all upper case or all lower case. When either changes case, BookMediator calls the other to change it's case to match.
 */

class BookMediator
{
    private $authorObject;
    private $titleObject;

    public function __construct($author_in, $title_in)
    {
        $this->authorObject = new BookAuthorColleague($author_in, $this);
        $this->titleObject  = new BookTitleColleague($title_in, $this);
    }

    public function getAuthor()
    {
        return $this->authorObject;
    }

    public function getTitle()
    {
        return $this->titleObject;
    }

    // when title or author change case, this makes sure the other
    // stays in sync
    public function change(BookColleague $changingClassIn)
    {
        if ($changingClassIn instanceof BookAuthorColleague)
        {
            if ('upper' == $changingClassIn->getState())
            {
                if ('upper' != $this->getTitle()->getState())
                {
                    $this->getTitle()->setTitleUpperCase();
                }
            }
            else if ('lower' == $changingClassIn->getState())
            {
                if ('lower' != $this->getTitle()->getState())
                {
                    $this->getTitle()->setTitleLowerCase();
                }
            }
        }
        else if ($changingClassIn instanceof BookTitleColleague)
        {
            if ('upper' == $changingClassIn->getState())
            {
                if ('upper' != $this->getAuthor()->getState())
                {
                    $this->getAuthor()->setAuthorUpperCase();
                }
            }
            else if ('lower' == $changingClassIn->getState())
            {
                if ('lower' != $this->getAuthor()->getState())
                {
                    $this->getAuthor()->setAuthorLowerCase();
                }
            }
        }
    }
}

abstract class BookColleague
{
    private $mediator;

    public function __construct($mediator_in)
    {
        $this->mediator = $mediator_in;
    }

    public function getMediator()
    {
        return $this->mediator;
    }

    public function changed($changingClassIn)
    {
        $this->getMediator()->titleChanged($changingClassIn);
    }
}

class BookAuthorColleague extends BookColleague
{
    private $author;
    private $state;

    public function __construct($author_in, $mediator_in)
    {
        $this->author = $author_in;
        parent::__construct($mediator_in);
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author_in)
    {
        $this->author = $author_in;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state_in)
    {
        $this->state = $state_in;
    }

    public function setAuthorUpperCase()
    {
        $this->setAuthor(strtoupper($this->getAuthor()));
        $this->setState('upper');
        $this->getMediator()->change($this);
    }

    public function setAuthorLowerCase()
    {
        $this->setAuthor(strtolower($this->getAuthor()));
        $this->setState('lower');
        $this->getMediator()->change($this);
    }
}

class BookTitleColleague extends BookColleague
{
    private $title;
    private $state;

    public function __construct($title_in, $mediator_in)
    {
        $this->title = $title_in;
        parent::__construct($mediator_in);
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title_in)
    {
        $this->title = $title_in;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state_in)
    {
        $this->state = $state_in;
    }

    public function setTitleUpperCase()
    {
        $this->setTitle(strtoupper($this->getTitle()));
        $this->setState('upper');
        $this->getMediator()->change($this);
    }

    public function setTitleLowerCase()
    {
        $this->setTitle(strtolower($this->getTitle()));
        $this->setState('lower');
        $this->getMediator()->change($this);
    }
}

writeln('BEGIN TESTING MEDIATOR PATTERN');
writeln('');

$mediator = new BookMediator('Gamma, Helm, Johnson, and Vlissides', 'Design Patterns');

$author = $mediator->getAuthor();
$title  = $mediator->getTitle();

writeln('Original Author and Title: ');
writeln('author: ' . $author->getAuthor());
writeln('title: ' . $title->getTitle());
writeln('');

$author->setAuthorLowerCase();

writeln('After Author set to Lower Case: ');
writeln('author: ' . $author->getAuthor());
writeln('title: ' . $title->getTitle());
writeln('');

$title->setTitleUpperCase();

writeln('After Title set to Upper Case: ');
writeln('author: ' . $author->getAuthor());
writeln('title: ' . $title->getTitle());
writeln('');

writeln('END TESTING MEDIATOR PATTERN');

function writeln($line_in)
{
    echo $line_in . '<br/>';
}
