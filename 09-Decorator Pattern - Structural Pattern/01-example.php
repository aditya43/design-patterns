<?php
/*
In the Decorator pattern, a class will add functionality to another class, without changing the other classes' structure.

 * Attach additional responsibilities to an object dynamically. Decorators provide a flexible alternative to subclassing for extending functionality.

 * Client-specified embellishment of a core object by recursively wrapping it.

 * Wrapping a gift, putting it in a box, and wrapping the box.

In this example, the Book class will have it's title shown in different ways by the "BookTitleDecorator" and it's child classes "BookTitleExclaimDecorator" and "BookTitleStarDecorator".

In my example I do this by having "BookTitleDecorator" make a copy of "Book's" title value, which is then changed for display. Depending on the implementation, it might be better to actually change the original object.
 */

class Book
{
    private $author;
    private $title;

    public function __construct($title_in, $author_in)
    {
        $this->title  = $title_in;
        $this->author = $author_in;
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

class BookTitleDecorator
{
    protected $book;
    protected $title;

    public function __construct(Book $book_in)
    {
        $this->book = $book_in;
        $this->resetTitle();
    }

    //doing this so original object is not altered
    public function resetTitle()
    {
        $this->title = $this->book->getTitle();
    }

    public function showTitle()
    {
        return $this->title;
    }
}

class BookTitleExclaimDecorator extends BookTitleDecorator
{
    private $btd;

    public function __construct(BookTitleDecorator $btd_in)
    {
        $this->btd = $btd_in;
    }

    public function exclaimTitle()
    {
        $this->btd->title = "!" . $this->btd->title . "!";
    }
}

class BookTitleStarDecorator extends BookTitleDecorator
{
    private $btd;

    public function __construct(BookTitleDecorator $btd_in)
    {
        $this->btd = $btd_in;
    }

    public function starTitle()
    {
        $this->btd->title = Str_replace(" ", "*", $this->btd->title);
    }
}

writeln('BEGIN TESTING DECORATOR PATTERN');
writeln('');

$patternBook = new Book('Gamma, Helm, Johnson, and Vlissides', 'Design Patterns');

$decorator        = new BookTitleDecorator($patternBook);
$starDecorator    = new BookTitleStarDecorator($decorator);
$exclaimDecorator = new BookTitleExclaimDecorator($decorator);

writeln('showing title : ');
writeln($decorator->showTitle());
writeln('');

writeln('showing title after two exclaims added : ');
$exclaimDecorator->exclaimTitle();
$exclaimDecorator->exclaimTitle();
writeln($decorator->showTitle());
writeln('');

writeln('showing title after star added : ');
$starDecorator->starTitle();
writeln($decorator->showTitle());
writeln('');

writeln('showing title after reset: ');
writeln($decorator->resetTitle());
writeln($decorator->showTitle());
writeln('');

writeln('END TESTING DECORATOR PATTERN');

function writeln($line_in)
{
    echo $line_in . "<br/>";
}
