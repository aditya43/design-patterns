<?php

namespace Adi\Classes;

class Book implements BookInterface
{
    public function open()
    {
        var_dump('Opening the paper book.');
    }

    public function turnPage()
    {
        var_dump('Turning a page of the paper book');
    }
}
