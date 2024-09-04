<?php

namespace MVC\Models;
use DBConfig;

// require_once('../database.php');

Class Transaction {
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

    public function addNewTransaction($address,$fullName,$orderId,$total,$codesaleId,$transportId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare("INSERT INTO transactions (createdAt,shippedAt,address,receiver,order_id,total,codesale,transport_id) values (NOW(),DATE_ADD(CURDATE(), INTERVAL 7 DAY),?,?,?,?,?,?)");
        $stmt->bind_param('ssidii', $address, $fullName, $orderId, $total,$codesaleId,$transportId);

        return $stmt->execute();
    }

    public function getNumberPageOfHistoryPage($limit,$userId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare("SELECT t.createdAt, t.address, t.receiver, t.order_id, t.total, o.user_id 
                                FROM transactions as t 
                                LEFT JOIN order_item as o ON t.order_id = o.id 
                                WHERE o.user_id = ? ORDER BY t.createdAt DESC");
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $number_result  = $stmt->get_result()->num_rows;

        $number_page = ceil($number_result/ $limit);

        return $number_page;
    }

    public function getByHistoryPagination($userId,$page_first,$limit){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT t.createdAt, t.address, t.receiver, t.order_id, t.total, o.user_id, tr.status 
                                FROM transactions as t 
                                LEFT JOIN order_item as o ON t.order_id = o.id 
                                LEFT JOIN transport as tr ON t.transport_id = tr.id 
                                WHERE o.user_id = ? ORDER BY tr.status, t.createdAt DESC LIMIT ?,?');
        $stmt->bind_param("iii", $userId,$page_first,$limit);
        $stmt->execute();

        $transactions= $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $transactions;
    }

    public function getNumberPageOfRevenueManagementPage($from,$to,$limit){
        $db = DBConfig::getDB();

        if($from != null && $to != null){
            if(empty($from) || empty($to)){
                $timestamp = strtotime(date('Y-m-d'));
                $dateFrom = date('Y-m-01 00:00:00', $timestamp);
                $dateTo  = date('Y-m-t 23:59:59', $timestamp);
            } else {
                $dateFrom = $from. ' 00:00:00';
                $dateTo = $to . ' 23:59:59';
                $dateFrom = str_replace('/', '-', $dateFrom);
                $dateTo = str_replace('/', '-', $dateTo);
            }
    
            $lower= date('Y-m-d H:i:s', strtotime($dateFrom));
            $upper = date('Y-m-d H:i:s', strtotime($dateTo));
    
            $stmt = $db->prepare('SELECT t.createdAt, t.address, t.receiver, t.order_id, t.total, o.user_id 
                                    FROM transactions as t 
                                    LEFT JOIN order_item as o ON t.order_id = o.id 
                                    WHERE t.createdAt BETWEEN? AND ? 
                                    ORDER BY t.createdAt ASC');
            $stmt->bind_param('ss', $lower, $upper);
        } else {
            $timestamp = strtotime(date('Y-m-d'));
            $dateFrom = date('Y-m-01 00:00:00', $timestamp);
            $dateTo  = date('Y-m-t 23:59:59', $timestamp);
    
            $lower= date('Y-m-d H:i:s', strtotime($dateFrom));
            $upper = date('Y-m-d H:i:s', strtotime($dateTo));
            
    
            $stmt = $db->prepare('SELECT t.createdAt, t.address, t.receiver, t.order_id, t.total, o.user_id 
                                    FROM transactions as t 
                                    LEFT JOIN order_item as o ON t.order_id = o.id 
                                    WHERE t.createdAt BETWEEN? AND ?
                                    ORDER BY t.createdAt ASC');
    
            $stmt->bind_param('ss', $lower, $upper);
        }
    
        $stmt->execute();
        $number_result = $stmt->get_result()->num_rows;
        $number_page = ceil($number_result / $limit);


        return $number_page;
    }

    public function getAllByRevenueManagementPagination($from,$to,$page,$limit){

        $db = DBConfig::getDB();

        $page_first = ($page - 1) * $limit;

        if($from != null && $to != null){
            if(empty($from) || empty($to)){
                $timestamp = strtotime(date('Y-m-d'));
                $dateFrom = date('Y-m-01 00:00:00', $timestamp);
                $dateTo  = date('Y-m-t 23:59:59', $timestamp);
            } else {
                $dateFrom = $from. ' 00:00:00';
                $dateTo = $to . ' 23:59:59';
                $dateFrom = str_replace('/', '-', $dateFrom);
                $dateTo = str_replace('/', '-', $dateTo);
            }
    
            $lower= date('Y-m-d H:i:s', strtotime($dateFrom));
            $upper = date('Y-m-d H:i:s', strtotime($dateTo));
            $stmt = $db->prepare('SELECT t.createdAt, t.address, t.receiver, t.order_id, t.total, o.user_id, tr.status 
                                    FROM transactions as t 
                                    LEFT JOIN order_item as o ON t.order_id = o.id 
                                    LEFT JOIN transport as tr ON t.transport_id = tr.id 
                                    WHERE t.createdAt BETWEEN? AND ? 
                                    ORDER BY tr.status, t.createdAt ASC LIMIT?,?');
            $stmt->bind_param('ssii', $lower, $upper, $page_first, $limit);
        } else {
            $timestamp = strtotime(date('Y-m-d'));
            $dateFrom = date('Y-m-01 00:00:00', $timestamp);
            $dateTo  = date('Y-m-t 23:59:59', $timestamp);
    
            $lower= date('Y-m-d H:i:s', strtotime($dateFrom));
            $upper = date('Y-m-d H:i:s', strtotime($dateTo));

            $stmt = $db->prepare('SELECT t.createdAt, t.address, t.receiver, t.order_id, t.total, o.user_id, tr.status
                                    FROM transactions as t 
                                    LEFT JOIN order_item as o ON t.order_id = o.id 
                                    LEFT JOIN transport as tr ON t.transport_id = tr.id 
                                    WHERE t.createdAt BETWEEN? AND ?
                                    ORDER BY tr.status, t.createdAt ASC LIMIT?,?');
            $stmt->bind_param('ssii',$lower,$upper, $page_first, $limit);
        }
    
        $stmt->execute();
        
        $transactions= $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $transactions;
    }

    public function findByOrderId($orderId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT * FROM transactions WHERE order_id = ?');
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
    
        $transaction = $stmt->get_result()->fetch_assoc();

        return $transaction;
    }




}





