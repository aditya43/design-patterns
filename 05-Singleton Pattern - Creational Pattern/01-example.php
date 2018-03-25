<?php
/*
In the singleton pattern a class can distribute only one instance of itself to other classes.
- Ensure a class has only one instance, and provide a global point of access to it.
- Encapsulated "just-in-time initialization" or "initialization on first use".
 */

/*
 *   Singleton classes
 */
class BookSingleton
{
    private $author             = 'Gamma, Helm, Johnson, and Vlissides';
    private $title              = 'Design Patterns';
    private static $book        = null;
    private static $isLoanedOut = false;

    private function __construct()
    {
        // Making constructor private will prevent outside code from directly instantiating this class using "new" keyword.
    }

    public static function borrowBook()
    {
        if (false == self::$isLoanedOut)
        {
            if (null == self::$book)
            {
                self::$book = new self();
            }
            self::$isLoanedOut = true;
            return self::$book;
        }
        else
        {
            return null;
        }
    }

    public function returnBook(BookSingleton $bookReturned)
    {
        self::$isLoanedOut = false;
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

class BookBorrower
{
    private $borrowedBook;
    private $haveBook = false;

    public function __construct()
    {
        // Code..
    }

    public function getAuthorAndTitle()
    {
        if (true == $this->haveBook)
        {
            return $this->borrowedBook->getAuthorAndTitle();
        }
        else
        {
            return "I don't have the book";
        }
    }

    public function borrowBook()
    {
        $this->borrowedBook = BookSingleton::borrowBook();

        if (null == $this->borrowedBook)
        {
            $this->haveBook = false;
        }
        else
        {
            $this->haveBook = true;
        }
    }

    public function returnBook()
    {
        $this->borrowedBook->returnBook($this->borrowedBook);
    }
}

/*
 *   Initialization
 */

writeln('BEGIN TESTING SINGLETON PATTERN');
writeln('');

$bookBorrower1 = new BookBorrower();
$bookBorrower2 = new BookBorrower();

$bookBorrower1->borrowBook();
writeln('BookBorrower1 asked to borrow the book');
writeln('BookBorrower1 Author and Title: ');
writeln($bookBorrower1->getAuthorAndTitle());
writeln('');

$bookBorrower2->borrowBook();
writeln('BookBorrower2 asked to borrow the book');
writeln('BookBorrower2 Author and Title: ');
writeln($bookBorrower2->getAuthorAndTitle());
writeln('');

$bookBorrower1->returnBook();
writeln('BookBorrower1 returned the book');
writeln('');

$bookBorrower2->borrowBook();
writeln('BookBorrower2 Author and Title: ');
writeln($bookBorrower1->getAuthorAndTitle());
writeln('');

writeln('END TESTING SINGLETON PATTERN');

function writeln($line_in)
{
    echo $line_in . '<br/>';
}
