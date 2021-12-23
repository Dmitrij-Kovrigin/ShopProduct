<?php

class Person
{
    private $_name;
    private $_age;
    private $writer;

    function __construct(PersonWriter $writer)
    {
        $this->writer = $writer;
    }

    function __call($methodName, $arguments)
    {
        if (method_exists($this->writer, $methodName)) {
            return $this->writer->$methodName($this);
        }
    }

    function __set($property, $value)
    {
        $method = "set{$property}";
        if (method_exists($this, $method)) {
            return $this->$method($value);
        }
    }

    function __unset($property)
    {
        $method = "set{$property}";
        if (method_exists($this, $method)) {
            return $this->$method(null);
        }
    }

    function setName($name)
    {
        $this->name = $name;
        if (!is_null($name)) {
            $this->_name = strtoupper($this->_name);
        }
    }

    function setAge($age)
    {
        $this->_age = strtoupper($age);
    }

    function __get($property)
    {
        $method = "get{$property}";
        if (method_exists($this, $method)) {
            return $this->$method();
        }
    }

    function getName()
    {
        return "John";
    }

    function getAge()
    {
        return "44";
    }
}


class PersonWriter
{
    function writeName(Person $p)
    {
        print $p->getName() . "\n";
    }

    function writeAge(Person $p)
    {
        print $p->getAge() . "\n";
    }
}

class Address
{
    private $number;
    private $street;

    function __construct($maybeNumber, $maybeStreet = null)
    {
        if (is_null($maybeStreet)) {
            $this->streetAddress = $maybeNumber;
        } else {
            $this->number = $maybeNumber;
            $this->street = $maybeStreet;
        }
    }

    function __set($property, $value)
    {
        if ($property === "streetAddress") {
            if (preg_match("/^(\d+.*?)[\s,]+(.+)$/", $value, $matches)) {
                $this->number = $matches[1];
                $this->street = $matches[2];
            } else {
                throw new Exception("Error in address: '{$value}'");
            }
        }
    }

    function __get($property)
    {
        if ($property === "streetAddress") {
            return $this->number . " " . $this->street;
        }
    }
}

$address = new Address("441b Bakers Street");
print "Address: {$address->streetAddress}\n";

$address = new Address(15, "Vivuslkio gatve");
print "Address: {$address->streetAddress}\n";

$address->streetAddress = "45, Seskines parkas netoliese";
print "Address: {$address->streetAddress}\n";



// $person = new Person(new PersonWriter);
// $person->writeName();

// $p = new Person;
// $p->name = 'Opra';
// print $p->name;
