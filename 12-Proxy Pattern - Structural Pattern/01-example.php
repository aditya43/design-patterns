<?php
/*
In the proxy pattern one class stands in for and handles all access to another class.

This can be because the real subject is in a different location (server, platform, etc), the real subject is cpu or memory intensive to create and is only created if necessary, or to control access to the real subject. A proxy can also be used to add additional access functionality, such as recording the number of times the real subject is actually called.

 * Provide a surrogate or placeholder for another object to control access to it.

 * Use an extra level of indirection to support distributed, controlled, or intelligent access.

 * Add a wrapper and delegation to protect the real component from undue complexity.

In this example, the "ProxyBookList" is created in place of the more resource intensive "BookList".  "ProxyBookList" will only instantiate "BookList" the first time a method in "BookList" is called.
 */

class ProxyBookList
{
    private $bookList = null;

    public function __construct()
    {
        //bookList is not instantiated at construct time
    }

    public function getBookCount()
    {
        if (null == $this->bookList)
        {
            $this->makeBookList();
        }
        return $this->bookList->getBookCount();
    }

    public function addBook($book)
    {
        if (null == $this->bookList)
        {
            $this->makeBookList();
        }
        return $this->bookList->addBook($book);
    }

    public function getBook($bookNum)
    {
        if (null == $this->bookList)
        {
            $this->makeBookList();
        }
        return $this->bookList->getBook($bookNum);
    }

    public function removeBook($book)
    {
        if (null == $this->bookList)
        {
            $this->makeBookList();
        }
        return $this->bookList->removeBook($book);
    }

    //Create
    public function makeBookList()
    {
        $this->bookList = new BookList();
    }
}

class BookList
{
    private $books     = [];
    private $bookCount = 0;

    public function __construct()
    {
        // Code..
    }

    public function getBookCount()
    {
        return $this->bookCount;
    }

    private function setBookCount($newCount)
    {
        $this->bookCount = $newCount;
    }

    public function getBook($bookNumberToGet)
    {
        if ((is_numeric($bookNumberToGet)) && ($bookNumberToGet <= $this->getBookCount()))
        {
            return $this->books[$bookNumberToGet];
        }
        else
        {
            return null;
        }
    }

    public function addBook(Book $book_in)
    {
        $this->setBookCount($this->getBookCount() + 1);
        $this->books[$this->getBookCount()] = $book_in;
        return $this->getBookCount();
    }

    public function removeBook(Book $book_in)
    {
        $counter = 0;
        while (++$counter <= $this->getBookCount())
        {
            if ($book_in->getAuthorAndTitle() == $this->books[$counter]->getAuthorAndTitle())
            {
                for ($x = $counter; $x < $this->getBookCount(); $x++)
                {
                    $this->books[$x] = $this->books[$x + 1];
                }
                $this->setBookCount($this->getBookCount() - 1);
            }
        }
        return $this->getBookCount();
    }
}

class Book
{
    private $author;
    private $title;

    public function __construct($title_in, $author_in)
    {
        $this->author = $author_in;
        $this->title  = $title_in;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getAuthorAndTitle()
    {
        return $this->getTitle() . ' by ' . $this->getAuthor();
    }
}

writeln('BEGIN TESTING PROXY PATTERN');
writeln('');

$proxyBookList = new ProxyBookList();
$inBook        = new Book('PHP for Cats', 'Larry Truett');
$proxyBookList->addBook($inBook);

writeln('test 1 - show the book count after a book is added');
writeln($proxyBookList->getBookCount());
writeln('');

writeln('test 2 - show the book');
$outBook = $proxyBookList->getBook(1);
writeln($outBook->getAuthorAndTitle());
writeln('');

$proxyBookList->removeBook($outBook);

writeln('test 3 - show the book count after a book is removed');
writeln($proxyBookList->getBookCount());
writeln('');

writeln('END TESTING PROXY PATTERN');

function writeln($line_in)
{
    echo $line_in . "<br/>";
}
