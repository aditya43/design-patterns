<?php

/*
In the Composite pattern an individual object or a group of that object will have similar behaviors.

In this example, the "OneBook" class is the individual object. The "SeveralBooks" class is a group of zero or more "OneBook" objects.

Both the "OneBook" and "SeveralBooks" can return information about the books title and author. "OneBook" can only return this information about one single book, while "SeveralBooks" will return this information one at a time about as many OneBooks as it holds.

While both classes have "addBook" and "removeBook" functions, they are only functional on  "SeveralBooks".
Class "OneBook" will merely return "FALSE" when these functions are called.
 */

interface BookCompositeInterface
{
    public function getBookInfo($previousBook);
    public function getBookCount();
    public function setBookCount($new_count);
    public function addBook($oneBook);
    public function removeBook($oneBook);
}

class OneBook implements BookCompositeInterface
{
    private $title;
    private $author;

    public function __construct($title, $author)
    {
        $this->title  = $title;
        $this->author = $author;
    }

    public function getBookInfo($bookToGet)
    {
        if (1 == $bookToGet)
        {
            return $this->title . " by " . $this->author;
        }
        else
        {
            return false;
        }
    }

    public function getBookCount()
    {
        return 1;
    }

    public function setBookCount($newCount)
    {
        return false;
    }

    public function addBook($oneBook)
    {
        return false;
    }

    public function removeBook($oneBook)
    {
        return false;
    }
}

class SeveralBooks implements BookCompositeInterface
{
    private $oneBooks = [];
    private $bookCount;

    public function __construct()
    {
        $this->setBookCount(0);
    }

    public function getBookCount()
    {
        return $this->bookCount;
    }

    public function setBookCount($newCount)
    {
        $this->bookCount = $newCount;
    }

    public function getBookInfo($bookToGet)
    {
        if ($bookToGet <= $this->bookCount)
        {
            return $this->oneBooks[$bookToGet]->getBookInfo(1);
        }
        else
        {
            return false;
        }
    }

    public function addBook($oneBook)
    {
        $this->setBookCount($this->getBookCount() + 1);
        $this->oneBooks[$this->getBookCount()] = $oneBook;
        return $this->getBookCount();
    }

    public function removeBook($oneBook)
    {
        $counter = 0;
        while (++$counter <= $this->getBookCount())
        {
            if ($oneBook->getBookInfo(1) ==
                $this->oneBooks[$counter]->getBookInfo(1))
            {
                for ($x = $counter; $x < $this->getBookCount(); $x++)
                {
                    $this->oneBooks[$x] = $this->oneBooks[$x + 1];
                }
                $this->setBookCount($this->getBookCount() - 1);
            }
        }
        return $this->getBookCount();
    }
}

writeln("BEGIN TESTING COMPOSITE PATTERN");
writeln('');

$firstBook = new OneBook('Core PHP Programming, Third Edition', 'Atkinson and Suraski');
writeln('(after creating first book) oneBook info: ', true);
writeln($firstBook->getBookInfo(1));
writeln('');

$secondBook = new OneBook('PHP Bible', 'Converse and Park');
writeln('(after creating second book) oneBook info: ', true);
writeln($secondBook->getBookInfo(1));
writeln('');

$thirdBook = new OneBook('Design Patterns', 'Gamma, Helm, Johnson, and Vlissides');
writeln('(after creating third book) oneBook info: ', true);
writeln($thirdBook->getBookInfo(1));
writeln('');

$books = new SeveralBooks();

$booksCount = $books->addBook($firstBook);
writeln('(after adding firstBook to books) SeveralBooks info : ', true);
writeln($books->getBookInfo($booksCount));
writeln('');

$booksCount = $books->addBook($secondBook);
writeln('(after adding secondBook to books) SeveralBooks info : ', true);
writeln($books->getBookInfo($booksCount));
writeln('');

$booksCount = $books->addBook($thirdBook);
writeln('(after adding thirdBook to books) SeveralBooks info : ', true);
writeln($books->getBookInfo($booksCount));
writeln('');

$booksCount = $books->removeBook($firstBook);
writeln('(after removing firstBook from books) SeveralBooks count : ', true);
writeln($books->getBookCount());
writeln('');

writeln('(after removing firstBook from books) SeveralBooks info 1 : ', true);
writeln($books->getBookInfo(1));
writeln('');

writeln('(after removing firstBook from books) SeveralBooks info 2 : ', true);
writeln($books->getBookInfo(2));
writeln('');

writeln('END TESTING COMPOSITE PATTERN');

function writeln($line_in, $red = false)
{
    $line_in = ($red) ? "<pre style='color:red'>{$line_in}</pre>" : $line_in;
    echo $line_in . "<br/>";
}
