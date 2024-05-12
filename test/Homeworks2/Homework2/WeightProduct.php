<?php

namespace Homeworks2\Homework2;
require_once "Product.php";
class WeightProduct extends Product
{
    public $weight;// вес в килограмах

    public function __construct($price, $weight)
    {
        $this->weight = $weight;
        parent::__construct($price);
    }

    public function getCalPrice()
    {
        return parent::getCalPrice() * $this->weight;
    }

}