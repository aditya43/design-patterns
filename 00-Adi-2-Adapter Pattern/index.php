<?php

/**
 *  Adapter Design Pattern | Aditya Hajare
 */

require 'vendor/autoload.php';

use Adi\Classes\Book;
use Adi\Classes\eReaderAdapter;
use Adi\Classes\Kindle;
use Adi\Classes\Nook;
use Adi\Classes\Person;

(new Person())->read(new Book());
echo "<br>";

(new Person())->read(new eReaderAdapter(new Kindle()));
echo "<br>";

(new Person())->read(new eReaderAdapter(new Nook()));
