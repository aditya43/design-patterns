<?php

namespace Adi\Classes;

use Adi\Classes\Sub;

class VeggieSub extends Sub
{
    protected function addTopping()
    {
        var_dump('Adding VEGGIES..');
        return $this;
    }
}
