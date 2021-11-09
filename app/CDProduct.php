<?php

namespace CDProduct;

use ShopProduct;
use Writer\ShopProductWriter;


class CDProduct extends ShopProduct

{
    private $playLength = 0;

    function __construct($title, $firstName, $mainName, $price, $playLength)
    {
        parent::__construct($title, $firstName, $mainName, $price);
        $this->playLength = $playLength;
    }

    public function getPlayLength()
    {
        return $this->playLength;
    }

    public function getSummaryLine()
    {
        $base = parent::getSummaryLine();
        $base .= ", Play length: $this->playLength";
        return $base;
    }
}
