<?php

namespace Homeworks2\Homework2;
require_once "DigitalProduct.php";
require_once "PiecemealProduct.php";
require_once "WeightProduct.php";
class Main
{
    public function main() {
        $products[] = new DigitalProduct(100);
        $products[] = new PiecemealProduct(100);
        $products[] = new WeightProduct(100, 2.5);

        $prices = 0;
        foreach ($products as $product) {
            $prices += $product->getCalPrice();
        }
        return ['prices' => $prices];
    }
}