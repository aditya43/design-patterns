<?php

namespace Adi\Classes;

use Adi\Classes\Sub;

class TurkeySub extends Sub
{
    protected function addTopping()
    {
        var_dump('Adding TURKEY..');
        return $this;
    }
}
