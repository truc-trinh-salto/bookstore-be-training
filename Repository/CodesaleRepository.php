<?php

namespace MVC\Repository;

use MVC\Models\Book;
use MVC\Models\Category;
use MVC\Models\GalleryImage;
use MVC\Models\User;
use MVC\Models\Codesale;

// require_once('../database.php');

Class CodesaleRepository {
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

    public function findByCode($code){
        return Codesale::getInstance()->findByCode($code);
    }

    public function findById($codeId){
        return Codesale::getInstance()->findById($codeId);
    }

    public function addUserCode($codeId,$userId){
        return Codesale::getInstance()->addUserCode($codeId,$userId);
    }

    public function checkUserCode($codeId,$userId){
        return Codesale::getInstance()->checkUserCode($codeId,$userId);
    }

    public function getAllActive(){
        return Codesale::getInstance()->getAllActive();
    }

    public function getAllCodesales($searchKeyword){
        return Codesale::getInstance()->getAllCodesales($searchKeyword);
    }

    public function updateActivate($codeId,$action){
        return Codesale::getInstance()->updateActivate($codeId,$action);
    }

    public function checkExistence($code){
        return Codesale::getInstance()->checkExistence($code);
    }

    public function addCodesale($description, $min, $max, $startAt, $endAt, $activate, $method, $value, $code){
        return Codesale::getInstance()->addCodesale($description, $min, $max, $startAt, $endAt, $activate, $method, $value, $code);
    }

    public function updateCodesale($codeId, $description, $min, $max, $startAt, $endAt, $activate, $method, $value, $code){
        return Codesale::getInstance()->updateCodesale($codeId, $description, $min, $max, $startAt, $endAt, $activate, $method, $value, $code);
    }

    public function checkExistenceById($code,$codeId){
        return Codesale::getInstance()->checkExistenceById($code,$codeId);
    }



}





