<?php

/*
In the Bridge Design Pattern, functionality abstraction and implementation are in separate class hierarchies.

In this example we have BridgeBook which uses either BridgeBookCapsImp or BridgeBookStarsImp.  BridgeBook will assign one implementation or the other each time BridgeBook is instantiated.

The bridge pattern is helpful when you want to decouple a class from it's implementation.
 */

abstract class BridgeBook
{
    private $bbAuthor;
    private $bbTitle;
    private $bbImp;

    public function __construct($author_in, $title_in, $choice_in)
    {
        $this->bbAuthor = $author_in;
        $this->bbTitle  = $title_in;
        if ('STARS' == $choice_in)
        {
            $this->bbImp = new BridgeBookStarsImp();
        }
        else
        {
            $this->bbImp = new BridgeBookCapsImp();
        }
    }

    public function showAuthor()
    {
        return $this->bbImp->showAuthor($this->bbAuthor);
    }

    public function showTitle()
    {
        return $this->bbImp->showTitle($this->bbTitle);
    }
}

class BridgeBookAuthorTitle extends BridgeBook
{
    public function showAuthorTitle()
    {
        return $this->showAuthor() . "'s " . $this->showTitle();
    }
}

class BridgeBookTitleAuthor extends BridgeBook
{
    public function showTitleAuthor()
    {
        return $this->showTitle() . ' by ' . $this->showAuthor();
    }
}

interface BridgeBookImpInterface
{
    public function showAuthor($author);
    public function showTitle($title);
}

class BridgeBookCapsImp implements BridgeBookImpInterface
{
    public function showAuthor($author_in)
    {
        return strtoupper($author_in);
    }
    public function showTitle($title_in)
    {
        return strtoupper($title_in);
    }
}

class BridgeBookStarsImp implements BridgeBookImpInterface
{
    public function showAuthor($author_in)
    {
        return Str_replace(" ", "*", $author_in);
    }

    public function showTitle($title_in)
    {
        return Str_replace(" ", "*", $title_in);
    }
}

writeln('BEGIN TESTING BRIDGE PATTERN');
writeln('');

writeln('test 1 - author title with caps');
$book = new BridgeBookAuthorTitle('Aditya Hajare', 'PHP for Cats', 'CAPS');
writeln($book->showAuthorTitle());
writeln('');

writeln('test 2 - author title with stars');
$book = new BridgeBookAuthorTitle('Aditya Hajare', 'PHP for Cats', 'STARS');
writeln($book->showAuthorTitle());
writeln('');

writeln('test 3 - title author with caps');
$book = new BridgeBookTitleAuthor('Aditya Hajare', 'PHP for Cats', 'CAPS');
writeln($book->showTitleAuthor());
writeln('');

writeln('test 4 - title author with stars');
$book = new BridgeBookTitleAuthor('Aditya Hajare', 'PHP for Cats', 'STARS');
writeln($book->showTitleAuthor());
writeln('');

writeln('END TESTING BRIDGE PATTERN');

function writeln($line_in)
{
    echo $line_in . "<br/>";
}
