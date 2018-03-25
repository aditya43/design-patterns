<?php

namespace Adi\Classes;

abstract class Sub
{
    abstract protected function addTopping();

    public function make()
    {
        return $this
            ->layBread()
            ->addTopping()
            ->addSauces();
    }

    protected function layBread()
    {
        var_dump('Laying bread');
        return $this;
    }

    protected function addSauces()
    {
        var_dump('Adding sauces');
        return $this;
    }
}
