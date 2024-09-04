<?php
namespace MVC\Services;

use MVC\Repository\BookRepository;
use MVC\Repository\BranchRepository;
use MVC\Repository\CategoryRepository;
use MVC\Repository\CodesaleRepository;
use MVC\Repository\GalleryImageRepository;
use MVC\Repository\CommentRepository;
use MVC\Repository\OrderRepository;
use MVC\Repository\RatingRepository;
use MVC\Repository\RouteRepository;
use MVC\Repository\TransportRepository;
use MVC\Repository\TransactionRepository;


session_start();

class RatingService {

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
    
    public function getRatingOfBook($bookId,$userId,$rating){
        $count = RatingRepository::getInstance()->findRateByBookIdAndUserId($bookId,$userId);
        if($count > 0){

            $isUpdateRating = RatingRepository::getInstance()->updateRating($rating,$userId,$bookId);
            if($isUpdateRating){

                $_SESSION['message'] = 'Rating added successfully';
            } else {
                echo 'Error adding rating';
                $_SESSION['message'] = 'Rating added unsuccessfully';
            }

        } else {

            $isAddRating = RatingRepository::getInstance()->addRating($rating,$userId,$bookId);
            if($isAddRating){
                $_SESSION['message'] = 'Rating added successfully';
            } else {
                $_SESSION['message'] = 'Rating added unsuccessfully';
            }
        }
    }
}

