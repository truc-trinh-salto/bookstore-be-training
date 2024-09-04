<?php

namespace MVC\Models;
use DBConfig;

// require_once('../database.php');

Class Transport {
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

    public function addNewTransport(){
        $db = DBConfig::getDB();
        $stmt = $db->prepare("INSERT INTO transport (plannedAt,status) VALUES (DATE_ADD(CURDATE(), INTERVAL 7 DAY),0)");
        $stmt->execute();

        return $stmt->insert_id;;
    }

    public function updateTransport($transportId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare("UPDATE transport SET status = 1, actualAt = NOW() WHERE id =?");
        $stmt->bind_param("i", $transportId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }




}





