<?php

/**
 *  Decorator Design Pattern | Aditya Hajare.
 */

interface CarService
{
    public function getCost();
    public function getDescription();
}

class BasicInspection implements CarService
{
    public function getCost()
    {
        return 20;
    }

    public function getDescription()
    {
        return "Basic Inspection";
    }
}

class OilChange implements CarService
{
    protected $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    public function getCost()
    {
        return 10 + $this->carService->getCost();
    }

    public function getDescription()
    {
        return $this->carService->getDescription() . ', Oil Change';
    }
}

class WheelsAlignment implements CarService
{
    protected $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    public function getCost()
    {
        return 15 + $this->carService->getCost();
    }

    public function getDescription()
    {
        return $this->carService->getDescription() . ', Wheels Alignment';
    }
}

class Washing implements CarService
{
    protected $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    public function getCost()
    {
        return 25 + $this->carService->getCost();
    }

    public function getDescription()
    {
        return $this->carService->getDescription() . ', Washing';
    }
}

$service = new Washing(new WheelsAlignment(new OilChange(new BasicInspection())));
echo $service->getCost(), ' | ', $service->getDescription();

// 20 | Basic Inspection
// 10 | Basic inspection, Oil Change
// 15 | Basic inspection, Oil Change, Wheels Alignment

// Total : 45
