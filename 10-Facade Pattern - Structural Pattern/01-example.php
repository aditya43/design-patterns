<?php
/*
In the facade pattern a class hides a complex subsystem from a calling class. In turn, the complex subsystem will know nothing of the calling class.

 * Provide a unified interface to a set of interfaces in a subsystem. Facade defines a higher-level interface that makes the subsystem easier to use.

 * Wrap a complicated subsystem with a simpler interface.

In this example, the "CaseReverseFacade" class will call a subsystem to reverse the case of a string passed from the "Book" class. The subsystem is controlled by the "reverseCase" function in the  "CaseReverseFacade", which in turn calls functions in the "ArrayCaseReverse" and "ArrayStringFunctions" classes. As written, the "CaseReverseFacade" can reverse the case of any string, but it could easily be changed to only reverse a single element of a single class.

In my example I make all elements of the Facade and the subsystem static. This could also easily be changed.
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

class CaseReverseFacade
{
    public static function reverseStringCase($stringIn)
    {
        $arrayFromString    = ArrayStringFunctions::stringToArray($stringIn);
        $reversedCaseArray  = ArrayCaseReverse::reverseCase($arrayFromString);
        $reversedCaseString = ArrayStringFunctions::arrayToString($reversedCaseArray);

        return $reversedCaseString;
    }
}

class ArrayCaseReverse
{
    private static $uppercase_array =
        ['A', 'B', 'C', 'D', 'E', 'F',
        'G', 'H', 'I', 'J', 'K', 'L',
        'M', 'N', 'O', 'P', 'Q', 'R',
        'S', 'T', 'U', 'V', 'W', 'X',
        'Y', 'Z'];
    private static $lowercase_array =
        ['a', 'b', 'c', 'd', 'e', 'f',
        'g', 'h', 'i', 'j', 'k', 'l',
        'm', 'n', 'o', 'p', 'q', 'r',
        's', 't', 'u', 'v', 'w', 'x',
        'y', 'z'];

    public static function reverseCase($arrayIn)
    {
        $array_out = [];
        for ($x = 0; $x < count($arrayIn); $x++)
        {
            if (in_array($arrayIn[$x], self::$uppercase_array))
            {
                $key           = array_search($arrayIn[$x], self::$uppercase_array);
                $array_out[$x] = self::$lowercase_array[$key];
            }
            else if (in_array($arrayIn[$x], self::$lowercase_array))
            {
                $key           = array_search($arrayIn[$x], self::$lowercase_array);
                $array_out[$x] = self::$uppercase_array[$key];
            }
            else
            {
                $array_out[$x] = $arrayIn[$x];
            }
        }
        return $array_out;
    }
}

class ArrayStringFunctions
{
    public static function arrayToString($arrayIn)
    {
        $string_out = null;
        foreach ($arrayIn as $oneChar)
        {
            $string_out .= $oneChar;
        }
        return $string_out;
    }

    public static function stringToArray($stringIn)
    {
        return str_split($stringIn);
    }
}

writeln('BEGIN TESTING FACADE PATTERN');
writeln('');

$book = new Book('Design Patterns', 'Gamma, Helm, Johnson, and Vlissides');

writeln('Original book title: ' . $book->getTitle());
writeln('');

$bookTitleReversed = CaseReverseFacade::reverseStringCase($book->getTitle());

writeln('Reversed book title: ' . $bookTitleReversed);
writeln('');

writeln('END TESTING FACADE PATTERN');

function writeln($line_in)
{
    echo $line_in . "<br>";
}
