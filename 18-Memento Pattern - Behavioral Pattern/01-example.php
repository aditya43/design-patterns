<?php
/*
In the Memento pattern a memento object will hold the state of another object.

Why Memento Pattern :
- Need to restore an object back to its previous state (e.g. "undo" or "rollback" operations).

 * Without violating encapsulation, capture and externalize an object's internal state so that the object can be returned to this state later.

 * A magic cookie that encapsulates a "check point" capability.

 * Promote undo or rollback to full object status.

In this example, the BookMark class is the "Memento", and holds the state of the BookReader class. The BookReader class would be the "Originator" in this example, as it had the original state. Client holds the BookMark object, and so is the "Caretaker".

The memento should be set up so that the caretaker can create, set, and get memento values for an originator. However, the caretaker itself can not access any of the values stored in the memento.

In my example I do this by having memento only allow calls to it's get and set functions in which it is passed a BookReader object. The BookMark can then get or set the titles or pages for a bookreader object it is passed. The downside of my implementation is that I have BookReader's get and set functions as public.
 */

class BookReader
{
    private $title;
    private $page;

    public function __construct($title_in, $page_in)
    {
        $this->setTitle($title_in);
        $this->setPage($page_in);
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setPage($page_in)
    {
        $this->page = $page_in;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title_in)
    {
        $this->title = $title_in;
    }
}

class BookMark
{
    private $title;
    private $page;

    public function __construct(BookReader $bookReader)
    {
        $this->setPage($bookReader);
        $this->setTitle($bookReader);
    }

    public function getPage(BookReader $bookReader)
    {
        $bookReader->setPage($this->page);
    }

    public function setPage(BookReader $bookReader)
    {
        $this->page = $bookReader->getPage();
    }

    public function getTitle(BookReader $bookReader)
    {
        $bookReader->setTitle($this->title);
    }

    public function setTitle(BookReader $bookReader)
    {
        $this->title = $bookReader->getTitle();
    }
}

// Client

writeln('BEGIN TESTING MEMENTO PATTERN');
writeln('');

$bookReader = new BookReader('Core PHP Programming, Third Edition', '103');
$bookMark   = new BookMark($bookReader);

writeln('(at beginning) bookReader title: ' . $bookReader->getTitle());
writeln('(at beginning) bookReader page: ' . $bookReader->getPage());

$bookReader->setPage("104");
$bookMark->setPage($bookReader);
writeln('(one page later) bookReader page: ' . $bookReader->getPage());

$bookReader->setPage('2005'); //oops! a typo
writeln('(after typo) bookReader page: ' . $bookReader->getPage());

$bookMark->getPage($bookReader); // Get a page number from BookMark (Memento) and set it to BookReader.
writeln('(back to one page later) bookReader page: ' . $bookReader->getPage());
writeln('');

writeln('END TESTING MEMENTO PATTERN');

function writeln($line_in)
{
    echo $line_in . "<br/>";
}
