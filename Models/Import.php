<?php

namespace MVC\Models;
use DBConfig;

// require_once('../database.php');

Class Import {
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

    public function findFirstImportInMonth($date){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT MIN(id) as min_id FROM import 
                                    where YEAR(import) = YEAR(?) and MONTH(import) = MONTH(?) 
                                    ');
        $stmt->bind_param('ss',$date,$date);
        $stmt->execute();
        $import_min = $stmt->get_result()->fetch_assoc();

        return $import_min;
    }

    public function getNumberPageOfInventoryManagementPage($searchKeyword,$limit){
        $db = DBConfig::getDB();

        if($searchKeyword != null){
            $search_keyword = $searchKeyword;
            $search = "%$search_keyword%";
            $stmt = $db->prepare('SELECT * from import WHERE title LIKE ? ORDER BY id ASC');
            $stmt->bind_param("s",$search);
        } else {
            $stmt = $db->prepare("SELECT * FROM import ORDER BY id ASC");
        }
    
        $stmt->execute();
    
        $number_result  = $stmt->get_result()->num_rows;
    
        $number_page = ceil($number_result/ $limit);

        return $number_page;
    }

    public function getAllByInventoryManagementPagination($searchKeyword,$page,$limit){
        $db = DBConfig::getDB();

        $page_first = ($page - 1) * $limit;

        if($searchKeyword != null) {
            $search_keyword = $searchKeyword;
            $search = "%$search_keyword%";
            $stmt = $db->prepare('SELECT * from import WHERE title LIKE ? ORDER BY id ASC LIMIT?,?');
            $stmt->bind_param("sii",$search,$page_first,$limit);
            
        } else {
            $stmt = $db->prepare("SELECT * FROM import ORDER BY id ASC LIMIT?,?");
            $stmt->bind_param('ii',$page_first,$limit);
        }
        $stmt->execute();
        $imports = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $imports;
    }

    public function findById($importId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT * FROM import WHERE id =?');
        $stmt->bind_param('i',$importId);
        $stmt->execute();


        return $stmt->get_result()->fetch_assoc();
    }

    public function addImport($books){
        $db = DBConfig::getDB();

        $date = date('d-m-Y');

        $title = 'Nhập hàng ngày '. $date;
        $stmt = $db->prepare('INSERT INTO import(quantity,title,import,status) VALUES(0,?, CURRENT_TIMESTAMP,0)');
        $stmt->bind_param('s', $title);
        $stmt->execute();
        $importId = $stmt->insert_id;


        foreach($books as $book){
            $stmt = $db->prepare('INSERT INTO import_item(import_id, book_id, quantity,stock,after_stock) VALUES(?,?,0,?,?)');
            $stmt->bind_param('iiii', $importId, $book['book_id'], $book['stock'],$book['stock']);
            $stmt->execute();
        }

        return $importId;

    }

    public function deleteImportById($importId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT * FROM import_item WHERE import_id =?');
        $stmt->bind_param('i', $importId);
        $stmt->execute();

        $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach($items as $item){
            $stmt = $db->prepare('UPDATE books set stock = stock - ? WHERE book_id =?');
            $stmt->bind_param('ii',$item['quantity'],$item['book_id'] );
            $stmt->execute();
        }
        
        $stmt = $db->prepare('DELETE FROM import_item WHERE import_id =?');
        $stmt->bind_param('i', $importId);
        $stmt->execute();

        $stmt = $db->prepare('DELETE FROM import WHERE id =?');
        $stmt->bind_param('i', $importId);
        $stmt->execute();
    }

    public function findImportDetailByBookIdAndImportId($bookId, $importId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT * FROM import_item WHERE book_id =? AND import_id =?');
        $stmt->bind_param('ii', $bookId, $importId);
        $stmt->execute();

        $book = $stmt->get_result()->fetch_assoc();

        return $book;
    }

    public function updateImportDetail($newAfterStock,$newQuantity,$bookId,$importId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('UPDATE import_item SET after_stock =?, quantity =? WHERE book_id =? AND import_id =?');
        $stmt->bind_param('iiii', $newAfterStock, $newQuantity, $bookId, $importId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function updateQuantityInventory($quantity,$importId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('UPDATE import SET quantity = quantity + ? WHERE id =?');
        $stmt->bind_param('ii', $quantity, $importId);
        $stmt->execute();
    }

    public function updateStatusImport($importId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare("UPDATE import SET status = 1 WHERE id = ?");
        $stmt ->bind_param("i", $importId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function addImportDetail($bookId,$importId,$quantity,$stock,$afterStock){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('INSERT INTO import_item (book_id, import_id, quantity, stock, after_stock) VALUES (?,?,?,?,?)');
        $stmt->bind_param('iiiii', $bookId, $importId, $quantity, $stock, $afterStock);
        $stmt->execute();

        
    }
}





