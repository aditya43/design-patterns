<?php
/*
In the Abstract Factory Pattern, an abstract factory defines what objects the non-abstract or concrete factory will need to be able to create.

The concrete factory must create the correct objects for it's context, insuring that all objects created by the concrete factory have been chosen to be able to work correctly for a given circumstance.

In this example we have an abstract factory, "BookFactory", that specifies two classes, "PHPBook" and "MySQLBook", which will need to be created by the concrete factory.

The concrete class "OReillyBookfactory" extends "BookFactory", and can create the "OReillyMySQLBook" and "OReillyPHPBook" classes, which are the correct classes for the context of "OReilly".
 */

/*
 * BookFactory classes
 */
interface BookFactory
{
    public function makePHPBook();
    public function makeMySQLBook();
}

class OReillyBookFactory implements BookFactory
{
    private $context = "OReilly";
    public function makePHPBook()
    {
        return new OReillyPHPBook();
    }
    public function makeMySQLBook()
    {
        return new OReillyMySQLBook();
    }
}

class SamsBookFactory implements BookFactory
{
    private $context = "Sams";
    public function makePHPBook()
    {
        return new SamsPHPBook();
    }

    public function makeMySQLBook()
    {
        return new SamsMySQLBook();
    }
}

/*
 *   Book classes
 */
interface Book
{
    public function getAuthor();
    public function getTitle();
}

abstract class MySQLBook implements Book
{
    private $subject = "MySQL";
}

abstract class PHPBook implements Book
{
    private $subject = "PHP";
}

class OReillyMySQLBook extends MySQLBook
{
    private $author;
    private $title;
    public function __construct()
    {
        $this->author = 'George Reese, Randy Jay Yarger, and Tim King';
        $this->title  = 'Managing and Using MySQL';
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

class SamsMySQLBook extends MySQLBook
{
    private $author;
    private $title;
    public function __construct()
    {
        $this->author = 'Paul Dubois';
        $this->title  = 'MySQL, 3rd Edition';
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

class OReillyPHPBook extends PHPBook
{
    private $author;
    private $title;
    private static $oddOrEven = 'odd';
    public function __construct()
    {
        //alternate between 2 books
        if ('odd' == self::$oddOrEven)
        {
            $this->author    = 'Rasmus Lerdorf and Kevin Tatroe';
            $this->title     = 'Programming PHP';
            self::$oddOrEven = 'even';
        }
        else
        {
            $this->author    = 'David Sklar and Adam Trachtenberg';
            $this->title     = 'PHP Cookbook';
            self::$oddOrEven = 'odd';
        }
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

class SamsPHPBook extends PHPBook
{
    private $author;
    private $title;
    public function __construct()
    {
        //alternate randomly between 2 books
        mt_srand((double) microtime() * 10000000);
        $rand_num = mt_rand(0, 1);

        if (1 > $rand_num)
        {
            $this->author = 'George Schlossnagle';
            $this->title  = 'Advanced PHP Programming';
        }
        else
        {
            $this->author = 'Christian Wenz';
            $this->title  = 'PHP Phrasebook';
        }
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

/*
 *   Initialization
 */

$adi = new AdiTest(); // Look below.

$adi->writeln('BEGIN TESTING ABSTRACT FACTORY PATTERN');
$adi->writeln('');

$adi->writeln('testing OReillyBookFactory');
$bookFactoryInstance = new OReillyBookFactory();
$adi->testConcreteFactory($bookFactoryInstance);
$adi->writeln('');

$adi->writeln('testing SamsBookFactory');
$bookFactoryInstance = new SamsBookFactory();
$adi->testConcreteFactory($bookFactoryInstance);

$adi->writeln("END TESTING ABSTRACT FACTORY PATTERN");
$adi->writeln('');

class AdiTest
{
    public function testConcreteFactory($bookFactoryInstance)
    {
        $phpBookOne = $bookFactoryInstance->makePHPBook();
        $this->writeln('first php Author: ' . $phpBookOne->getAuthor());
        $this->writeln('first php Title: ' . $phpBookOne->getTitle());

        $phpBookTwo = $bookFactoryInstance->makePHPBook();
        $this->writeln('second php Author: ' . $phpBookTwo->getAuthor());
        $this->writeln('second php Title: ' . $phpBookTwo->getTitle());

        $mySqlBook = $bookFactoryInstance->makeMySQLBook();
        $this->writeln('MySQL Author: ' . $mySqlBook->getAuthor());
        $this->writeln('MySQL Title: ' . $mySqlBook->getTitle());
    }

    public function writeln($line_in)
    {
        echo $line_in . "<br/>";
    }
}
