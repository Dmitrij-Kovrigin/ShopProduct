<?php

class Account
{
    public $balance;

    function __construct($balance)
    {
        $this->balance = $balance;
    }
}


class PersonClone
{
    private $name;
    private $age;
    private $id;
    public $account;

    function __construct($name, $age, Account $account)
    {
        $this->name = $name;
        $this->age = $age;
        $this->account = $account;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function __clone()
    {
        $this->id = 0;
        $this->account = clone $this->account;
    }

    function __toString()
    {
        $st = $this->name . " ";
        $st .= "Age: " . $this->age . " years <br>";
        return $st;
    }
}

$person = new PersonClone("John", 22, new Account(1000));
print $person;
$person->setId(12);
$person2 = clone $person;
$person->account->balance += 100;
print_r($person->account->balance);
print_r($person2->account->balance);
