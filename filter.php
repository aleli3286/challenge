<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 10:32 PM
 */

ini_set('error_reporting', E_ALL);

include 'setup.php';

$filter = new \App\Controller\Filter();
$filter->setFilter($_POST['filter']);

header('Location: index.php');