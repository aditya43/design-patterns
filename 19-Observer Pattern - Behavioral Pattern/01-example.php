<?php
/*
In the Observer pattern a subject object will notify an observer object if the subject's state changes.

 * Define a one-to-many dependency between objects so that when one object changes state, all its dependents are notified and updated automatically.

 * Encapsulate the core (or common or engine) components in a Subject abstraction, and the variable (or optional or user interface) components in an Observer hierarchy.

 * The "View" part of Model-View-Controller.

In this example, the Subject is the subject, and the Observer is the observer. For the observer to be notified of changes in the subject it must first be registered with the subject using the "attach" method. For the observer to no longer be notified of changes in the subject it must be unregistered with the "detach" method.

When the subject changes it calls the observer's "update" method with itself. The observer can then take the subject and use whatever methods have been made available for it to determine the subjects current state.

The Observer Pattern is often called Publish-Subscribe, where the subject would be the publisher, and the observer would be the subscriber.
 */

interface ObserverInterface
{
    public function update(SubjectInterface $subject_in);
}

interface SubjectInterface
{
    public function attach(ObserverInterface $observer_in);
    public function detach(ObserverInterface $observer_in);
    public function notify();
}

class Observer implements ObserverInterface
{
    public function __construct()
    {
        // Code..
    }

    public function update(SubjectInterface $subject)
    {
        writeln('<span style="color:red;">IN OBSERVER - NEW FAVOURITES ALERT</span>');
        writeln(' new favorites: ' . $subject->getFavorites());
        writeln('<span style="color:red;">IN OBSERVER - FAVOURITES ALERT OVER</span><br /><br /><br />');
    }
}

class Subject implements SubjectInterface
{
    private $favoritePatterns = null;
    private $observers        = [];

    public function __construct()
    {
        // Code..
    }

    public function attach(ObserverInterface $observer_in)
    {
        //could also use array_push($this->observers, $observer_in);
        $this->observers[] = $observer_in;
    }

    public function detach(ObserverInterface $observer_in)
    {
        //$key = array_search($observer_in, $this->observers);
        foreach ($this->observers as $key => $val)
        {
            if ($val == $observer_in)
            {
                unset($this->observers[$key]);
            }
        }
    }

    public function notify()
    {
        foreach ($this->observers as $observer)
        {
            $observer->update($this);
        }
    }

    public function updateFavorites($newFavorites)
    {
        $this->favorites = $newFavorites;
        $this->notify();
    }

    public function getFavorites()
    {
        return $this->favorites;
    }
}

echo '<pre>';
writeln('BEGIN TESTING OBSERVER PATTERN');
writeln('');

$subject  = new Subject();
$observer = new Observer();
$subject->attach($observer);
$subject->updateFavorites('Aditya Hajare');
$subject->updateFavorites('James Hetfield');
$subject->detach($observer);
$subject->updateFavorites('Kurt Cobain');

writeln('END TESTING OBSERVER PATTERN');

function writeln($line_in)
{
    echo $line_in . "<br/>";
}
