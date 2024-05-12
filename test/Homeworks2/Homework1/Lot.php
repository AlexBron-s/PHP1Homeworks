<?php

namespace Homeworks2\Homework1;

class Lot extends Product
{
public $path;

    public function getArray(): array
    {
        $product = parent::getArray();
        $product['path'] = $this->path;
        return $product;
    }


}