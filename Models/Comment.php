<?php

namespace MVC\Models;
use DBConfig;

// require_once('../database.php');

Class Comment {
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
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT c.comment_id, c.text, c.user_id, c.book_id, c.createdAt, c.parent_id, u.fullname, u.image 
                                FROM comments as c 
                                LEFT JOIN users as u 
                                ON c.user_id = u.id
                                WHERE c.book_id =? and parent_id IS NULL 
                                ORDER BY createdAt DESC');
        $stmt->bind_param('i', $bookId);
        $stmt->execute();

        $result_count_cmt = $stmt->get_result();

        return $result_count_cmt->fetch_all(MYSQLI_ASSOC);
    }


    public function getCountCommentsByBookId($bookId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT c.comment_id, c.text, c.user_id, c.book_id, c.createdAt, c.parent_id, u.fullname, u.image 
                                FROM comments as c 
                                LEFT JOIN users as u 
                                ON c.user_id = u.id
                                WHERE c.book_id =? and parent_id IS NULL 
                                ORDER BY createdAt DESC');
        $stmt->bind_param('i', $bookId);
        $stmt->execute();

        $result_count_cmt = $stmt->get_result();

        return $result_count_cmt->num_rows;
    }

    public function getAllRepliesByBookId($bookId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT c.comment_id, c.text, c.user_id, c.book_id, c.createdAt, c.parent_id, u.fullname, u.image 
                                FROM comments as c 
                                LEFT JOIN users as u 
                                ON c.user_id = u.id
                                WHERE c.book_id =? and c.parent_id IS NOT NULL
                                ORDER BY createdAt DESC');
        $stmt->bind_param('i', $bookId);
        $stmt->execute();

        $result_count_cmt = $stmt->get_result();

        return $result_count_cmt->fetch_all(MYSQLI_ASSOC);;
    }

    public function addNewCommentInBook($bookId,$userId,$textComment){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('INSERT INTO comments (book_id, user_id, text, createdAt) VALUES (?,?,?,NOW())');
        $stmt->bind_param('iis', $bookId, $userId, $textComment);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function addNewReplyInComment($bookId,$userId,$textComment,$parentId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('INSERT INTO comments (book_id, user_id, text, createdAt, parent_id) VALUES (?,?,?,NOW(),?)');
        $stmt->bind_param('iisi', $bookId, $userId, $textComment,$parentId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    




}





