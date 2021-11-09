<?php

use BookProduct\BookProduct;
use CDProduct\CDProduct;
use Writer\ShopProductWriter;

class ShopProduct

{
    private $title = "Standart product";
    private $producerMainName = "Author surname";
    private $producerFirstName = "Author surname";
    private $price = 0;
    private $discount = 1;

    function __construct($title, $firstName, $mainName, $price)
    {
        $this->title = $title;
        $this->producerMainName = $mainName;
        $this->producerFirstName = $firstName;
        $this->price = $price;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getproducerMainName()
    {
        return $this->producerMainName;
    }

    public function getproducerFirstName()
    {
        return $this->producerFirstName;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function setDiscount($num)
    {
        return $this->discount = $num;
    }


    public function getSummaryLine()
    {
        $base = "$this->title, Author: $this->producerFirstName $this->producerMainName";
        return $base;
    }

    public function getProducer()
    {
        return " $this->producerFirstName" . " $this->producerMainName";
    }

    public function getPrice()
    {
        return ($this->price - $this->discount);
    }
}

$product1 = new CDProduct("Cheap thrills", "Sia", "", 15.99, null, 60.23);
$product2 = new BookProduct("Andromeda", "Ivan", "Efremov", 10.25, 520, null);


// print($product1->getPlayLength() . '<br>');
// print($product2->getNumberOfPages());
// print($product2->getSummaryLine());
// print($product2->getPrice());


$w = new ShopProductWriter;
$w->addProduct($product2);
$w->addProduct($product1);

// var_dump($w);
$w->write();
