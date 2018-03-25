<?php

/**
 *  Chain Of Responsibility Design Pattern | Aditya Hajare
 */

abstract class HomeChecker
{
    protected $successor;

    abstract public function check(HomeStatus $home);

    public function succeedWith(HomeChecker $successor)
    {
        $this->successor = $successor;
    }

    public function next(HomeStatus $home)
    {
        if ($this->successor)
        {
            $this->successor->check($home);
        }
    }
}

class Locks extends HomeChecker
{
    public function check(HomeStatus $home)
    {
        if (!$home->locked)
        {
            throw new Exception('Doors are not locked!');
        }

        $this->next($home);
    }
}

class Alarm extends HomeChecker
{
    public function check(HomeStatus $home)
    {
        if (!$home->alarmOn)
        {
            throw new Exception('Alarm is not set!');
        }

        $this->next($home);
    }
}

class Lights extends HomeChecker
{
    public function check(HomeStatus $home)
    {
        if (!$home->lightsOff)
        {
            throw new Exception('Lights are not turned off!');
        }

        $this->next($home);
    }
}

class HomeStatus
{
    /**
     *  To test, simply make 1 of the following "false".
     */
    public $locked    = true;
    public $lightsOff = false;
    public $alarmOn   = true;
}

$locks  = new Locks();
$lights = new Lights();
$alarm  = new Alarm();

$locks->succeedWith($lights);
$lights->succeedWith($alarm);

$locks->check(new HomeStatus());
