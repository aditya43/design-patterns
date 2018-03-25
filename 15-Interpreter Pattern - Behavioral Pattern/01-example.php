<?php
/*
In the interpreter pattern you define a language, parse requests in that language, and assign the appropriate class(es), method(s), etc to handle each request.

 * Given a language, define a representation for its grammar along with an interpreter that uses the representation to interpret sentences in the language.

 * Map a domain to a language, the language to a grammar, and the grammar to a hierarchical object-oriented design.

In this example, the Interpreter class can handle strings in the following formats: "book author #", "book title #", or "book author title #". The # must be a numeric which must correlate to a book in the list of books we have.
 */

class Interpreter
{
    private $bookList;

    public function __construct($bookListIn)
    {
        $this->bookList = $bookListIn;
    }

    public function interpret($stringIn)
    {
        $arrayIn      = explode(" ", $stringIn);
        $returnString = null;
        // go through the array validating
        // and if possible calling a book method
        // could use refactoring, some duplicate logic
        if ('book' == $arrayIn[0])
        {
            if ('author' == $arrayIn[1])
            {
                if (is_numeric($arrayIn[2]))
                {
                    $book = $this->bookList->getBook($arrayIn[2]);
                    if (null == $book)
                    {
                        $returnString = 'Can not process, there is no book # ' . $arrayIn[2];
                    }
                    else
                    {
                        $returnString = $book->getAuthor();
                    }
                }
                else if ('title' == $arrayIn[2])
                {
                    if (is_numeric($arrayIn[3]))
                    {
                        $book = $this->bookList->getBook($arrayIn[3]);
                        if (null == $book)
                        {
                            $returnString = 'Can not process, there is no book # ' .
                                $arrayIn[3];
                        }
                        else
                        {
                            $returnString = $book->getAuthorAndTitle();
                        }
                    }
                    else
                    {
                        $returnString = 'Can not process, book # must be numeric.';
                    }
                }
                else
                {
                    $returnString = 'Can not process, book # must be numeric.';
                }
            }
            if ('title' == $arrayIn[1])
            {
                if (is_numeric($arrayIn[2]))
                {
                    $book = $this->bookList->getBook($arrayIn[2]);
                    if (null == $book)
                    {
                        $returnString = 'Can not process, there is no book # ' .
                            $arrayIn[2];
                    }
                    else
                    {
                        $returnString = $book->getTitle();
                    }
                }
                else
                {
                    $returnString = 'Can not process, book # must be numeric.';
                }
            }
        }
        else
        {
            $returnString = 'Can not process, can only process book author #,  book title #, or book author title #';
        }
        return $returnString;
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
        if ((is_numeric($bookNumberToGet)) &&
            ($bookNumberToGet <= $this->getBookCount()))
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
            if ($book_in->getAuthorAndTitle() ==
                $this->books[$counter]->getAuthorAndTitle())
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

writeln('BEGIN TESTING INTERPRETER PATTERN');
writeln('');

//load BookList for test data
$bookList = new BookList();
$inBook1  = new Book('PHP for Cats', 'Larry Truett');
$inBook2  = new Book('MySQL for Cats', 'Larry Truett');
$bookList->addBook($inBook1);
$bookList->addBook($inBook2);

$interpreter = new Interpreter($bookList);

writeln('test 1 - invalid request missing "book"');
writeln($interpreter->interpret('author 1'));
writeln('');

writeln('test 2 - valid book author request');
writeln($interpreter->interpret('book author 1'));
writeln('');

writeln('test 3 - valid book title request');
writeln($interpreter->interpret('book title 2'));
writeln('');

writeln('test 4 - valid book author title request');
writeln($interpreter->interpret('book author title 1'));
writeln('');

writeln('test 5 - invalid request with invalid book number');
writeln($interpreter->interpret('book title 3'));
writeln('');

writeln('test 6 - invalid request with nuo numeric book number');
writeln($interpreter->interpret('book title one'));
writeln('');

writeln('END TESTING INTERPRETER PATTERN');

function writeln($line_in)
{
    echo $line_in . "<br/>";
}
