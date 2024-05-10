<?php

namespace Homeworks;

use DB\Query;

class Homework8 {
    public static function addOrder($user_id, $basket)
    {
        require_once 'DB\Query.php';
        return (new Query())->table('order')->insert(['user_id' => $user_id, 'basket' => json_encode($basket)])->execute();
    }

    public static function delOrder($order_id)
    {
        require_once 'DB\Query.php';
        return (new Query())->table('order')->where(['id' => $order_id])->delAll();
    }

    public static function changeStatusOrder($order_id, $status)
    {
        require_once 'DB\Query.php';
        return (new Query())
            ->table('order')
            ->update(['status' => $status])
            ->where(['id' => $order_id])
            ->execute();
    }

    public static function getOrder($order_id)
    {
        require_once 'DB\Query.php';
        return (new Query())->table('order')->where(['id' => $order_id])->execute()[0] ?? null;
    }

    public static function getOrders($user_id = null)
    {
        require_once 'DB\Query.php';
        $orders = (new Query())
            ->select([
                'order.id',
                'login',
                'status'
            ])
            ->table('order')
            ->innerJoin('user', 'user.id = order.user_id');
        if ($user_id) {
            $orders->where(['user_id' => $user_id]);
        }
        return $orders->execute();
    }

    public function orders($post)
    {
        require_once 'Homeworks\Homework7.php';
        $h7 = new Homework7;
        $h7->startSession();
        $user = $_SESSION['user'] ?? null;
        $operation = $post['operation'] ?? null;
        $show_order = $post['show_order'] ?? null;
        $order_id = $post['order_id'] ?? null;

        if ($user == null) {
            $h7->paragraph2([]);
            return;
        } elseif ($user['role'] == 'admin') {
            $submit = '<input type="submit" name="operation" value="Одобрить">
                        <input type="submit" name="operation" value="Отказать">
                        <input type="submit" name="operation" value="Удалить">';
            $th = 'Показать\Одобрить\Отказать\Удалить';

            if ($operation && $order_id) {
                if ($operation == 'Удалить') {
                    self::delOrder($order_id);
                } elseif ($operation == 'Одобрить') {
                    self::changeStatusOrder($order_id, 'Одобрен');
                } else {
                    self::changeStatusOrder($order_id, 'Отказано');
                }
            }
        } else {
            $submit = '<input type=\"submit\" name=\"operation\" value=\"Отказаться\">';
            $th = 'Показать\Отказаться';
            if ($operation == 'Отказаться' && $order_id) {
                self::changeStatusOrder($order_id, 'Отказался');
            }
        }

        if ($show_order == 'Показать' && $order_id) {
            $order = self::getOrder($order_id);
            $basket = json_decode($order->basket);
            $sum_all_price = 0;

            echo "<html>
        <head>
            <meta charset=\"utf-8\">
            <title>Заказ</title>
        </head>
        <body>
            <table border=\"1\">
            <caption>Заказ</caption>
        <tr>
            <th>Изображение</th>
            <th>Название</th>
            <th>Цена за\ед</th>
            <th>Количество</th>
            <th>Цена</th>
        </tr>";
            foreach ($basket as $value) {
                $product = $value->product;
                $count = $value->count;
                $sum_price = $value->sum_price;
                $sum_all_price += $sum_price;
                echo "<tr><td><img src=\"$product->path\" width=\"240\"></td><td>$product->title</td><td>$product->price</td><td>$count</td><td>$sum_price</td></tr>";
            }

            echo "<tr><td></td><td></td><td></td><th>Итого</th><td>$sum_all_price</td></tr>
            </table>
            <p>
            <form action=\"/action.php\" method=\"post\">
                        <input type=\"hidden\" name=\"class_name\" value=\"Homeworks\Homework8\">
                        <input type=\"hidden\" name=\"func_name\" value=\"orders\">
                        <input type=\"hidden\" name=\"show_order\" value=\"Показать\">
                        <input type=\"hidden\" name=\"order_id\" value=\"$order_id\">
                        $submit
            </form>
            <form action=\"/action.php\" method=\"post\">
                        <input type=\"hidden\" name=\"class_name\" value=\"Homeworks\Homework8\">
                        <input type=\"hidden\" name=\"func_name\" value=\"orders\">
                        <input type=\"submit\" value=\"Вернуться\">
            </form>
            </p></body></html>";

        } else {

            $orders = self::getOrders();
            echo "<html>
        <head>
            <meta charset=\"utf-8\">
            <title>Заказы</title>
        </head>
        <body>
            <table border=\"1\">
            <caption>Заказы</caption>
        <tr>
            <th>Номер</th>
            <th>Заказчик</th>
            <th>Статус</th>
            <th>$th</th>
        </tr>";
            foreach ($orders as $value) {
                echo "<tr><td>$value->id</td><td>$value->login</td><td>$value->status</td><td>
                    <form action=\"/action.php\" method=\"post\">
                        <input type=\"hidden\" name=\"class_name\" value=\"Homeworks\Homework8\">
                        <input type=\"hidden\" name=\"func_name\" value=\"orders\">
                        <input type=\"hidden\" name=\"order_id\" value=\"$value->id\">
                        <input type=\"submit\" name=\"show_order\" value=\"Показать\">
                        $submit
                    </form>
                </td></tr></table>";
            }
            echo "</p></body></html>";
        }
    }
    public function productEdit($post)
    {
        require_once 'Homeworks\Homework7.php';
        require_once 'DB\Query.php';
        $h7 = new Homework7;
        $h7->startSession();
        $user = $_SESSION['user'] ?? null;
        $operation = $post['operation'] ?? null;
        $product_title = $post['product_title'] ?? null;
        $product_cost = $post['product_cost'] ?? null;
        $product_description = $post['product_cost'] ?? null;
        $product_id = $post['product_id'] ?? null;

        if ($user == null || $user['role'] != 'admin') {
            $h7->paragraph2([]);
            return;
        }

        if ($operation == 'Удалить' && $product_id) {
            $product = (new Query())
                ->select(['img_id', 'path'])
                ->table('product')
                ->innerJoin('img', 'img.id = product.img_id')
                ->where(['product.id' => $product_id])
                ->execute();
            if ($product) {
                (new Query())->table('product')->where(['id' => $product_id])->delAll();
                (new Query())->table('img')->where(['id' => $product[0]->img_id])->delAll();
                unlink($product[0]->path);
            }
        }

        if ($operation == 'Добавить' && $product_title && $product_cost) {
            $dir = 'img/'.time().'_';
            $product_path = $dir . basename($_FILES['product_file']['name']);
            if (!move_uploaded_file($_FILES['product_file']['tmp_name'], $product_path)) {
                echo "Не выбрано Изображение";
            } else {
                require_once 'Homeworks\Homework5.php';
                $img_id = (new Query())
                    ->table('img')
                    ->insert([
                        'path' => $product_path,
                        'title' => $product_title
                    ])
                    ->execute();
                (new Query())
                    ->table('product')
                    ->insert([
                        'img_id' => $img_id,
                        'price' => $product_cost,
                        'title' => $product_title,
                        'description' => $product_description,
                    ])
                    ->execute();
            }
        }

        $products = (new Query())
            ->select(['product_id' => 'product.id', 'path', 'product.title', 'product.price', 'description'])
            ->table('product')
            ->innerJoin('img', 'img.id = product.img_id')
            ->execute();

        echo "<html>
        <head>
            <meta charset=\"utf-8\">
            <title>Управление товарами</title>
        </head>
        <body>
            <table border=\"1\">
            <caption>Управление товарами</caption>
        <tr>
            <th>Изображение</th>
            <th>Название</th>
            <th>Описание</th>
            <th>Цена</th>
            <th>Удалить</th>
        </tr>";
        foreach ($products as $product) {
            echo "<tr><td><img src=\"$product->path\" width=\"240\"></td><td>$product->title</td><td>$product->description</td><td>$product->price</td><td>
                    <form action=\"/action.php\" method=\"post\">
                        <input type=\"hidden\" name=\"class_name\" value=\"Homeworks\Homework8\">
                        <input type=\"hidden\" name=\"func_name\" value=\"productEdit\">
                        <input type=\"hidden\" name=\"product_id\" value=\"$product->product_id\">
                        <input type=\"submit\" name=\"operation\" value=\"Удалить\">
                    </form>
                </td></tr>";
        }
        echo "<form enctype=\"multipart/form-data\" action=\"/action.php\" method=\"post\">
            <input type=\"hidden\" name=\"class_name\" value=\"Homeworks\Homework8\">
            <input type=\"hidden\" name=\"func_name\" value=\"productEdit\">
            <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"30000\" />
            <p>Изображение: <input type=\"file\" name=\"product_file\" accept=\"image/*\"></p>
            <p>Название: <input type=\"text\" name=\"product_title\"></p>
            <p>Описание: <input type=\"text\" name=\"product_description\"></p>
            <p>Цена: <input type=\"text\" name=\"product_cost\"></p>
            <p><input type=\"submit\" name=\"operation\" value=\"Добавить\"></p>
        </form></body></html>";
    }

}