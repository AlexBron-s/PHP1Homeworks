<?php

namespace Homeworks2\Homework2;
require_once "Product.php";
class DigitalProduct extends Product
{
    public function getCalPrice()
    {
        return parent::getCalPrice() / 2;
    }

}