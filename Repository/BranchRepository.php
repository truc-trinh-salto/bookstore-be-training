<?php
namespace MVC\Repository;

use MVC\Models\Book;
use MVC\Models\Category;
use MVC\Models\GalleryImage;
use MVC\Models\User;
use MVC\Models\Rating;
use MVC\Models\Branch;


// require_once('../database.php');

Class BranchRepository {
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
    
    public function getAllBranchesByBookId($bookId){
        return Branch::getInstance()->getAllBranchesByBookId($bookId);
    }

    public function getAll(){
        return Branch::getInstance()->getAll();
    }

    public function updateBranchSelect($bookId,$branchId){
        return Branch::getInstance()->updateBranchSelect($bookId,$branchId);
    }

    public function updateBranchStock($bookId,$branchId,$action){
        return Branch::getInstance()->updateBranchStock($bookId,$branchId,$action);
    }

    public function getAllByManagementPage($searchKeyword){
        return Branch::getInstance()->getAllByManagementPage($searchKeyword);
    }

    public function checkExistence($name){
        return Branch::getInstance()->checkExistence($name);
    }

    public function addBranch($name, $address, $hotline, $target_file){
        return Branch::getInstance()->addBranch($name, $address, $hotline, $target_file);
    }

    public function deleteById($branchId){
        return Branch::getInstance()->deleteById($branchId);
    }

    public function findById($branchId){
        return Branch::getInstance()->findById($branchId);
    }

    public function checkExistenceById($branchId,$name){
        return Branch::getInstance()->checkExistenceById($branchId,$name);
    }

    public function updateBranch($branchId,$name, $address, $hotline, $target_file){
        return Branch::getInstance()->updateBranch($branchId,$name, $address, $hotline, $target_file);
    }



}





