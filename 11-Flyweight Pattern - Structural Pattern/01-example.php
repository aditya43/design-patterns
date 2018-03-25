<?php
/*
In the flyweight pattern instances of a class which are identical are shared in an implementation instead of creating a new instance of that class for every instance.

This is done largely to assist performance, and works best when a large number of the exact same instance of a class would otherwise be created.

 * Use sharing to support large numbers of fine-grained objects efficiently.

 * The Motif GUI strategy of replacing heavy-weight widgets with light-weight gadgets.

In this example, the "FlyweightBook" class stores only author and title, with only three possible author title combinations being used by the system, and yet the system may have a large number of duplicate books.

"FlyweightFactory" is in charge of distributing instances of "FlyweightBook", and only creates a new instance when necessary.
 */

class FlyweightBook
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

class FlyweightFactory
{
    private $books = [];

    public function __construct()
    {
        $this->books[1] = null;
        $this->books[2] = null;
        $this->books[3] = null;
    }

    public function getBook($bookKey)
    {
        if (null == $this->books[$bookKey])
        {
            $makeFunction          = 'makeBook' . $bookKey;
            $this->books[$bookKey] = $this->$makeFunction();
        }
        return $this->books[$bookKey];
    }

    //Sort of an long way to do this, but hopefully easy to follow.
    //How you really want to make flyweights would depend on what
    //your application needs.  This, while a little clumsy looking,
    //does work well.
    public function makeBook1()
    {
        $book = new FlyweightBook('Larry Truett', 'PHP For Cats');
        return $book;
    }

    public function makeBook2()
    {
        $book = new FlyweightBook('Larry Truett', 'PHP For Dogs');
        return $book;
    }

    public function makeBook3()
    {
        $book = new FlyweightBook('Larry Truett', 'PHP For Parakeets');
        return $book;
    }
}

class FlyweightBookShelf
{
    private $books = [];

    public function addBook($book)
    {
        $this->books[] = $book;
    }

    public function showBooks()
    {
        $return_string = null;

        foreach ($this->books as $book)
        {
            $return_string .= 'title: ' . $book->getAuthor() . '  author: ' . $book->getTitle();
        };

        return $return_string;
    }
}

writeln('BEGIN TESTING FLYWEIGHT PATTERN');

$flyweightFactory    = new FlyweightFactory();
$flyweightBookShelf1 = new FlyweightBookShelf();
$flyweightBook1      = $flyweightFactory->getBook(1);
$flyweightBookShelf1->addBook($flyweightBook1);
$flyweightBook2 = $flyweightFactory->getBook(1);
$flyweightBookShelf1->addBook($flyweightBook2);

writeln('test 1 - show the two books are the same book');
if ($flyweightBook1 === $flyweightBook2)
{
    writeln('1 and 2 are the same');
}
else
{
    writeln('1 and 2 are not the same');
}
writeln('');

writeln('test 2 - with one book on one shelf twice');
writeln($flyweightBookShelf1->showBooks());
writeln('');

$flyweightBookShelf2 = new FlyweightBookShelf();
$flyweightBook1      = $flyweightFactory->getBook(2);
$flyweightBookShelf2->addBook($flyweightBook1);
$flyweightBookShelf1->addBook($flyweightBook1);

writeln('test 3 - book shelf one');
writeln($flyweightBookShelf1->showBooks());
writeln('');

writeln('test 4 - book shelf two');
writeln($flyweightBookShelf2->showBooks());
writeln('');

writeln('END TESTING FLYWEIGHT PATTERN');

function writeln($line_in)
{
    echo $line_in . "<br/ >";
}
