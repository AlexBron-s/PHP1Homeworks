<?php

namespace Homeworks;

use DB\Query;

class Homework7 {
    public function paragraph1($post)
    {
        $operation = $post['operation'] ?? null;

        if (isset($post['product_id']) && $operation) {
        if ($operation == '+') {
            $this->addBasket($post['product_id']);
        } else {
            $this->putBasket($post['product_id']);
        }
    }

        $this->startSession();
        $basket = $_SESSION['basket'] ?? [];
        $user = $_SESSION['user'] ?? null;
        $sum_all_price = 0;
        $mes_order = '';

        if ($operation == 'Заказать') {
            if ($basket) {
                require_once 'Homeworks\Homework8.php';
                Homework8::addOrder($user['id'], $basket);
                $mes_order = 'Заказ принят';
                $_SESSION['basket'] = [];
            } else {
                $mes_order = 'Корзина пуста';
            }
        }

        echo "<html>
        <head>
            <meta charset=\"utf-8\">
            <title>Корзина</title>
        </head>
        <body>
            <table border=\"1\">
            <caption>Корзина</caption>
        <tr>
            <th>Изображение</th>
            <th>Название</th>
            <th>Цена за\ед</th>
            <th>Количество</th>
            <th>Цена</th>
            <th>Добавить\Удалить</th>
        </tr>";
        foreach ($basket as $value) {
            $product = $value['product'];
            $count = $value['count'];
            $sum_price = $value['sum_price'];
            $sum_all_price += $sum_price;
            echo "<tr><td><img src=\"$product->path\" width=\"240\"></td><td>$product->title</td><td>$product->price</td><td>$count</td><td>$sum_price</td><td>
                    <form action=\"/action.php\" method=\"post\">
                        <input type=\"hidden\" name=\"class_name\" value=\"Homeworks\Homework7\">
                        <input type=\"hidden\" name=\"func_name\" value=\"paragraph1\">
                        <input type=\"hidden\" name=\"product_id\" value=\"$product->product_id\">
                        <input type=\"submit\" name=\"operation\" value=\"-\">
                        <input type=\"submit\" name=\"operation\" value=\"+\">
                    </form>
                </td></tr>";
        }

        echo "<tr><td></td><td></td><td></td><th>Итого</th><td>$sum_all_price</td><td></td></tr>
            </table>
            <p>$mes_order</p>
            <p>
            <form action=\"/action.php\" method=\"post\">
                        <input type=\"hidden\" name=\"class_name\" value=\"Homeworks\Homework7\">
                        <input type=\"hidden\" name=\"func_name\" value=\"shop\">
                        <input type=\"submit\" value=\"Магазин\">
            </form>";

        if ($user) {
            echo " <form action=\"/action.php\" method=\"post\">
                        <input type=\"hidden\" name=\"class_name\" value=\"Homeworks\Homework7\">
                        <input type=\"hidden\" name=\"func_name\" value=\"paragraph1\">
                        <input type=\"submit\" name=\"operation\" value=\"Заказать\">
                    </form>";
        } else {
            echo "<form action=\"/action.php\" method=\"post\">
                        <input type=\"hidden\" name=\"class_name\" value=\"Homeworks\Homework7\">
                        <input type=\"hidden\" name=\"func_name\" value=\"paragraph2\">
                        <input type=\"submit\" value=\"Авторизоваться\">
            </form>";
        }
            echo "</p></body></html>";
    }

    public function shop($post)
    {
        require_once 'DB\Query.php';
        $products = (new Query())
            ->select(['product_id' => 'product.id', 'path', 'product.title', 'product.price'])
            ->table('product')
            ->innerJoin('img', 'img.id = product.img_id')
            ->execute();
        if (isset($post['product_id']) && isset($post['operation'])) {
            $operation = $post['operation'];
            if ($operation == '+') {
                foreach ($products as $product) {
                    if ($product->product_id == $post['product_id']) {
                        $this->addBasket($post['product_id'], $product);
                    }
                }
            } else {
                $this->putBasket($post['product_id']);
            }
        }

        echo "<html>
        <head>
            <meta charset=\"utf-8\">
            <title>Магазин</title>
        </head>
        <body>
            <table border=\"1\">
            <caption>Магазин</caption>
        <tr>
            <th>Изображение</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Добавить\Удалить</th>
        </tr>";
        foreach ($products as $product) {
            echo "<tr><td><img src=\"$product->path\" width=\"240\"></td><td>$product->title</td><td>$product->price</td><td>
                    <form action=\"/action.php\" method=\"post\">
                        <input type=\"hidden\" name=\"class_name\" value=\"Homeworks\Homework7\">
                        <input type=\"hidden\" name=\"func_name\" value=\"shop\">
                        <input type=\"hidden\" name=\"product_id\" value=\"$product->product_id\">
                        <input type=\"submit\" name=\"operation\" value=\"-\">
                        <input type=\"submit\" name=\"operation\" value=\"+\">
                    </form>
                </td></tr>";
        }
        echo "</table>
                <form action=\"/action.php\" method=\"post\">
                        <input type=\"hidden\" name=\"class_name\" value=\"Homeworks\Homework7\">
                        <input type=\"hidden\" name=\"func_name\" value=\"paragraph1\">
                        <input type=\"submit\" value=\"Корзина\">
                </form></body></html>";
    }

    public function addBasket($product_id, $product = null)
    {
        $this->startSession();
        if (!$product) {
            $product = $_SESSION['basket'][$product_id]['product'];
        }

        $_SESSION['basket'][$product_id]['product']  = $product;
        $count = $_SESSION['basket'][$product_id]['count'] ?? 0;
        $_SESSION['basket'][$product_id]['count'] = ++$count;
        $_SESSION['basket'][$product_id]['sum_price'] = $count * $product->price;
    }

    public function putBasket($product_id)
    {
        $this->startSession();

        $product = $_SESSION['basket'][$product_id]['product'] ?? null;
        $count = $_SESSION['basket'][$product_id]['count'] ?? 0;

        if ($product && $count > 1) {
            $_SESSION['basket'][$product_id]['count'] = --$count;
            $_SESSION['basket'][$product_id]['sum_price'] = $count * $product->price;
        } else {
            unset($_SESSION['basket'][$product_id]);
        }
    }
    public function startSession()
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start([
                'cookie_lifetime' => 86400
            ]);
        }
    }

    public function paragraph2($post)
    {
        $type = $post['type'] ?? null;

        $this->startSession();
        if ($type == 'Выйти из сессии') {
            session_destroy();
            $this->startSession();
        }

        $user = $_SESSION['user'] ?? null;
        $mes_pass = '';
        $mes_login = '';

        if (isset($post['login']) && isset($post['password']) && $type && !$user) {
            $login = $post['login'];
            $password = $post['password'];
            if (!$password) {
                $mes_pass = 'Не передан пароль';
            }
            if (!$login) {
                $mes_login = 'Не передан логин';
            }
            if ($login && $password) {
                if ($post['type'] == 'Регистрация') {
                    if (!$this->register($login, $password)) {
                        $mes_login = 'такой пользователь уже есть';
                    }
                } else {
                    if (!$this->authorization($login, $password)) {
                        $mes_login = 'Не верный пароль или логин';
                    }
                }
                $user = $_SESSION['user'] ?? null;
            }
        }

        echo "<html>
        <head>
            <meta charset=\"utf-8\">
            <title>Личный кабинет</title>
        </head>
        <body>";

        if (!$user) {
            echo "</form>
            <form action=\"/action.php\" method=\"post\">
                <input type=\"hidden\" name=\"class_name\" value=\"Homeworks\Homework7\">
                <input type=\"hidden\" name=\"func_name\" value=\"paragraph2\">
                <p>Логин: <input type=\"text\" name=\"login\"> $mes_login</p>
                <p>Пароль: <input type=\"text\" name=\"password\"> $mes_pass</p>
                <p><input type=\"submit\" name=\"type\" value=\"Авторизация\">
                <input type=\"submit\" name=\"type\" value=\"Регистрация\"></p>
            </form>";
        } else {
            echo '<p>Добро пожаловать '.$user['login'].'</p>';
            echo "</form>
            <form action=\"/action.php\" method=\"post\">
                <input type=\"hidden\" name=\"class_name\" value=\"Homeworks\Homework7\">
                <input type=\"hidden\" name=\"func_name\" value=\"paragraph2\">
                <p><input type=\"submit\" name=\"type\" value=\"Выйти из сессии\"></p>
            </form>
            <form action=\"/action.php\" method=\"post\">
                        <input type=\"hidden\" name=\"class_name\" value=\"Homeworks\Homework7\">
                        <input type=\"hidden\" name=\"func_name\" value=\"paragraph1\">
                        <input type=\"submit\" value=\"Корзина\">
                </form>
                <form action=\"/action.php\" method=\"post\">
                        <input type=\"hidden\" name=\"class_name\" value=\"Homeworks\Homework8\">
                        <input type=\"hidden\" name=\"func_name\" value=\"orders\">
                        <input type=\"submit\" value=\"Заказы\">
                </form>";
        }

        echo '</body></html>';
    }

    public function register($login, $password, $role = 'user')
    {
        $this->startSession();
        require_once 'DB\Query.php';
        $user = (new Query())
            ->select(['id'])
            ->table('user')
            ->where(['login' => $login])
            ->execute();
        if (!$user) {
            $id = (new Query())
                ->table('user')
                ->insert([
                    'login' => $login,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'role' => $role
                ])
                ->execute();
            $_SESSION['user']['id'] = $id;
            $_SESSION['user']['login'] = $login;
            $_SESSION['user']['role'] = $role;
            return 1;
        } else {
            return 0;
        }
    }

    public function authorization($login, $password)
    {
        $this->startSession();
        require_once 'DB\Query.php';
        $user = (new Query())
            ->table('user')
            ->where(['login' => $login])
            ->execute();
        if ($user && password_verify($password, $user[0]->password)) {
            $_SESSION['user']['id'] = $user[0]->id;
            $_SESSION['user']['login'] = $login;
            $_SESSION['user']['role'] = $user[0]->role;
            return 1;
        } else {
            return 0;
        }
    }
}