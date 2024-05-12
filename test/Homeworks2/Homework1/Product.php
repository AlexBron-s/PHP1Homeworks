<?php

namespace Homeworks2\Homework1;

class Product
{
    public $product_id;
    public $img_id;
    public $title;
    public $price;
    public $description;

    public function getArray(): array
    {
        return array(
            'product_id' => $this->product_id,
            'img_id' => $this->img_id,
            'title' => $this->title,
            'price' => $this->price,
            'description' => $this->description,
        );
    }
}