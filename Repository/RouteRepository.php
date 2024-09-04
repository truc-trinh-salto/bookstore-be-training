<?php

namespace MVC\Repository;

use MVC\Models\Book;
use MVC\Models\Category;
use MVC\Models\GalleryImage;
use MVC\Models\User;
use MVC\Models\Route;

// require_once('../database.php');

Class RouteRepository {
    private static $instance;
    private function __construct(){}
    private function __clone(){}

    

    public static function getInstance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname;
        }
        return self::$instance;
    }

    public function getAllRoutesByTransportId($transportId){
        return Route::getInstance()->getAllRoutesByTransportId($transportId);
    }

    public function addNewRouteForTransport($transportId){
        return Route::getInstance()->addNewRouteForTransport($transportId);
    }

    public function updateRouteByIdAndTransportId($routeId,$transportId){
        return Route::getInstance()->updateRouteByIdAndTransportId($routeId,$transportId);
    }



}





