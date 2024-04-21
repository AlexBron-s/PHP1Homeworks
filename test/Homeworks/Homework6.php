<?php

namespace Homeworks;

use DB\Query;

class Homework6
{
    public function paragraph1($post)
    {
        $result = '';
        if (isset($post['x']) && isset($post['y']) && isset($post['operation'])) {
            $x = (int)$post['x'];
            $y = (int)$post['y'];
            switch ($post['operation']) {
                case '+':
                    $result = $x + $y;
                    break;
                case '-':
                    $result = $x - $y;
                    break;
                case '/':
                    if ($x && $y) {
                        $result = $x / $y;
                    } else {
                        $result = 'Делить на 0 нельзя';
                    }
                    break;
                case '*':
                    $result = $x * $y;
                    break;
            }
        }

        echo '<html>
                <head>
                    <title>Калькулятор</title>
                </head>
                <body>
                    <form action="/action.php" method="post">
                        <input type="hidden" name="class_name" value="Homeworks\Homework6">
                        <input type="hidden" name="func_name" value="paragraph1">
                        <input type="text" name="x">
                        <select name="operation">
                            <option value="+">+</option>
                            <option value="-">-</option>
                            <option value="/">/</option>
                            <option value="*">*</option>
                        </select>
                        <input type="text" name="y">
                        <input type="submit" value="Посчитать">
                    </form>
                    <p>= '.$result.'</p>
                </body>
                </html>';
    }

    public function paragraph4($post)
    {
        $url = 'action.php?class_name=Homeworks\Homework6&func_name=getProduct&product_id=';

        require_once 'DB\Query.php';
        $products = (new Query())
            ->select(['product_id' => 'product.id', 'path'])
            ->table('product')
            ->innerJoin('img', 'img.id = product.img_id')
            ->execute();

        foreach ($products as $product) {
            echo '<a href="'.$url.$product->product_id.'"><img src="'.$product->path.'" width="240"></a>';
        }
    }
    public function getProduct($post)
    {
        require_once 'DB\Query.php';
        $products = (new Query())
            ->select([
                'path',
                'product.title',
                'price',
                'description',
            ])
            ->table('product')
            ->innerJoin('img', 'img.id = product.img_id')
            ->where(['product.id' => $post['product_id']])
            ->execute();

        echo '<p><img src="'.$products[0]->path.'"></p>';
        echo '<p>Название: '.$products[0]->title.'</p>';
        echo '<p>Описание: '.$products[0]->description.'</p>';
        echo '<p>Цена: '.$products[0]->price.'</p>';
    }
}