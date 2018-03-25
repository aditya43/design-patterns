<?php
/*
In the Composite pattern an individual object or a group of that object will have similar behaviors.
 */

abstract class ListItem
{
    protected $description   = "";
    protected $datedue       = null;
    protected $datecreated   = null;
    protected $datecompleted = null;

    public function __construct($description, $datedue = null)
    {
        $this->setDescription($description);
        $this->setDateDue($datedue);
        $this->setDateCreated(time());
    }

    public function getComposite()
    {
        return null;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDateDue($datedue)
    {
        $this->datedue = $datedue;
    }

    public function getDateDue()
    {
        return $this->datedue;
    }

    public function setDateCompleted($datecompleted)
    {
        $this->datecompleted = $datecompleted;
    }

    public function getDateCompleted()
    {
        return $this->datecompleted;
    }

    public function setDateCreated($datecreated)
    {
        $this->datecreated = $datecreated;
    }

    public function getDateCreated()
    {
        return $this->datecreated;
    }
}

abstract class CompositeListItem extends ListItem
{
    protected $listitems = [];

    public function getComposite()
    {
        return $this;
    }

    public function getListItems()
    {
        return $this->listitems;
    }

    public function removeListItem(ListItem $listitem)
    {
        $listitems = [];

        foreach ($this->listitems as $thisitem)
        {
            if ($listitem !== $thisitem)
            {
                $listitems[] = $thisitem;
            }
        }
        $this->listitems = $listitems;
    }

    public function addListItem(ListItem $listitem)
    {
        if (in_array($listitem, $this->listitems, true))
        {
            return;
        }
        $this->listitems[] = $listitem;
    }
}

class ToDoList extends CompositeListItem
{
}
class GroceryList extends CompositeListItem
{
}
class LibraryList extends CompositeListItem
{
}
class GroceryItem extends ListItem
{
}
class LibraryItem extends ListItem
{
}
class PostOfficeItem extends ListItem
{
}

// Create our post office item
$poItem = new PostOfficeItem("Post letter at post office.");

// Create our Library List and Library Items
$libList  = new LibraryList("Go to the Library");
$libItem1 = new LibraryItem("Return Craig Sefton's book.");
$libItem2 = new LibraryItem("Get another PHP book.");
$libList->addListItem($libItem1);
$libList->addListItem($libItem2);

// Create our Grocery List and Grocery Items
$groceryList  = new GroceryList("Grocery Shopping List");
$groceryItem1 = new GroceryItem("Milk");
$groceryItem2 = new GroceryItem("Eggs");
$groceryItem3 = new GroceryItem("Bread");
$groceryList->addListItem($groceryItem1);
$groceryList->addListItem($groceryItem2);
$groceryList->addListItem($groceryItem3);

// Create our ToDo List, and add our other lists and items to it
$todoList = new ToDoList("My ToDo List");
$todoList->addListItem($poItem);
$todoList->addListItem($groceryList);
$todoList->addListItem($libList);

$adiList = $todoList->getListItems();
echo "<pre>";
adiPrint($adiList);
function adiPrint($adiList)
{
    foreach ($adiList as $todo)
    {
        echo "<li>" . $todo->getDescription() . " <span style='color:blue;'>-----> <b style='color:red;'>Class:</b> " . get_class($todo) . "</span></li>";

        if ($todo->getComposite())
        {
            adiPrint($todo->getListItems());
        }
    }
}
