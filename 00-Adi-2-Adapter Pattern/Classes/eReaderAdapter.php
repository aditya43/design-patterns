<?php

namespace Adi\Classes;

class eReaderAdapter implements BookInterface
{
    private $reader;

    public function __construct(eReaderInterface $reader)
    {
        $this->reader = $reader;
    }

    public function open()
    {
        $this->reader->turnOn();
    }

    public function turnPage()
    {
        $this->reader->pressNextButton();
    }
}
