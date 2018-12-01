<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

class OrdersClass
{
    public static function display($name)
    {
        echo "<h1>This is order: {$name}!</h1>";
    }
}

$app->get(
    '/orders/display/{name}',
    'OrdersClass::display'
);

$app->handle();
