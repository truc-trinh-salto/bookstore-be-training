<?php

namespace MVC\Models;
use DBConfig;

// require_once('../database.php');

Class Branch {
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

    public function getAllBranchesByBookId($bookId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT br.branch_id, br.title, br.address, br.hotline, br.image, brst.status,brst.branch_select FROM branch as br
                            LEFT JOIN branchstockitem as brst
                            ON br.branch_id = brst.branch_id
                            WHERE brst.book_id = ?');

                            
        $stmt->bind_param('i', $bookId);
        $stmt->execute();

        $branches = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $branches;
    }

    public function getAll(){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT * FROM branch');
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateBranchSelect($bookId,$branchId){
        $db = DBConfig::getDB();

        $stmt1 = $db->prepare("UPDATE branchstockitem SET branch_select = 0 where book_id = ?");
        $stmt1->bind_param('i',$bookId);
        $stmt1->execute();

        $stmt = $db->prepare("UPDATE branchstockitem SET branch_select = 1 where book_id = ? and branch_id = ?");
        $stmt->bind_param('ii',$bookId,$branchId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function updateBranchStock($bookId,$branchId,$action){
        $db = DBConfig::getDB();
        $stmt = $db->prepare('UPDATE branchstockitem SET status =? WHERE book_id =? AND branch_id =?');
        $stmt->bind_param('iii', $action, $bookId, $branchId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function getAllByManagementPage($searchKeyword){
        $db = DBConfig::getDB();
        if($searchKeyword != null) {
            $search_keyword = $searchKeyword;
            $search = "%$search_keyword%";
            $stmt = $db->prepare('SELECT * FROM branch WHERE title LIKE ? OR address LIKE ?');
            $stmt->bind_param("ss",$search, $search);
            
        } else {
            $stmt = $db->prepare('SELECT * FROM branch');
        }
        $stmt->execute();
        $branches = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $branches;
    }

    public function checkExistence($name){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT * FROM branch WHERE LOWER(title) =?');
        $stmt->bind_param('s', strtolower($name));
        $stmt->execute();

        $result = $stmt->get_result();
        
        return $result->num_rows > 0;
    }

    public function checkExistenceById($branchId,$name){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT * FROM branch WHERE LOWER(title) =? and branch_id != ?');
        $stmt->bind_param('si', strtolower($name),$branchId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }


    public function addBranch($name, $address, $hotline, $image){
        $db = DBConfig::getDB();
    
        if($image == '' || $image == null) {
            $image = 'public/assets/img/default.png';
        }
        $stmt = $db->prepare('INSERT INTO branch (title, address, hotline, image) values (?,?,?,?)');
        $stmt->bind_param('ssss', $name, $address, $hotline, $image);
        $stmt->execute();
        $branchId = $stmt->insert_id;
        if($stmt->affected_rows > 0)
        {
            $stmt = $db->prepare('SELECT * FROM books');
            $stmt->execute();
            $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            foreach($books as $book){
                $stmt = $db->prepare('INSERT INTO branchstockitem (book_id, branch_id,status,branch_select) values (?,?,1,0)');
                $stmt->bind_param('ii', $book['book_id'], $branchId);
                $stmt->execute();
            }
            return true;
        }
        else
        {
            return false;
        }

    }

    public function updateBranch($branchId,$name, $address, $hotline, $target_file){

        $db = DBConfig::getDB();

        if($target_file == '' || $target_file == null){
            $branch_image = 'public/assets/img/default.png';
        }


        $stmt = $db->prepare('UPDATE branch set title = ?, address =?, hotline =?, image =? WHERE branch_id =?');
        $stmt->bind_param('ssssi', $name, $address, $hotline, $branch_image, $branchId);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            return true;
        } else {
            return false;
        }
    }

    public function deleteById($branchId){
        $db = DBConfig::getDB();
        $stmt = $db->prepare('DELETE FROM branchstockitem WHERE branch_id =?');
        $stmt->bind_param('i', $branchId);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $stmt = $db->prepare('DELETE FROM branch WHERE branch_id =?');
            $stmt->bind_param('i', $branchId);
            $stmt->execute();
            return true;
        } else {
            return false;
        }
    }

    public function findById($branchId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT * FROM branch WHERE branch_id =?');
        $stmt->bind_param('i', $branchId);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }


}





