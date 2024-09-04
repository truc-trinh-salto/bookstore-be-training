<?php

namespace MVC\Repository;

use MVC\Models\Book;
use MVC\Models\Category;
use MVC\Models\GalleryImage;
use MVC\Models\User;
use MVC\Models\Import;

// require_once('../database.php');

Class ImportRepository {
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

    public function findFirstImportInMonth($date){
        return Import::getInstance()->findFirstImportInMonth($date);
    }

    public function getNumberPageOfInventoryManagementPage($searchKeyword,$limit){
        return Import::getInstance()->getNumberPageOfInventoryManagementPage($searchKeyword,$limit);
    }

    public function getAllByInventoryManagementPagination($searchKeyword,$page,$limit){
        return Import::getInstance()->getAllByInventoryManagementPagination($searchKeyword,$page,$limit);
    }

    public function findById($importId){
        return Import::getInstance()->findById($importId);
    }

    public function addImport($books){
        return Import::getInstance()->addImport($books);
    }

    public function deleteImportById($importId){
        return Import::getInstance()->deleteImportById($importId);
    }

    public function findImportDetailByBookIdAndImportId($bookId, $importId){
        return Import::getInstance()->findImportDetailByBookIdAndImportId($bookId, $importId);
    }

    public function updateImportDetail($newAfterStock,$newQuantity,$bookId,$importId){
        return Import::getInstance()->updateImportDetail($newAfterStock,$newQuantity,$bookId,$importId);
    }

    public function updateQuantityInventory($quantity,$importId){
        return Import::getInstance()->updateQuantityInventory($quantity,$importId);
    }

    public function updateStatusImport($importId){
        return Import::getInstance()->updateStatusImport($importId);
    }

    public function addImportDetail($bookId,$importId,$quantity,$stock,$afterStock){
        return Import::getInstance()->addImportDetail($bookId,$importId,$quantity,$stock,$afterStock);
    }

}





