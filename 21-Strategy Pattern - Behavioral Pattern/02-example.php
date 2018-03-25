<?php

/*
http://phpenthusiast.com/blog/strategy-pattern-the-power-of-interface
https://www.ibm.com/developerworks/library/os-php-designptrns/

We consider use of the strategy pattern when we need to choose between similar classes that are different only in their implementation.
The strategy pattern is a good solution for those cases in which we need the program to select which code alternative to implement at runtime.
The first stractural feature of the starategy pattern is that we have several classes that implement the same interface.
The second feature of the strategy pattern is a selector code that decides from which class that implements the interface to create the object, and then creates the object accordingly.
The third structural feature of the strategy pattern is a client class that puts the code into practice.
 */

interface StrategyInterface
{
    public function filter($record);
}

class FindAfterStrategy implements StrategyInterface
{
    private $_name;

    public function __construct($name)
    {
        $this->_name = $name;
    }

    public function filter($record)
    {
        return strcmp($this->_name, $record) <= 0;
    }
}

class RandomStrategy implements StrategyInterface
{
    public function filter($record)
    {
        return rand(0, 1) >= 0.5;
    }
}

class UserList
{
    private $_list = [];

    public function __construct($names)
    {
        if (null != $names)
        {
            foreach ($names as $name)
            {
                $this->_list[] = $name;
            }
        }
    }

    public function add($name)
    {
        $this->_list[] = $name;
    }

    public function find(StrategyInterface $filter)
    {
        $recs = [];
        foreach ($this->_list as $user)
        {
            if ($filter->filter($user))
            {
                $recs[] = $user;
            }

        }
        return $recs;
    }
}
echo '<xmp>';
$ul = new UserList(["Andy", "Jack", "Lori", "Megan"]);
$f1 = $ul->find(new FindAfterStrategy("J"));
print_r($f1);

$f2 = $ul->find(new RandomStrategy());
print_r($f2);
