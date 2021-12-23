<?php

class Product
{
    public $name;
    public $price;

    function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }
}

class ProcessSale
{
    private $callBacks;

    function registerCallback($callBack)
    {
        if (!is_callable($callBack)) {
            throw new Exception("Function is not callable!");
        }

        $this->callBacks[] = $callBack;
    }

    function sale($product)
    {
        print "{$product->name}: producing... \n";

        foreach ($this->callBacks as $callBack) {
            call_user_func($callBack, $product);
        }
    }
}

class Mailer
{
    function doMail($product)
    {
        print "Sending {$product->name}";
    }
}

class Totalizer
{
    static function warnAmount($amt)
    {
        $count = 0;
        return function ($product) use ($amt, &$count) {
            $count += $product->price;
            print " sum: $count\n";

            if ($count > $amt) {
                print "Sold product for sum: $count\n";
            }
        };
    }
}

$logger = fn ($product) => print " Write down... ({$product->name})\n";
$processor = new ProcessSale();
$processor->registerCallback($logger);
$processor->registerCallback(Totalizer::warnAmount(8));
// $processor->registerCallback([new Mailer, "doMail"]);
$processor->sale(new Product('shoes', 6));
print "<br>";
$processor->sale(new Product('sugar', 6));
print "<br>";
$processor->sale(new Product('cofe', 10));
