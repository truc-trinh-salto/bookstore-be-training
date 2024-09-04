<?php

namespace MVC\Repository;

use MVC\Models\Book;
use MVC\Models\Category;
use MVC\Models\GalleryImage;
use MVC\Models\User;
use MVC\Models\Transaction;

// require_once('../database.php');

Class TransactionRepository {
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

    public function addNewTransaction($address,$fullName,$orderId,$total,$codeId,$transportId){
        return Transaction::getInstance()->addNewTransaction($address,$fullName,$orderId,$total,$codeId,$transportId);
    }

    public function getNumberPageOfHistoryPage($limit,$userId){
        return Transaction::getInstance()->getNumberPageOfHistoryPage($limit,$userId);
    }

    public function getByHistoryPagination($userId,$page_first,$limit){
        return Transaction::getInstance()->getByHistoryPagination($userId,$page_first,$limit);
    }

    public function findByOrderId($orderId){
        return Transaction::getInstance()->findByOrderId($orderId);
    }

    public function getNumberPageOfRevenueManagementPage($from,$to,$limit){
        return Transaction::getInstance()->getNumberPageOfRevenueManagementPage($from,$to,$limit);
    }

    public function getAllByRevenueManagementPagination($from,$to,$page,$limit){
        return Transaction::getInstance()->getAllByRevenueManagementPagination($from,$to,$page,$limit);
    }



}





