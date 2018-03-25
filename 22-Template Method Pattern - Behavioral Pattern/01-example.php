<?php
/*
In the Template Pattern an abstract class will define a method with an algorithm, and methods which the algorithm will use. The methods the algorithm uses can be either required or optional. The optional method should by default do nothing.

The Template Pattern is unusual in that the Parent class has a lot of control.

 * Define the skeleton of an algorithm in an operation, deferring some steps to client subclasses. Template Method lets subclasses redefine certain steps of an algorithm without changing the algorithm's structure.

 * Base class declares algorithm 'placeholders', and derived classes implement the placeholders.

In this example, the TemplateAbstract class has the showBookTitleInfo() method, which will call the methods getTitle() and getAuthor(). The method getTitle() must be overridden, while the method getAuthor() is not required.
 */

abstract class TemplateAbstract
{
    //the template method
    //  sets up a general algorithm for the whole class
    final public function showBookTitleInfo($book_in)
    {
        $title           = $book_in->getTitle();
        $author          = $book_in->getAuthor();
        $processedTitle  = $this->processTitle($title);
        $processedAuthor = $this->processAuthor($author);
        if (null == $processedAuthor)
        {
            $processed_info = $processedTitle;
        }
        else
        {
            $processed_info = $processedTitle . ' by ' . $processedAuthor;
        }
        return $processed_info;
    }

    //the primitive operation
    //  this function must be overridden
    abstract public function processTitle($title);
    //the hook operation
    //  this function may be overridden,
    //  but does nothing if it is not
    public function processAuthor($author)
    {
        return null;
    }
}

class TemplateExclaim extends TemplateAbstract
{
    public function processTitle($title)
    {
        return Str_replace(' ', '!!!', $title);
    }

    public function processAuthor($author)
    {
        return Str_replace(' ', '!!!', $author);
    }
}

class TemplateStars extends TemplateAbstract
{
    public function processTitle($title)
    {
        return Str_replace(' ', '*', $title);
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
        return $this->author;}

    public function getTitle()
    {
        return $this->title;}

    public function getAuthorAndTitle()
    {
        return $this->getTitle() . ' by ' . $this->getAuthor();
    }
}

writeln('BEGIN TESTING TEMPLATE PATTERN');
writeln('');

$book = new Book('PHP for Cats', 'Larry Truett');

$exclaimTemplate = new TemplateExclaim();
$starsTemplate   = new TemplateStars();

writeln('test 1 - show exclaim template');
writeln($exclaimTemplate->showBookTitleInfo($book));
writeln('');

writeln('test 2 - show stars template');
writeln($starsTemplate->showBookTitleInfo($book));
writeln('');

writeln('END TESTING TEMPLATE PATTERN');

function writeln($line_in)
{
    echo $line_in . "<br/>";
}
