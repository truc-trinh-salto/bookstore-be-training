<?php

namespace MVC\Repository;


use MVC\Models\User;

// require_once('../database.php');

Class UserRepository {
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

    public function findByUsernameAndPassword($userName,$passWord){
        return User::getInstance()->findByUsernameAndPassword($userName,$passWord);
    }

    public function findById($userId){
        return User::getInstance()->findById($userId);
    }

    public function updateUser($fullName,$phoneNumber,$birthDay,$email,$userId){
        return User::getInstance()->updateUser($fullName,$phoneNumber,$birthDay,$email,$userId);
    }

    public function updatePassword($newPassword,$userName){
        return User::getInstance()->updatePassword($newPassword,$userName);
    }

    public function updateImage($image,$userId){
        return User::getInstance()->updateImage($image,$userId);
    }

    public function getNumberPageOfUserManagementPage($searchKeyword,$limit){
        return User::getInstance()->getNumberPageOfUserManagementPage($searchKeyword,$limit);
    }

    public function getAllByUserManagementPagnination($searchKeyword,$page,$limit){
        return User::getInstance()->getAllByUserManagementPagnination($searchKeyword,$page,$limit);
    }

    public function updateActivate($userId, $action){
        return User::getInstance()->updateActivate($userId, $action);
    }

    public function findByUsername($userName){
        return User::getInstance()->findByUsername($userName);
    }

    public function addNewUser($username,$password,$fullname,$phone,$birthday){
        return User::getInstance()->addNewUser($username,$password,$fullname,$phone,$birthday);
    }



}





