<?php
/*
In the Builder Pattern a director and a builder work together to build an object. The director controls the building and specifies what parts and variations will go into an object. The builder knows how to assemble the object from given specifications.

In this example we have a director, "HTMLPageDirector", which is given a builder,  "HTMLPageBuilder". The director tells the builder what the "pageTitle" will be, what the  "pageHeading" will be, and gives multiple lines of text for the page. The director then has the builder do a final assembly of the parts, and return the page.
 */

interface PageBuilder
{
    public function getPage();
}

interface PageDirector
{
    public function __construct(PageBuilder $builder_in);
    public function buildPage();
    public function getPage();
}

// Concrete class
class HTMLPage
{
    private $page         = null;
    private $page_title   = null;
    private $page_heading = null;
    private $page_text    = null;

    public function showPage()
    {
        return $this->page;
    }

    public function setTitle($title_in)
    {
        $this->page_title = $title_in;
    }

    public function setHeading($heading_in)
    {
        $this->page_heading = $heading_in;
    }

    public function setText($text_in)
    {
        $this->page_text .= $text_in;
    }

    public function formatPage()
    {
        $this->page = '<html>';
        $this->page .= '<head><title>' . $this->page_title . '</title></head>';
        $this->page .= '<body>';
        $this->page .= '<h1>' . $this->page_heading . '</h1>';
        $this->page .= $this->page_text;
        $this->page .= '</body>';
        $this->page .= '</html>';
    }
}

class HTMLPageBuilder implements PageBuilder
{
    private $page = null;

    public function __construct()
    {
        $this->page = new HTMLPage();
    }

    public function setTitle($title_in)
    {
        $this->page->setTitle($title_in);
    }

    public function setHeading($heading_in)
    {
        $this->page->setHeading($heading_in);
    }

    public function setText($text_in)
    {
        $this->page->setText($text_in);
    }

    public function formatPage()
    {
        $this->page->formatPage();
    }

    public function getPage()
    {
        return $this->page;
    }
}

class HTMLPageDirector implements PageDirector
{
    private $builder = null;

    public function __construct(PageBuilder $builder_in)
    {
        $this->builder = $builder_in;
    }

    public function buildPage()
    {
        $this->builder->setTitle('Testing the HTMLPage');
        $this->builder->setHeading('Testing the HTMLPage');
        $this->builder->setText('Testing, testing, testing!');
        $this->builder->setText('Testing, testing, testing, or!');
        $this->builder->setText('Testing, testing, testing, more!');
        $this->builder->formatPage();
    }

    public function getPage()
    {
        return $this->builder->getPage();
    }
}

writeln('BEGIN TESTING BUILDER PATTERN');
writeln('');

$pageBuilder  = new HTMLPageBuilder();
$pageDirector = new HTMLPageDirector($pageBuilder);
$pageDirector->buildPage();
$page = $pageDirector->GetPage();
writeln($page->showPage());
writeln('');

writeln('END TESTING BUILDER PATTERN');

function writeln($line_in)
{
    echo $line_in . "<br/>";
}
