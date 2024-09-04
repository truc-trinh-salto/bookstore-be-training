<?php

namespace MVC\Models;
use DBConfig;

// require_once('../database.php');
session_start();

Class Book {
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

    public function getAllBooks() {
        $db = DBConfig::getDB();
        $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category
                                FROM books as b 
                                LEFT JOIN categories as c 
                                ON b.category_id = c.category_id 
                                ORDER BY b.book_id');
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    

    public function findByCategoryIdForInfinity($categoryId) {
        $db = DBConfig::getDB();
        $stmt = $db->prepare("SELECT * FROM books WHERE category_id =?
                                 LIMIT 8");
        $stmt->bind_param('i', $categoryId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($bookId) {
        $db = DBConfig::getDB();
        $stmt = $db->prepare('SELECT b.title, b.book_id, b.description, b.category_id, b.price, 
                                    b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category
                                    FROM books as b 
                                    LEFT JOIN categories as c 
                                    ON b.category_id = c.category_id
                                    WHERE b.book_id = ?
                                    ORDER BY b.book_id ASC');
        $stmt->bind_param('i', $bookId);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }


    public function getAllInCart($cart){
        $db = DBConfig::getDB();
        $stmt = $db->prepare("SELECT * FROM books WHERE book_id IN (".implode(',',$_SESSION['cart']).")");
        $stmt->execute();
        $result = $stmt->get_result();
        if($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function getMoreBooksForInfinity($lastID, $limit) {
        $db = DBConfig::getDB();

        $results = [];

        $stmt = $db->prepare('SELECT c.category_id, c.name_category,b.total_books  FROM categories as c
        LEFT JOIN (SELECT COUNT(*) as total_books,category_id FROM books GROUP BY category_id) as b
        ON b.category_id = c.category_id  
        WHERE b.total_books > 0 AND c.category_id > ? ORDER BY c.category_id ASC');
        $stmt->bind_param('i', $lastID);
        $stmt->execute();

        $results[] = $stmt->get_result()->num_rows;

        $stmt = $db->prepare('SELECT c.category_id, c.name_category,b.total_books  FROM categories as c
                LEFT JOIN (SELECT COUNT(*) as total_books,category_id FROM books GROUP BY category_id) as b
                ON b.category_id = c.category_id  
                WHERE b.total_books > 0 AND c.category_id > ? ORDER BY c.category_id ASC LIMIT ?');
        $stmt->bind_param('ii', $lastID, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $results[] = $result->num_rows;

        $results[] = $result->fetch_all(MYSQLI_ASSOC);

        return $results;
    }

    public function getByCategoryPagination($category_id, $minprice, $maxprice, $page){
        $db = DBConfig::getDB();
        $limit = 6;
        $page_first = ($page - 1) * $limit;
        $query = 'SELECT * FROM books WHERE category_id = ?';
     
        if ($minprice !== null || $maxprice !== null) {
            $query .= ' AND price >= ?';
            if ($maxprice !== null) {
                $query .= ' AND price <= ?';
            }
        }

        $query .= ' LIMIT ?,?';
        $stmt = $db->prepare($query);

        if ($minprice !== null && $maxprice !== null) {
            $stmt->bind_param('idddi', $category_id, $minprice, $maxprice, $page_first, $limit);
        } elseif ($minprice !== null) {
            $stmt->bind_param('iddi', $category_id, $minprice, $page_first, $limit);
        } elseif ($maxprice !== null) {
            $stmt->bind_param('idii', $category_id, $maxprice, $page_first, $limit);
        } else {
            $stmt->bind_param('iii', $category_id, $page_first, $limit);
        }


        $stmt->execute();
        $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $books;
    }

    public function getByFilterPagination($search_keyword, $minprice, $maxprice, $page){

        $db = DBConfig::getDB();
        $limit = 6;
        $search = "%$search_keyword%";
        $page_first = ($page - 1) * $limit;
        $query = 'SELECT * FROM books WHERE (title LIKE ? OR authors LIKE ? OR description LIKE ?)';
     
        if ($minprice !== null || $maxprice !== null) {
            $query .= ' AND price >= ?';
            if ($maxprice !== null) {
                $query .= ' AND price <= ?';
            }
        }

        $query .= ' LIMIT ?,?';
        $stmt = $db->prepare($query);

        if ($minprice !== null && $maxprice !== null) {
            $stmt->bind_param('sssdddi', $search,$search,$search, $minprice, $maxprice, $page_first, $limit);
        } elseif ($minprice !== null) {
            $stmt->bind_param('sssddi', $search,$search,$search, $minprice, $page_first, $limit);
        } elseif ($maxprice !== null) {
            $stmt->bind_param('sssdii', $search,$search,$search, $maxprice, $page_first, $limit);
        } else {
            $stmt->bind_param('sssii', $search,$search,$search, $page_first, $limit);
        }


        $stmt->execute();
        $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $books;
    }

    public function getNumberPageOfCategoryPage($category_id, $minprice, $maxprice, $limit){
        $db = DBConfig::getDB();
        if($minprice != null && $maxprice != null){
            $stmt = $db->prepare('SELECT * FROM books WHERE category_id = ? AND price >=? AND price <=?');
            $stmt->bind_param('idd',$category_id, $minprice, $maxprice);
        } else if($minprice == null && $maxprice != null) {
            $stmt = $db->prepare('SELECT * FROM books WHERE category_id = ? AND price <=?');
            $stmt->bind_param('id', $category_id,$maxprice);
        } else if($minprice =! null && $maxprice == null) {
            $stmt = $db->prepare('SELECT * FROM books WHERE category_id = ? AND price >=?');
            $stmt->bind_param('id', $category_id, $minprice);
        } else {
            $stmt = $db->prepare('SELECT * FROM books where category_id = ?');
            $stmt->bind_param("i", $category_id);
        }
        
        $stmt->execute();
    
        $number_result  = $stmt->get_result()->num_rows;
    
        $number_page = ceil($number_result/ $limit);

        return $number_page;
    }

    public function getNumberPageOfFilterPage($search_keyword, $minprice, $maxprice, $limit){
        $db = DBConfig::getDB();
        $search = "%$search_keyword%";

        if($minprice != null && $maxprice != null){
            $stmt = $db->prepare('SELECT * FROM books
                                    WHERE (title LIKE ? OR authors LIKE ? OR description LIKE ?)
                                    AND price >=? AND price <=?');
            $stmt->bind_param('sssdd', $search, $search, $search,$minprice, $maxprice); 
        } else if($minprice == null && $maxprice != null) {
            $stmt = $db->prepare('SELECT * FROM books 
                                        WHERE (title LIKE ? OR authors LIKE ? OR description LIKE ?)
                                        AND price <= ?');
            $stmt->bind_param('sssd', $search, $search, $search,$maxprice);
        } else if($minprice =! null && $maxprice == null) {
            $stmt = $db->prepare('SELECT * FROM books WHERE (title LIKE ? OR authors LIKE ? OR description LIKE ?) AND price >=?');
            $stmt->bind_param('sssd', $search, $search, $search, $minprice);
        } else {
            $stmt = $db->prepare('SELECT * FROM books WHERE title LIKE ? OR authors LIKE ? OR description LIKE ?');
            $stmt->bind_param("sss", $search, $search, $search);
        }

        $stmt->execute();

        $number_result  = $stmt->get_result()->num_rows;

        $number_page = ceil($number_result/ $limit);

        return $number_page;
    }

    public function getNumberPageOfProductManagementPage($searchKeyword, $limit){
        $db = DBConfig::getDB();

        if($searchKeyword != null){
            $search_keyword = $searchKeyword;
            $search = "%$search_keyword%";
            $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category
                                        FROM books as b 
                                        LEFT JOIN categories as c 
                                        ON b.category_id = c.category_id
                                        WHERE b.title LIKE ? OR b.authors LIKE ? OR b.description LIKE ? OR c.name_category LIKE ?
                                        ORDER BY b.book_id ASC');
            $stmt->bind_param("ssss",$search, $search, $search, $search);
        } else {
            $stmt = $db->prepare("SELECT * FROM books");
        }
    
        $stmt->execute();
    
        $number_result  = $stmt->get_result()->num_rows;
    
        $number_page = ceil($number_result/ $limit);

        return $number_page;
    }

    public function getByProductManagmentPagination($searchKeyword,$page,$limit){
        $db = DBConfig::getDB();

        $page_first = ($page - 1) * $limit;

        if($searchKeyword != null) {
            $search_keyword = $searchKeyword;
            $search = "%$search_keyword%";
            $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category
                                        FROM books as b 
                                        LEFT JOIN categories as c 
                                        ON b.category_id = c.category_id
                                        WHERE b.title LIKE ? OR b.authors LIKE ? OR b.description LIKE ? OR c.name_category LIKE ?
                                        ORDER BY b.book_id DESC LIMIT ?,?');
            $stmt->bind_param("ssssii",$search, $search, $search, $search,$page_first,$limit);
            
        } else {
            $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category
                                        FROM books as b 
                                        LEFT JOIN categories as c 
                                        ON b.category_id = c.category_id
                                        ORDER BY b.book_id DESC LIMIT ?,?');
            $stmt->bind_param('ii',$page_first,$limit);
        }
        $stmt->execute();
        $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $books;
    }

    public function updateStockOfBook($bookId, $stock){
        $db = DBConfig::getDB();
    
        $stmt2 = $db->prepare("UPDATE books SET stock = stock - ? WHERE book_id =?");
        $stmt2->bind_param('ii', $stock, $bookId);
        $stmt2->execute();
    }

    public function updateStockForInventory($bookId,$stock){
        $db = DBConfig::getDB();
    
        $stmt2 = $db->prepare("UPDATE books SET stock = ? WHERE book_id =?");
        $stmt2->bind_param('ii', $stock, $bookId);
        $stmt2->execute();
    }


    public function getAllHotItem($bookId){
        $db = DBConfig::getDB();
        //SET CURRENT MONTH FOR HOT ITEM
        $timestamp = strtotime(date('Y-m-d'));
        $dateFrom = date('Y-m-01 00:00:00', $timestamp);
        $dateTo  = date('Y-m-t 23:59:59', $timestamp);

        $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category, 
                                        tt.total
                                        FROM books as b 
                                        LEFT JOIN categories as c 
                                        ON b.category_id = c.category_id
                                        LEFT JOIN (SELECT SUM(od.quantity)as total, od.book_id
                                                    FROM order_detail as od 
                                                    LEFT JOIN order_item as oi
                                                    ON od.order_id = oi.id
                                                    LEFT JOIN transactions as t
                                                    on t.order_id = oi.id 
                                                    WHERE t.createdAt >= ? and t.createdAt <= ?
                                                    GROUP BY od.book_id) as tt
                                        ON tt.book_id = b.book_id
                                        WHERE b.book_id != ?
                                        ORDER BY total DESC LIMIT 5');
        $stmt->bind_param('ssi',$dateFrom, $dateTo, $bookId);
        $stmt->execute();

        $books_hot = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $books_hot;
    }

    public function getAllSameCategoryItem($bookId,$categoryId){
        $db = DBConfig::getDB();
        $stmt = $db->prepare('SELECT * FROM books
                                    WHERE category_id = ? and book_id != ? 
                                    ORDER BY RAND() LIMIT 5');
        $stmt->bind_param('ii', $categoryId,$bookId);

        $stmt->execute();

        $books_same_type = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $books_same_type;
    }


    public function checkExistenceBook($name){
        $db = DBConfig::getDB();

        $stmt = $db->prepare("SELECT * FROM books WHERE LOWER(title) =?");
        $stmt->bind_param("s", strtolower($name));
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc() > 0;
    }

    public function checkExistencById($bookId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare("SELECT * FROM books WHERE book_id =?");
        $stmt->bind_param("s", strtolower($bookId));
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc() > 0;
    }

    public function checkExistenceBookById($name,$bookId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare("SELECT * FROM books WHERE LOWER(title) =? AND book_id !=?");
        $stmt->bind_param("si", strtolower($name), $bookId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc() > 0;
    }

    public function addNewBook($name, $quantity, $price, $hotItem, $categoryId, $authors, $description, $sale){
        $db = DBConfig::getDB();

        if(!$sale){
            $sale = 0;
        }
        $stmt = $db->prepare('INSERT INTO books (title, stock, price, hotItem, category_id, authors, description, created_at, sale) values (?,?,?,?,?,?,?,NOW(),?)');
        $stmt->bind_param('sidiissd', $name, $quantity, $price, $hotItem, $categoryId, $authors, $description, $sale);
        $stmt->execute();

        $book_id = $stmt->insert_id;

        $stmt = $db->prepare('SELECT * FROM branch');
        $stmt->execute();
        $branches = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach($branches as $branch){
            $stmt = $db->prepare('INSERT INTO branchstockitem (book_id, branch_id, status,branch_select) values (?,?,1,0)');
            $stmt->bind_param('ii', $book_id, $branch['branch_id']);
            $stmt->execute();
        }
 
        return $book_id;
    }

    public function updateBook($name,$quantity,$price,$hotItem,$categoryId,$authors,$description,$sale,$bookId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('UPDATE books SET title=?, stock =? , price =?, hotItem=?, category_id=?, authors=?, description=?, updated_at=NOW(), sale=? WHERE book_id=?');
        $stmt->bind_param('sidiissdi', $name, $quantity, $price, $hotItem, $categoryId, $authors, $description,$sale,$bookId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function findByName($name){
        $stmt = DBConfig::getDB()->prepare('SELECT * FROM books WHERE LOWER(title) =?');
        $stmt->bind_param('s', strtolower($name));
        $stmt->execute();

        $book = $stmt->get_result()->fetch_assoc();

        return $book;
    }

    public function deleteById($bookId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('DELETE FROM gallery_image WHERE book_id =?');
        $stmt->bind_param('i', $bookId);
        $stmt->execute();

        $stmt = $db->prepare('DELETE FROM branchstockitem WHERE book_id =?');
        $stmt->bind_param('i', $bookId);
        $stmt->execute();

        $stmt = $db->prepare('DELETE FROM books WHERE book_id =?');
        $stmt->bind_param('i', $bookId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function getNumberPageOfHotItemManagementPage($searchKeyword, $limit){
        $db = DBConfig::getDB();
        if($searchKeyword != null){
            $search_keyword = $searchKeyword;
            $search = "%$search_keyword%";
            $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category
                                        FROM books as b 
                                        LEFT JOIN categories as c 
                                        ON b.category_id = c.category_id
                                        WHERE b.title LIKE ? OR b.authors LIKE ? OR b.description LIKE ? OR c.name_category LIKE ?
                                        ORDER BY b.book_id DESC');
            $stmt->bind_param("ssss",$search, $search, $search, $search);
        } else {
            $stmt = $db->prepare('SELECT * FROM books');
        }
        $stmt->execute();

        $number_result  = $stmt->get_result()->num_rows;

        $number_page = ceil($number_result/ $limit);

        return $number_page;

    }

    public function getAllByHotItemPagination($searchKeyword,$page,$limit,$dateTo,$dateFrom,$importId){
        $db = DBConfig::getDB();
        $page_first = ($page - 1) * $limit;
        if($searchKeyword != null) {

            $search_keyword = $searchKeyword;
            $search = "%$search_keyword%";

            $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category, 
                                        tt.total, s.after_stock
                                        FROM books as b 
                                        LEFT JOIN categories as c 
                                        ON b.category_id = c.category_id
                                        LEFT JOIN (SELECT SUM(od.quantity)as total, od.book_id
                                                    FROM order_detail as od 
                                                    LEFT JOIN order_item as oi
                                                    ON od.order_id = oi.id
                                                    LEFT JOIN transactions as t
                                                    on t.order_id = oi.id 
                                                    WHERE t.createdAt >= ? and t.createdAt <= ?
                                                    GROUP BY od.book_id) as tt
                                        ON tt.book_id = b.book_id

                                        LEFT JOIN (SELECT ii.book_id, ii.stock + si.sum_quantity as after_stock
                                                    FROM import_item as ii
                                                    LEFT JOIN (SELECT ii2.book_id, SUM(ii2.quantity) as sum_quantity
                                                                FROM import_item as ii2
                                                                LEFT JOIN import as i2
                                                                ON i2.id = ii2.import_id
                                                                WHERE YEAR(i2.import) = YEAR(?) and MONTH(i2.import) = MONTH(?)
                                                                GROUP BY ii2.book_id) as si
                                                    on si.book_id = ii.book_id
                                                    WHERE ii.import_id = ?
                                                    ) as s
                                        ON s.book_id = b.book_id

                                        WHERE b.title LIKE ? OR b.authors LIKE ? OR b.description LIKE ? OR c.name_category LIKE ? 
                                        ORDER BY total DESC LIMIT ?,?');
            $stmt->bind_param("ssssissssii",$dateFrom,$dateTo,$dateFrom,$dateFrom,$importId,$search, $search, $search, $search, $page_first,$limit);
            
        } else {
            $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category, 
                                        tt.total, s.after_stock
                                        FROM books as b 
                                        LEFT JOIN categories as c 
                                        ON b.category_id = c.category_id
                                        LEFT JOIN (SELECT SUM(od.quantity)as total, od.book_id
                                                    FROM order_detail as od 
                                                    LEFT JOIN order_item as oi
                                                    ON od.order_id = oi.id
                                                    LEFT JOIN transactions as t
                                                    on t.order_id = oi.id 
                                                    WHERE t.createdAt >= ? and t.createdAt <= ?
                                                    GROUP BY od.book_id) as tt
                                        ON tt.book_id = b.book_id

                                        LEFT JOIN (SELECT ii.book_id, ii.stock + si.sum_quantity as after_stock
                                                    FROM import_item as ii
                                                    LEFT JOIN (SELECT ii2.book_id, SUM(ii2.quantity) as sum_quantity
                                                                FROM import_item as ii2
                                                                LEFT JOIN import as i2
                                                                ON i2.id = ii2.import_id
                                                                WHERE YEAR(i2.import) = YEAR(?) and MONTH(i2.import) = MONTH(?)
                                                                GROUP BY ii2.book_id) as si
                                                    on si.book_id = ii.book_id
                                                    WHERE ii.import_id = ?
                                                    ) as s
                                        ON s.book_id = b.book_id
                                        ORDER BY total DESC LIMIT ?,?');
            $stmt->bind_param('ssssiii',$dateFrom,$dateTo,$dateFrom,$dateFrom,$importId,$page_first,$limit);
        }
        $stmt->execute();
        $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $books;
    }

    public function getAllHotItemsInMonth($dateTo, $dateFrom){
        $db = DBConfig::getDB();
        $stmt = $db->prepare('SELECT b.title, b.book_id, b.stock, b.authors, c.name_category, b.price, tt.total
                                FROM books as b 
                                LEFT JOIN categories as c 
                                ON b.category_id = c.category_id
                                LEFT JOIN (SELECT SUM(od.quantity) as total, od.book_id
                                        FROM order_detail as od 
                                        LEFT JOIN order_item as oi
                                        ON od.order_id = oi.id
                                        LEFT JOIN transactions as t
                                        ON t.order_id = oi.id 
                                        WHERE t.createdAt >= ? and t.createdAt <= ?
                                        GROUP BY od.book_id) as tt
                                ON tt.book_id = b.book_id
                                ORDER BY total DESC');
        $stmt->bind_param('ss', $dateFrom, $dateTo);
        $stmt->execute();

        $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $books;
    }

    public function getNumberPageOfDetailCategoryManagmentPage($categoryId,$searchKeyword,$limit){
        $db = DBConfig::getDB();

        if($searchKeyword!= null) {
            $search_keyword = $searchKeyword;
            $search = "%$search_keyword%";
            $stmt = $db->prepare('SELECT b.book_id, b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category
                                        FROM books as b 
                                        LEFT JOIN categories as c 
                                        ON b.category_id = c.category_id
                                        WHERE (b.title LIKE ? OR b.authors LIKE ? OR b.description LIKE ? OR c.name_category LIKE ?) 
                                        AND b.category_id =?
                                        ORDER BY b.book_id ASC');
            $stmt->bind_param("ssssi",$search, $search, $search, $search,$categoryId);
            
        } else {
            $stmt = $db->prepare("SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category
                                        FROM books as b 
                                        LEFT JOIN categories as c 
                                        ON b.category_id = c.category_id
                                        WHERE b.category_id =? 
                                        ORDER BY b.book_id ASC");
            $stmt->bind_param('i',$categoryId);
        }
    
    
    
        $stmt->execute();
    
        $number_result  = $stmt->get_result()->num_rows;
    
        $number_page = ceil($number_result/ $limit);

        return $number_page;
    }

    public function getAllByDetailCategoryManagementPage($categoryId,$searchKeyword,$page,$limit){
        $db = DBConfig::getDB();
    
        $page_first = ($page - 1) * $limit;

        if($searchKeyword != null) {
            $search_keyword = $searchKeyword;
            $search = "%$search_keyword%";
            $stmt = $db->prepare('SELECT b.book_id, b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category
                                        FROM books as b 
                                        LEFT JOIN categories as c 
                                        ON b.category_id = c.category_id
                                        WHERE (b.title LIKE ? OR b.authors LIKE ? OR b.description LIKE ? OR c.name_category LIKE ?) 
                                        AND b.category_id =?
                                        ORDER BY b.book_id ASC LIMIT?,?');
            $stmt->bind_param("ssssiii",$search, $search, $search, $search,$categoryId,$page_first, $limit);
        } else {
            $stmt = $db->prepare('SELECT b.book_id, b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category
                                        FROM books as b 
                                        LEFT JOIN categories as c 
                                        ON b.category_id = c.category_id
                                        WHERE b.category_id =? 
                                        ORDER BY b.book_id ASC LIMIT?,?');
            $stmt->bind_param('iii', $categoryId,$page_first, $limit);
        }
        $stmt->execute();
        $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $books;
    }

    public function getNumberPageOfDetailBranchManagementPage($branchId,$searchKeyword,$limit){
        $db = DBConfig::getDB();

        if($searchKeyword != null) {
            $search_keyword = $searchKeyword;
            $search = "%$search_keyword%";
            $stmt = $db->prepare('SELECT b.book_id, b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category, br.status, br.branch_id, br.branch_select
                                        FROM books as b 
                                        LEFT JOIN branchstockitem as br ON b.book_id = br.book_id 
                                        LEFT JOIN categories as c ON b.category_id = c.category_id
                                        WHERE (b.title LIKE ? OR b.authors LIKE ? OR b.description LIKE ? OR c.name_category LIKE ?)
                                        AND br.branch_id = ?
                                        ORDER BY b.book_id ASC');
            $stmt->bind_param("ssssi",$search, $search, $search, $search, $branchId);
            
        } else {
            $stmt = $db->prepare("SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category, br.status, br.branch_id, br.branch_select
                                        FROM books as b 
                                        LEFT JOIN branchstockitem as br ON b.book_id = br.book_id 
                                        LEFT JOIN categories as c ON b.category_id = c.category_id
                                        WHERE br.branch_id =?
                                        ORDER BY b.book_id ASC");
            $stmt->bind_param('i',$branchId);
        }

        $stmt->execute();
    
        $number_result  = $stmt->get_result()->num_rows;
    
        $number_page = ceil($number_result/ $limit);

        return $number_page;
    }

    public function getAllByDetailBranchManagementPage($branchId,$searchKeyword,$page,$limit){
        $db = DBConfig::getDB();
    
        $page_first = ($page - 1) * $limit;

        if($searchKeyword != null) {
            $search_keyword = $searchKeyword;
            $search = "%$search_keyword%";
            $stmt = $db->prepare('SELECT b.book_id, b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category, br.status, br.branch_id, br.branch_select
                                        FROM books as b 
                                        LEFT JOIN branchstockitem as br ON b.book_id = br.book_id 
                                        LEFT JOIN categories as c ON b.category_id = c.category_id
                                        WHERE (b.title LIKE ? OR b.authors LIKE ? OR b.description LIKE ? OR c.name_category LIKE ?)
                                        AND br.branch_id = ?
                                        ORDER BY b.book_id ASC LIMIT ?,?');
            $stmt->bind_param("ssssiii",$search, $search, $search, $search, $branchId,$page_first, $limit);
            
        } else {
            $stmt = $db->prepare('SELECT b.book_id,b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category, br.status, br.branch_id, br.branch_select
                                        FROM books as b 
                                        LEFT JOIN branchstockitem as br ON b.book_id = br.book_id 
                                        LEFT JOIN categories as c ON b.category_id = c.category_id
                                        WHERE br.branch_id =?
                                        ORDER BY b.book_id ASC LIMIT ?,?');
            $stmt->bind_param('iii', $branchId,$page_first, $limit);
        }
        $stmt->execute();
        $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $books;
    }

    public function getNumberPageOfDetailInventoryManagementPage($importId,$searchKeyword,$limit){
        $db = DBConfig::getDB();

        if($searchKeyword != null){
            $search_keyword = $searchKeyword;
            $search = "%$search_keyword%";
            $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category, i.quantity, i.stock as before_import
                                        FROM books as b 
                                        LEFT JOIN categories as c 
                                        ON b.category_id = c.category_id
                                        LEFT JOIN import_item as i
                                        ON b.book_id = i.book_id
                                        WHERE (b.title LIKE ? OR b.authors LIKE ? OR b.description LIKE ? OR c.name_category LIKE ?) AND i.import_id =?
                                        ORDER BY b.book_id ASC');
            $stmt->bind_param("ssssi",$search, $search, $search, $search, $importId);
        } else {
            $stmt = $db->prepare("SELECT * FROM books as b
                                    LEFT JOIN import_item as i
                                    on b.book_id = i.book_id
                                    WHERE i.import_id =?");
            $stmt->bind_param("i", $importId);
        }
    
        $stmt->execute();
    
        $number_result  = $stmt->get_result()->num_rows;
    
        $number_page = ceil($number_result/ $limit);

        return $number_page;
    }

    public function getAllByDetailInventoryManagementPagination($importId,$searchKeyword,$page,$limit){
        $db = DBConfig::getDB();

        $page_first = ($page - 1) * $limit;


        if($searchKeyword != null) {
            $search_keyword = $searchKeyword;
            $search = "%$search_keyword%";
            $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category, i.quantity, i.stock as before_import, i.after_stock
                                        FROM books as b 
                                        LEFT JOIN categories as c 
                                        ON b.category_id = c.category_id
                                        LEFT JOIN import_item as i
                                        ON b.book_id = i.book_id
                                        WHERE (b.title LIKE ? OR b.authors LIKE ? OR b.description LIKE ? OR c.name_category LIKE ?) AND i.import_id =?
                                        ORDER BY b.book_id ASC LIMIT ?,?');
            $stmt->bind_param("ssssiii",$search, $search, $search, $search,$importId,$page_first,$limit);
            
        } else {
            $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category, i.quantity, i.stock as before_import, i.after_stock
                                        FROM books as b 
                                        LEFT JOIN categories as c 
                                        ON b.category_id = c.category_id
                                        LEFT JOIN import_item as i
                                        ON b.book_id = i.book_id
                                        WHERE i.import_id =? 
                                        ORDER BY b.book_id ASC LIMIT ?,?');
            $stmt->bind_param('iii',$importId,$page_first,$limit);
        }
        $stmt->execute();

        $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $books;
    }

    public function getAllForImportByImportId($importId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category, i.quantity, i.stock as before_import, i.after_stock
                FROM books as b 
                LEFT JOIN categories as c 
                ON b.category_id = c.category_id
                LEFT JOIN import_item as i
                ON b.book_id = i.book_id
                WHERE i.import_id =? 
                ORDER BY b.book_id');
        $stmt->bind_param('i',$importId);
        $stmt->execute();

        $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $books;
    }

}







