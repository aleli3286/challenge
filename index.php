<?php
/**
 * Created by PhpStorm.
 * Date: 2/19/2019
 * Time: 8:28 AM
 */

ini_set('error_reporting', E_ALL);

include 'setup.php';

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.css"/>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.js"></script>
</head>
<body>
    <header class="container">
        <h1>Challenge</h1>
        <?php \App\Kernel\Container::getInstance()->get('messages')->showMessages(); ?>
    </header>
    <div class="container" style="margin-top: 20px;">
        <section class="filter-section">
            <?php include "form.php"; ?>
        </section>
        <section class="listing-section" style="margin-top: 20px;">
            <?php include "list.php" ?>
        </section>
    </div>
</body>
</html>
