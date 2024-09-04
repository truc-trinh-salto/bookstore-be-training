<?php

namespace MVC\Repository;

use MVC\Models\Book;
use MVC\Models\Category;
use MVC\Models\GalleryImage;
use MVC\Models\User;
use MVC\Models\Rating;

// require_once('../database.php');

Class RatingRepository {
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

    public function getCountRatingsByBookId($bookId){
        return Rating::getInstance()->getCountRatingsByBookId($bookId);
    }

    public function getAllRatingsByBookId($bookId){
        return Rating::getInstance()->getAllRatingsByBookId($bookId);
    
    }

    public function findRateByBookIdAndUserId($bookId,$userId){
        return Rating::getInstance()->findRateByBookIdAndUserId($bookId,$userId);
    }

    public function updateRating($rating,$userId,$bookId){
        return Rating::getInstance()->updateRating($rating,$userId,$bookId);
    }

    public function addRating($rating,$userId,$bookId){
        return Rating::getInstance()->addRating($rating,$userId,$bookId);
    }



}





