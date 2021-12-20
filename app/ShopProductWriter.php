<?php

namespace Writer;

use BookProduct;
use ShopProduct;

class ShopProductWriter
{
    protected $products = [];

    public function addProduct(ShopProduct $shopProduct)
    {
        $this->products[] = $shopProduct;
    }

    public function write()
    {
        $str = '';
        foreach ($this->products as $shopProduct) {
            $str = $shopProduct->getSummaryLine() . "<br>";
            print $str;
        }
    }
}
