<?php

namespace MVC\Models;
use DBConfig;


Class Route {
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

    public function addNewRouteForTransport($transportId){
        $db = DBConfig::getDB();

        for($i = 0;$i <=2;$i++){
            $stmt = $db->prepare("INSERT INTO route (transport_id,point,status,estimateDate) VALUES (?,?,0,DATE_ADD(CURDATE(), INTERVAL 7 DAY))");
            $stmt->bind_param('ii', $transportId, $i);
            $stmt->execute();
        }

    }

    public function getAllRoutesByTransportId($transportId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT * FROM route where transport_id = ?');
        $stmt->bind_param('i',$transportId);
        $stmt->execute();
    
        $routes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        

        return $routes;
    }

    public function updateRouteByIdAndTransportId($routeId,$transportId){

        $db = DBConfig::getDB();

        $stmt = $db->prepare("UPDATE route SET status = 1 WHERE id =? and transport_id =? AND status = 0");
        $stmt->bind_param("ii", $routeId, $transportId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }




}





