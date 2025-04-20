<?php

abstract class Animal { // making class abstrac
    protected $name; // change property
    protected $age; // change property

    public function __construct($name, $age) { // adding public
        $this->name = $name;
        $this->$age = $age;
    }

    public function makeSound() {
        echo "Generic animal sound";
    }
}

class Dog extends Animal {
    public function makeSound() {
        echo "Woof!";
    }

    public function fetchStick() {
        echo $this->name . "is fetching a stick!"; // editing the echo
    }
}

$dog = new Dog("Rex", 5);
$dog->makeSound();
$dog->fetchStick();
