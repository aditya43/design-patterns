<?php

/*
In the Adapter Design Pattern, a class converts the interface of one class to be what another class expects.

In this example we have a MyBook class that has a getAuthor() and getTitle() methods. The client, expects a getAuthorAndTitle() method. To "adapt" MyBook for testAdapter we have an adapter class, BookAdapter, which takes in an instance of interface BookInterface, and uses the MyBook getAuthor() and getTitle() methods in it's own getAuthorAndTitle() method.

Adapters are helpful if you want to use a class that doesn't have quite the exact methods you need, and you can't change the orignal class. The adapter can take the methods you can access in the original class, and adapt them into the methods you need.
 */

interface BookInterface
{
    public function getAuthor();
    public function getTitle();
}

class MyBook implements BookInterface
{
    private $author;
    private $title;

    public function __construct($author_in, $title_in)
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
}

class BookAdapter
{
    private $book;

    public function __construct(BookInterface $book_in)
    {
        $this->book = $book_in;
    }

    public function getAuthorAndTitle()
    {
        return $this->book->getTitle() . ' by ' . $this->book->getAuthor();
    }
}

// client
writeln('BEGIN TESTING ADAPTER PATTERN');
writeln('');

$book        = new MyBook("Aditya Hajare", "Design Patterns");
$bookAdapter = new BookAdapter($book);
writeln('Author and Title: ' . $bookAdapter->getAuthorAndTitle());
writeln('');

writeln('END TESTING ADAPTER PATTERN');

function writeln($line_in)
{
    echo $line_in . "<br/>";
}
