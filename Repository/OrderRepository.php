<?php

namespace MVC\Repository;

use MVC\Models\Book;
use MVC\Models\Category;
use MVC\Models\GalleryImage;
use MVC\Models\User;
use MVC\Models\Order;


// require_once('../database.php');

Class OrderRepository {
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

    public function addNewOrder($userId){
        return Order::getInstance()->addNewOrder($userId);
    }

    public function addNewOrderDetail($bookId,$qty,$price,$orderId,$totalItem){
        return Order::getInstance()->addNewOrderDetail($bookId,$qty,$price,$orderId,$totalItem);
    }

    public function getAllOrderDetailsByOrderid($orderId){
        return Order::getInstance()->getAllOrderDetailsByOrderid($orderId);
    }

    public function checkByBookId($bookId){
        return Order::getInstance()->checkByBookId($bookId);
    }



}





