<?php
namespace MVC\Controllers;
// require '../vendor/autoload.php';
use MVC\Controller;


use MVC\Services\RouteService;

session_start();

class RouteController extends Controller {
    public function updateRoute(){
        $routeId = $_POST['route_id'];
        $transportId = $_POST['transport_id'];
        $point = $_POST['point'];

        RouteService::getInstance()->updateRoute($routeId, $transportId, $point);

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}


