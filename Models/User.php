<?php

namespace MVC\Models;
use DBConfig;

// require_once('../database.php');

Class User {
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

    public function findByUsernameAndPassword($username, $password){
        $db = DBConfig::getDB();
        $stmt = $db->prepare('SELECT * FROM users WHERE username = ? and password = ?');
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        return $user;
    }

    public function findById($userId){
        $db = DBConfig::getDB();
        $stmt = $db->prepare('SELECT * FROM users where id =?');
        $stmt->bind_param("i", $userId);
        $stmt->execute();
    
        $user = $stmt->get_result()->fetch_assoc();

        return $user;
    }

    public function updateUser($fullName,$phoneNumber,$birthDay,$email,$userId){
        $db = DBConfig::getDB();
            
        $stmt = $db->prepare("UPDATE users SET fullname =?, phonenumber =?, birthday =?, email =? WHERE id =?");
        $stmt->bind_param("ssssi", $fullName, $phoneNumber, $birthDay, $email, $userId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function updatePassword($newPassword, $userName){
        $db = DBConfig::getDB();

        $stmt = $db->prepare("UPDATE users SET password =? WHERE username =?");
        $stmt->bind_param("ss", $newPassword, $userName);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function updateImage($image,$userId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare("UPDATE users SET image = ? WHERE id = ?");
        $stmt->bind_param("si", $image, $userId);

        $stmt->execute();
        
        return $stmt->affected_rows > 0;

    }

    public function getNumberPageOfUserManagementPage($searchKeyword,$limit){
        $db = DBConfig::getDB();

        if($searchKeyword!= null) {
            $search_keyword = $searchKeyword;
            $search = "%$search_keyword%";
            $stmt = $db->prepare('SELECT * FROM users WHERE username LIKE ? OR email LIKE ? OR phone LIKE ? OR fullname LIKE ?');
            $stmt->bind_param("ssss",$search, $search, $search, $search);
        } else {
            $stmt = $db->prepare("SELECT * FROM users");
        }
    
        $stmt->execute();
    
        $number_result = $stmt->get_result()->num_rows;
    
        $number_page = ceil($number_result/ $limit);

        return $number_page;
    }

    public function getAllByUserManagementPagnination($searchKeyword,$page,$limit){
        $db = DBConfig::getDB();

        $page_first = ($page - 1) * $limit;
    
        if($searchKeyword != null) {
            $search_keyword = $searchKeyword;
            $search = "%$search_keyword%";
            $stmt = $db->prepare('SELECT * FROM users WHERE username LIKE ? OR email LIKE ? OR phone LIKE ? OR fullname LIKE ? LIMIT ?,?');
            $stmt->bind_param("ssssii",$search, $search, $search, $search, $page_first, $limit);
            
        } else {
            $stmt = $db->prepare('SELECT * from users LIMIT ?,?');
            $stmt->bind_param('ii', $page_first, $limit);
        }
        $stmt->execute();
        $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $users;
    }

    public function updateActivate($userId, $action){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('UPDATE users SET deactivate =? WHERE id =?');
        $stmt->bind_param('ii', $action, $userId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }
    
    public function findByUsername($userName){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT * from users where username = ?');
        $stmt->bind_param('s',$userName);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function addNewUser($username,$password,$fullname,$phone,$birthday){
        $db = DBConfig::getDB();

        $stmt = $db->prepare("insert into users(username,password,fullname,phonenumber,birthday) values(?,?,?,?,?)");
        $stmt->bind_param('sssss',$username, $password, $fullname, $phone, $birthday);
        $stmt->execute();

        return $stmt->insert_id;
    }

    


}





