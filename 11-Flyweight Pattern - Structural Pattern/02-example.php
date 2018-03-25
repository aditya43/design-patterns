<?php
/*
 * Useful note
Flyweight is extremely uncommon in the PHP ecosystem, the benefits that it provides are much more useful in game development, due to the huge amount of objects required. Regardless, below I’ve going to be covering a game implementation which you’re much more likely to find in a language like Java or C++.

 * What is the flyweight pattern
Flyweights are used for storing common and repetitive data required by models. These values could be stored in each individual model… however by using flyweights, you can save memory, as instead of storing the same data everywhere, you just pass around an instance of a flyweight, which internally points to the same chunk of memory.

Flyweight objects should be shared between models, allowing a much smaller amounts of objects to be created, preventing unnecessary memory usage. Sharing objects is done slightly different to how the prototype pattern clones objects. Instead a multiton should be used which creates flyweight objects and stores references to them internally. Then the second time they are requested, the object in memory is returned.

 * When to use the flyweight pattern
In PHP there generally aren’t scenarios when large numbers of sharable objects are required. As I mentioned above, the flyweight pattern is much more prominent in the game development and so the example I provide below, will focus on a PHP game implementation.
 */

interface WeaponInterface
{
    public function __construct();
    public function getBaseDamage();
    public function getEnhancementsDamage();
    public function getDamage();
    public function reload();
    public function addEnhancement(WeaponFlyweightInterface $enhancement);
}

class PlasmaRifle implements WeaponInterface
{
    const TOTAL_AMMO_IN_PLAMA_SHELL = 10;
    const MIN_DAMAGE                = 50;
    const MAX_DAMAGE                = 75;

    private $ammoRemaining = null;
    private $enhancements  = [];

    public function __construct()
    {
        $this->reload();
    }

    public function getBaseDamage()
    {
        return rand(self::MIN_DAMAGE, self::MAX_DAMAGE);
    }

    public function getEnhancementsDamage()
    {
        $damage = 0;
        foreach ($this->enhancements as $enhancement)
        {
            $damage += $enhancement->getDamage();
        }
        return $damage;
    }

    public function getDamage()
    {
        return $this->getBaseDamage() + $this->getEnhancementsDamage();

    }

    public function reload()
    {
        $this->ammoRemaining = self::TOTAL_AMMO_IN_PLAMA_SHELL;
    }

    public function addEnhancement(WeaponFlyweightInterface $enhancement)
    {
        $this->enhancements[] = $enhancement;
    }

}

interface WeaponFlyweightInterface
{
    public function getDamage();
}

class PlasmaRifleGrenadeLauncherFlyweight implements WeaponFlyweightInterface
{
    const MIN_DAMAGE = 100;
    const MAX_DAMAGE = 120;

    public function getDamage()
    {
        return rand(self::MIN_DAMAGE, self::MAX_DAMAGE);
    }
}

class PlasmaRifleExplosionFlyweight implements WeaponFlyweightInterface
{
    const MIN_DAMAGE = 500;
    const MAX_DAMAGE = 1000;

    public function getDamage()
    {
        return rand(self::MIN_DAMAGE, self::MAX_DAMAGE);
    }
}

class PlasmaRifleFlyweightFactory
{
    private static $instances = [];

    public static function factory($flyweight)
    {
        $className = "PlasmaRifle" . $flyweight . "Flyweight";

        if (empty(self::$instances[$className]))
        {
            self::$instances[$className] = new $className();
        }
        return self::$instances[$className];
    }
}

$plasmaRifle = new PlasmaRifle();

$plasmaRifle->addEnhancement(PlasmaRifleFlyweightFactory::factory("GrenadeLauncher"));
$plasmaRifle->addEnhancement(PlasmaRifleFlyweightFactory::factory("GrenadeLauncher"));
$plasmaRifle->addEnhancement(PlasmaRifleFlyweightFactory::factory("GrenadeLauncher"));
$plasmaRifle->addEnhancement(PlasmaRifleFlyweightFactory::factory("GrenadeLauncher"));
$plasmaRifle->addEnhancement(PlasmaRifleFlyweightFactory::factory("GrenadeLauncher"));

$plasmaRifle->addEnhancement(PlasmaRifleFlyweightFactory::factory("Explosion"));
$plasmaRifle->addEnhancement(PlasmaRifleFlyweightFactory::factory("Explosion"));
$plasmaRifle->addEnhancement(PlasmaRifleFlyweightFactory::factory("Explosion"));
$plasmaRifle->addEnhancement(PlasmaRifleFlyweightFactory::factory("Explosion"));
$plasmaRifle->addEnhancement(PlasmaRifleFlyweightFactory::factory("Explosion"));

// Shot damage can vary wildly due to the random factor in base damage and flyweight enhancements
echo "Shot 1 Damage: " . $plasmaRifle->getDamage(); # Shot 1 Damage: 3944
echo "Shot 2 Damage: " . $plasmaRifle->getDamage(); # Shot 2 Damage: 4637
echo "Shot 3 Damage: " . $plasmaRifle->getDamage(); # Shot 3 Damage: 4345
