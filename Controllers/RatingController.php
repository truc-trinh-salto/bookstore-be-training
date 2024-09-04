<?php
namespace MVC\Controllers;
// require '../vendor/autoload.php';
use MVC\Controller;


use MVC\Services\RatingService;

session_start();

class RatingController extends Controller {
    public function rating(){
        if(!$_SESSION['user_id']){
            header('Location: /login');
            exit();
        } else if(isset($_POST['submit']) && isset($_POST['rating'])){
            $userId = $_SESSION['user_id'];
            $rating = $_POST['rating'];
            $bookId = $_POST['book_id_rate'];

            RatingService::getInstance()->getRatingOfBook($bookId,$userId,$rating);
            
            header('Location: /detail_product?book_id='. $bookId);
        } else {
            exit();
        }
    }
}


