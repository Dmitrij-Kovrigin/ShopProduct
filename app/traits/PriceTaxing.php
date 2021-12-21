<?php

namespace PriceTaxing;

trait PriceTaxing
{
    function calculateTax($price)
    {
        return (($this->getTaxRate() / 100) * $price);
    }
}
