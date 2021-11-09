<?php

namespace Bookproduct;

use ShopProduct;
use Writer\ShopProductWriter;

class BookProduct extends ShopProduct
{
    private $numPages = 0;
    function __construct($title, $firstName, $mainName, $price, $numPages)
    {
        parent::__construct($title, $firstName, $mainName, $price);
        $this->numPages = $numPages;
    }

    public function getNumberOfPages()
    {
        return $this->numPages;
    }

    public function getSummaryLine()
    {
        $base = parent::getSummaryLine();
        $base .= ", Number of pages: $this->numPages";
        return $base;
    }
}
