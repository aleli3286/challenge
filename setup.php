<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 9:18 AM
 */

session_start();

include 'classes.php';
include 'config.php';

$connection = new \App\Kernel\Connection(
    $config['database_host'],
    $config['database_name'],
    $config['database_user'],
    $config['database_password']
);

$session = new \App\Http\Session();

$container = \App\Kernel\Container::getInstance();
$container->set('connection', $connection);
$container->set('session', $session);
$container->set('messages', new Messages());
$container->set('attribute', new \App\Entity\AttributeRepository());
$container->set('attribute_option', new \App\Repository\AttributeOptionRepository());
$container->set('category', new \App\Repository\CategoryRepository());
$container->set('product', new \App\Repository\ProductRepository());