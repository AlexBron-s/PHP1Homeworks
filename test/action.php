<?php
const DIR = __DIR__.'\\';

if (!empty($_POST)) {
    $post = $_POST;
} elseif (!empty($_GET)) {
    $post = $_GET;
}

if(isset($post['func_name']) && isset($post['class_name'])){
    if (file_exists($post['class_name'].'.php')) {
        require_once $post['class_name'].'.php';

        $action_func = $post['func_name'];
        $class = new $post['class_name'];

        if (method_exists($class, $action_func)){

            $response = $class->$action_func($post);
            if ($response) {
                header('Content-Type: application/json');
                echo json_encode($response,JSON_UNESCAPED_UNICODE);
            }

        } else {echo "Такого метода нет";}

    } else {echo "Такого класса нет";}

} else {echo "Не передано название метода или класса";}

