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

class CommentService {

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
    
    public function addNewCommentInBook($bookId,$userId,$textComment){
        $isAddedComment = CommentRepository::getInstance()->addNewCommentInBook($bookId, $userId, $textComment);

        if($isAddedComment)
        {
            $_SESSION['message'] = 'Comment added successfully';
        } else {
            $_SESSION['message'] = 'Comment added unsuccessfully';
        }
    }

    public function addNewReplyInBook($bookId,$userId,$textComment,$parentId){
        $isAddedReply = CommentRepository::getInstance()->addNewReplyInComment($bookId, $userId, $textComment,$parentId);
    
            if($isAddedReply)
            {
                $_SESSION['message'] = 'Comment added successfully';
            } else {
                echo 'Error adding comment';
                $_SESSION['message'] = 'Comment added unsuccessfully';
            }
    }
}

