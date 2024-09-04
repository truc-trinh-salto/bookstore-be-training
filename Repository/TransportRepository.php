<?php

namespace MVC\Repository;

use MVC\Models\Book;
use MVC\Models\Category;
use MVC\Models\GalleryImage;
use MVC\Models\User;
use MVC\Models\Transport;

// require_once('../database.php');

Class TransportRepository {
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

    public function addNewTransport(){
        return Transport::getInstance()->addNewTransport();
    }

    public function updateTransport($transportId){
        return Transport::getInstance()->updateTransport($transportId);
    }



}





