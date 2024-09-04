<?php

namespace MVC\Models;
use DBConfig;


Class Order {
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

    public function addNewOrder($userId){
        echo $userId;
        $db = DBConfig::getDB();
        echo $userId;
        $stmt = $db->prepare("INSERT INTO order_item (user_id,status) values (?,0)");
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        $order_id = $stmt->insert_id;

        return $order_id;
    }

    public function addNewOrderDetail($bookId, $qty, $price, $orderId, $totalItem){
        $db = DBConfig::getDB();
        $stmt1 = $db->prepare("INSERT INTO order_detail (book_id, quantity, price, total , order_id) VALUES (?,?,?,?,?)");
        $stmt1->bind_param('iiddi',$bookId,$qty,$price,$totalItem, $orderId);

        return $stmt1->execute();
    }

    public function getAllOrderDetailsByOrderid($orderId){
        $db = DBConfig::getDB();
        $stmt = $db->prepare('SELECT o.book_id, o.quantity, o.price, o.total, o.order_id, b.title, b.authors
                                FROM order_detail as o
                                LEFT JOIN books as b ON o.book_id = b.book_id
                                WHERE o.order_id = ?
                                ORDER BY o.order_id ASC');

        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $order_details = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $order_details;
    }

    public function checkByBookId($bookId){
        $db = DBConfig::getDB();
        $stmt = $db->prepare('SELECT * FROM order_detail WHERE book_id =?');
        $stmt->bind_param("i", $bookId);
        $stmt->execute();
        $order_details =  $stmt->get_result()->num_rows;

        return $order_details > 0;
    }




}





