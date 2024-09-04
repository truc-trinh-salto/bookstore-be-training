<?php

namespace MVC\Models;
use DBConfig;

// require_once('../database.php');

Class Category {
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

    public function getAllCategories() {
        $db = DBConfig::getDB();
        $stmt = $db->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getInfinityCategories() {
        $db = DBConfig::getDB();
        $stmt = $db->prepare('SELECT c.category_id, c.name_category,b.total_books  FROM categories as c
                                LEFT JOIN (SELECT COUNT(*) as total_books,category_id FROM books GROUP BY category_id) as b
                                ON b.category_id = c.category_id  
                                WHERE b.total_books > 0 
                                limit 1');
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function findByCategoryId($categoryId) {
        $db = DBConfig::getDB();
        $stmt = $db->prepare("SELECT * FROM categories WHERE category_id =?");
        $stmt->bind_param('i', $categoryId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findCategoryExistence($categoryName){
        $db = DBConfig::getDB();
        $stmt = $db->prepare('SELECT * FROM categories WHERE LOWER(name_category) =?');
        $stmt->bind_param('s', strtolower($categoryName));
        $stmt->execute();

        $category_select = $stmt->get_result()->fetch_assoc();
        if($category_select){
            return $category_select['category_id'];
        } else {
            $stmt = $db->prepare('INSERT INTO categories (name_category) VALUES (?)');
            $stmt->bind_param('s', $categoryName);
            $stmt->execute();
            return $db->insert_id;
        }
    }

    public function getNumberPageOfCategoryManagementPage($searchKeyword,$limit){
        $db = DBConfig::getDB();
        if($searchKeyword != null){
            $search_keyword = $searchKeyword;
            $search = "%$search_keyword%";
            $stmt = $db->prepare('SELECT * FROM categories where name_category LIKE ?');
            $stmt->bind_param('s', $search);
        } else {
            $stmt = $db->prepare('SELECT * FROM categories');
        }

        $stmt->execute();

        $number_result = $stmt->get_result()->num_rows;
        $number_page = ceil($number_result / $limit);
        return $number_page;
    }

    public function getAllByCategoryPagination($searchKeyword,$page, $limit){
        $db = DBConfig::getDB();

        $page_first = ($page - 1) * $limit;

        if($searchKeyword != null){
            $search_keyword = $searchKeyword;
            $search = "%$search_keyword%";
            $stmt = $db->prepare('SELECT * FROM categories where name_category LIKE ? LIMIT ?,?');
            $stmt->bind_param('sii', $search,$page_first,$limit);
        } else {
            $stmt = $db->prepare('SELECT * FROM categories LIMIT ?,?');
            $stmt->bind_param("ii", $page_first, $limit);
        }
;
        $stmt->execute();
        $categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $categories;
    }

    public function findTotalBookOfCategoryById($categoryId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT COUNT(*) as total FROM books WHERE category_id = ?');
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        
        return $total = $stmt->get_result()->fetch_assoc();
    }

    public function addNewCategory($categoryName){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('INSERT INTO categories (name_category) values (?)');
        $stmt->bind_param('s', $categoryName);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function checkExistenceCategory($categoryName){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT * FROM categories WHERE LOWER(name_category) =?');
        $stmt->bind_param('s', strtolower($categoryName));
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function deleteById($categoryId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('DELETE FROM categories WHERE category_id =?');
        $stmt->bind_param('i', $categoryId);
        $stmt->execute();
        
        return $stmt->affected_rows > 0;
    }

    public function updateCategory($categoryId,$categoryName){
        $db = DBConfig::getDB();
        
        $stmt = $db->prepare('UPDATE categories set name_category =? WHERE category_id=?');
        $stmt->bind_param('ss', $categoryName, $categoryId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }
}





