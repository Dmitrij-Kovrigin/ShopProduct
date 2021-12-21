<?php

use BookProduct\BookProduct;
use CDProduct\CDProduct;
use IdentityTrait\IdentityTrait;
use PriceTaxing\PriceTaxing;
use Writer\ShopProductWriter;
use Xml\XmlProductWriter;

class ShopProduct

{
    use PriceTaxing, IdentityTrait {
        IdentityTrait::generateId as uniqueId;
    }
    static $pdo;
    private $id = 0;
    private $title = "Standart product";
    private $producerMainName = "Author surname";
    private $producerFirstName = "Author name";
    private $price = 0;
    private $discount = 1;
    private $taxRate = 15;

    function __construct($title, $firstName, $mainName, $price)
    {
        $this->title = $title;
        $this->producerMainName = $mainName;
        $this->producerFirstName = $firstName;
        $this->price = $price;
    }

    public static function connect_db()
    {
        $host = '127.0.0.1';
        $db   = 'shop_products';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        self::$pdo = new PDO($dsn, $user, $pass, $options);
    }

    public static function getInstance($id)
    {
        self::connect_db();
        $stmt = self::$pdo->prepare("select * from products where id=?");
        $result = $stmt->execute([$id]);

        $row = $stmt->fetch();

        if (empty($row)) {
            return null;
        }

        if ($row['type'] === 'book') {
            $product = new BookProduct(
                $row['title'],
                $row['firstname'],
                $row['mainname'],
                $row['price'],
                $row['numpages']
            );
        } elseif ($row['type'] === 'cd') {
            $product = new CDProduct(
                $row['title'],
                $row['firstname'],
                $row['mainname'],
                $row['price'],
                $row['playlength'],
            );
        } else {
            $product = new ShopProduct(
                $row['title'],
                $row['firstname'],
                $row['mainname'],
                $row['price'],
            );
        }
        $product->setId($row['id']);
        $product->setDiscount($row['discount']);
        return $product;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getTaxRate()
    {
        return $this->taxRate;
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

    public function getFinalPrice()
    {
        return $this->price + $this->calculateTax($this->price);
    }

    public function setDiscount($num)
    {
        $this->discount = $num;
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


// $obj = ShopProduct::getInstance(1);
// print($obj->getTitle());
// print($obj->getDiscount());
// $w = new XmlProductWriter;
// $w->addProduct($obj);
// $w->write();
// print($obj->getFinalPrice());


// print($obj->uniqueId());

// $product1 = new CDProduct("Cheap thrills", "Sia", "", 15.99, null, 60.23);
// $product2 = new BookProduct("Andromeda", "Ivan", "Efremov", 10.25, 520, null);


// print($product1->getPlayLength() . '<br>');
// print($product2->getNumberOfPages());
// print($product2->getSummaryLine());
// print($product2->getPrice());


// $w = new ShopProductWriter;
// $w->addProduct($product2);
// $w->addProduct($product1);

// // var_dump($w);
// $w->write();
