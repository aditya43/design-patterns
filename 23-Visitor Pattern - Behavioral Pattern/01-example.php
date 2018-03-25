<?php
/* https://dzone.com/articles/practical-php-patterns/practical-php-patterns-visitor
In the Visitor pattern, one class calls a function in another class with the current instance of itself. The called class has special functions for each class that can call it.

 * Represent an operation to be performed on the elements of an object structure. Visitor lets you define a new operation without changing the classes of the elements on which it operates.

 * The classic technique for recovering lost type information.

 * Do the right thing based on the type of two objects.

 * Double dispatch.

In this example, the BookVisitee can call the visitBook function in any function extending the Visitor class. By doing this new Visitors which format the BookVisitee information can easily be added without changing the BookVisitee at all.
 */

abstract class Visitee
{
    abstract public function accept(Visitor $visitorIn);
}

class BookVisitee extends Visitee
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

    public function accept(Visitor $visitorIn)
    {
        $visitorIn->visitBook($this);
    }
}

class SoftwareVisitee extends Visitee
{
    private $title;
    private $softwareCompany;
    private $softwareCompanyURL;

    public function __construct($title_in, $softwareCompany_in, $softwareCompanyURL_in)
    {
        $this->title              = $title_in;
        $this->softwareCompany    = $softwareCompany_in;
        $this->softwareCompanyURL = $softwareCompanyURL_in;
    }

    public function getSoftwareCompany()
    {
        return $this->softwareCompany;
    }

    public function getSoftwareCompanyURL()
    {
        return $this->softwareCompanyURL;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function accept(Visitor $visitorIn)
    {
        $visitorIn->visitSoftware($this);
    }
}

abstract class Visitor
{
    abstract public function visitBook(BookVisitee $bookVisitee_In);
    abstract public function visitSoftware(SoftwareVisitee $softwareVisitee_In);
}

class PlainDescriptionVisitor extends Visitor
{
    private $description = null;

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($descriptionIn)
    {
        $this->description = $descriptionIn;
    }

    public function visitBook(BookVisitee $bookVisiteeIn)
    {
        $this->setDescription($bookVisiteeIn->getTitle() . '. written by ' . $bookVisiteeIn->getAuthor());
    }

    public function visitSoftware(SoftwareVisitee $softwareVisiteeIn)
    {
        $this->setDescription($softwareVisiteeIn->getTitle() .
            '. made by ' . $softwareVisiteeIn->getSoftwareCompany() .
            '. website at ' . $softwareVisiteeIn->getSoftwareCompanyURL());
    }
}

class FancyDescriptionVisitor extends Visitor
{
    private $description = null;

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($descriptionIn)
    {
        $this->description = $descriptionIn;
    }

    public function visitBook(BookVisitee $bookVisiteeIn)
    {
        $this->setDescription($bookVisiteeIn->getTitle() .
            '...!*@*! written !*! by !@! ' . $bookVisiteeIn->getAuthor());
    }

    public function visitSoftware(SoftwareVisitee $softwareVisiteeIn)
    {
        $this->setDescription($softwareVisiteeIn->getTitle() .
            '...!!! made !*! by !@@! ' . $softwareVisiteeIn->getSoftwareCompany() .
            '...www website !**! at http://' . $softwareVisiteeIn->getSoftwareCompanyURL());
    }
}

writeln('BEGIN TESTING VISITOR PATTERN');
writeln('');

$book     = new BookVisitee('Design Patterns', 'Gamma, Helm, Johnson, and Vlissides');
$software = new SoftwareVisitee('Zend Studio', 'Zend Technologies', 'www.zend.com');

$plainVisitor = new PlainDescriptionVisitor();

acceptVisitor($book, $plainVisitor);
writeln('plain description of book: ' . $plainVisitor->getDescription());
acceptVisitor($software, $plainVisitor);
writeln('plain description of software: ' . $plainVisitor->getDescription());
writeln('');

$fancyVisitor = new FancyDescriptionVisitor();

acceptVisitor($book, $fancyVisitor);
writeln('fancy description of book: ' . $fancyVisitor->getDescription());
acceptVisitor($software, $fancyVisitor);
writeln('fancy description of software: ' . $fancyVisitor->getDescription());

writeln('END TESTING VISITOR PATTERN');

//double dispatch any visitor and visitee objects
function acceptVisitor(Visitee $visitee_in, Visitor $visitor_in)
{
    $visitee_in->accept($visitor_in);
}

function writeln($line_in)
{
    echo $line_in . "<br/>";
}
