<?php

namespace MVC\Models;
use DBConfig;

// require_once('../database.php');

Class Codesale {
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

    public function findByCode($code) {
        $db = DBConfig::getDB();
        $stmt = $db->prepare("SELECT * FROM codesale WHERE code = ?");
        $stmt->bind_param('s', $code);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findById($codeId) {
        $db = DBConfig::getDB();

        $stmt = $db->prepare("SELECT * FROM codesale WHERE id = ?");
        $stmt->bind_param('i', $codeId);
        $stmt->execute();
        

        return $stmt->get_result()->fetch_assoc();
    }

    public function checkUserCode($codeId, $userId){
        $db = DBConfig::getDB();
        $stmt = $db->prepare("SELECT * FROM user_code where code_id =? and user_id = ?");
        $stmt->bind_param('ii', $codeId,$userId);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();;
    }

    public function addUserCode($codeId,$userId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare("INSERT INTO user_code(user_id, code_id, status) VALUES (?,?,1");
        $stmt->bind_param('ii', $userId, $codeId);
        $stmt->execute();

        return $stmt->execute();
    }

    public function getAllActive(){
        $db = DBConfig::getDB();
        $stmt = $db->prepare('SELECT * FROM codesale where deactivate = 1');
        $stmt->execute();
        $codesales = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $codesales;
    }

    public function getAllCodesales($searchKeyword){
        $db = DBConfig::getDB();

        if($searchKeyword != null) {
            $search_keyword = $searchKeyword;
            $search = "%$search_keyword%";
            $stmt = $db->prepare('SELECT * FROM codesale WHERE description LIKE ? OR code LIKE ?');
            $stmt->bind_param("ss",$search, $search);
            
        } else {
            $stmt = $db->prepare('SELECT * FROM codesale');
        }
        $stmt->execute();
        $codesales = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $codesales;
    }

    public function updateActivate($codeId,$action){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('UPDATE codesale SET deactivate =? WHERE id =?');
        $stmt->bind_param('ii', $action, $codeId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function checkExistence($code){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT * FROM codesale WHERE code =?');
        $stmt->bind_param('s', $code);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function checkExistenceById($code,$codeId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT * FROM codesale WHERE code =? and id != ?');
        $stmt->bind_param('si', $code,$codeId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function addCodesale($description, $min, $max, $startAt, $endAt, $activate, $method, $value, $code){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('INSERT INTO codesale (code, startAt, endAt, value, min, max, description, deactivate, createAt, method) values (?,?,?,?,?,?,?,?,NOW(),?)');
        $stmt->bind_param('sssdddsii', $code, $startAt, $endAt, $value, $min, $max, $description, $activate, $method);
        $stmt->execute();
        $insert = $stmt->insert_id;

        return $insert;
    }

    public function updateCodesale($codeId, $description, $min, $max, $startAt, $endAt, $activate, $method, $value, $code){
        $db = DBConfig::getDB();
        
        $stmt = $db->prepare('UPDATE codesale SET code = ?, startAt = ?, endAt = ?, value = ?, min = ?, max = ?, description = ?, deactivate = ?, method=? where id = ?');
        $stmt->bind_param('sssiiisiii', $code, $startAt, $endAt, $value, $min, $max, $description, $activate,$method, $codeId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

}





