<?php

namespace Homeworks2\Homework2;

abstract class Product
{
    public $price;

    /**
     * @param $price
     */
    public function __construct($price)
    {
        $this->price = $price;
    }

    public function getCalPrice() {
        return $this->price;
    }
}