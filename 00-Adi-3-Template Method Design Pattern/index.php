<?php

/**
 *  Template Method Design Pattern | Aditya Hajare
 */

use Adi\Classes\TurkeySub;
use Adi\Classes\VeggieSub;

require 'vendor/autoload.php';

(new TurkeySub())->make();
(new VeggieSub())->make();
