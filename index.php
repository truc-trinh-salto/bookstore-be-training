<?php

require 'vendor/autoload.php';

session_start();
if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
    $_SESSION['qty_array'] = array();
}


$uri = $_SERVER['REQUEST_URI'];


$router = require 'routes.php';

$router->dispatch($uri);