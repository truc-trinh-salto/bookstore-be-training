<?php

namespace MVC\Repository;

use MVC\Models\Book;
use MVC\Models\Category;
use MVC\Models\GalleryImage;
use MVC\Models\User;
use MVC\Models\Rating;
use MVC\Models\Comment;

// require_once('../database.php');

Class CommentRepository {
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

    public function getAllCommentsByBookId($bookId){
        return Comment::getInstance()->getAllCommentsByBookId($bookId);
    }

    public function getCountCommentsByBookId($bookId){
        return Comment::getInstance()->getCountCommentsByBookId($bookId);
    }

    public function getAllRepliesByBookId($bookId){
        return Comment::getInstance()->getAllRepliesByBookId($bookId);
    }

    public function addNewCommentInBook($bookId, $userId, $textComment){
        return Comment::getInstance()->addNewCommentInBook($bookId, $userId, $textComment);
    }

    public function addNewReplyInComment($bookId, $userId, $textComment,$parentId){
        return Comment::getInstance()->addNewReplyInComment($bookId, $userId, $textComment,$parentId);
    }



}





