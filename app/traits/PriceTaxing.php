<?php

namespace PriceTaxing;

trait PriceTaxing
{
    private $taxRate = 15;

    function calculateTax($price)
    {
        return (($this->taxRate / 100) * $price);
    }
}
