<?php

namespace MVC\Models;
use DBConfig;

// require_once('../database.php');

Class Rating {
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

    public function findByUserIdAndBookId($userId,$bookId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare("SELECT * FROM rate where user_id =? AND book_id =?");
        $stmt->bind_param("ii", $userId, $bookId);
        $stmt->execute();

        $count = $stmt->get_result()->num_rows;
        return $count;
    }

    public function getAllRatingsByBookId($bookId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT * FROM rate WHERE book_id =?');
        $stmt->bind_param('i', $bookId);
        $stmt->execute();
    
        $result_count_rate = $stmt->get_result();

        return $result_count_rate->fetch_all(MYSQLI_ASSOC);
    }


    public function getCountRatingsByBookId($bookId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT * FROM rate WHERE book_id =?');
        $stmt->bind_param('i', $bookId);
        $stmt->execute();
    
        $result_count_rate = $stmt->get_result();

        return $result_count_rate->num_rows;
    }

    public function findRateByBookIdAndUserId($bookId, $userId){
        $db = DBConfig::getDB();
        $stmt = $db->prepare('SELECT * FROM rate WHERE book_id =? and user_id =?');
        $stmt->bind_param('ii', $bookId, $userId);
        $stmt->execute();
    
        $rate_of_user = $stmt->get_result()->fetch_assoc();

        return $rate_of_user;
    }

    public function updateRating($rating,$userId,$bookId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('UPDATE rate SET value = ? WHERE user_id =? AND book_id =?');
        $stmt->bind_param('iii', $rating, $userId, $bookId);
        $stmt->execute();
        
        return $stmt->affected_rows > 0;
    }

    public function addRating($rating,$userId,$bookId){
        $db = DBConfig::getDB();

        $stmt= $db->prepare('INSERT INTO rate (user_id, book_id, value) VALUES (?,?,?)');
        $stmt->bind_param('iii', $userId, $bookId, $rating);
        $stmt->execute();
    
        return $stmt->affected_rows > 0;
    }
}





