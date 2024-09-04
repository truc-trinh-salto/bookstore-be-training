<?php

namespace MVC\Models;
use DBConfig;

// require_once('../database.php');

Class GalleryImage {
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

    public function findShowByBookId($bookId) {
        $db = DBConfig::getDB();
        $stmt = $db->prepare('SELECT * FROM gallery_image WHERE book_id =? and isShow = 1');
        $stmt->bind_param('i', $bookId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();;
    }

    public function getImageBooks($books){
        $result = [];
        foreach($books as $book) {
            $gallery = $this->findShowByBookId($book['book_id']);
            $book['address'] = $gallery['address'];
            $result[] = $book;
        }

        return $result;
    }

    public function getAllImagesByBookId($bookId) {
        $db = DBConfig::getDB();
        $stmt = $db->prepare("SELECT * FROM gallery_image WHERE book_id=?");
        $stmt->bind_param("i", $bookId);
        $stmt->execute();
        $images = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $images;
    }

    public function findDefaultImageByBookId($bookId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT * FROM gallery_image WHERE book_id =? and isShow = 1');
                                            $stmt->bind_param('i', $bookId);
                                            $stmt->execute();

        $image_current = $stmt->get_result()->fetch_assoc();

        return $image_current;
    }

    public function addNewGalleryOfBook($image,$bookId,$isShow){
        $db = DBConfig::getDB();

        $stmt = $db->prepare("INSERT INTO gallery_image(address,book_id,isShow) values(?,?,?)");
                        $stmt->bind_param("sii", $image, $bookId, $isShow);
                        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function updateDefaultGalleryOfBook($bookId,$imageId){
        $db = DBConfig::getDB();
        $stmt = $db->prepare('UPDATE gallery_image SET isShow = 0 WHERE book_id=?');
        $stmt->bind_param('i', $bookId);
        $stmt->execute();

        $stmt = $db->prepare('UPDATE gallery_image SET isShow = 1 WHERE image_id=?');
        $stmt->bind_param('i', $imageId);
        $stmt->execute();
    }

    public function getNumberPageOfGalleryPage($bookId, $limit){
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT * FROM gallery_image where book_id = ?');
        $stmt->bind_param('i', $bookId);
        $stmt->execute();
    
        $number_result = $stmt->get_result()->num_rows;

        $number_page = ceil($number_result / $limit);

        return $number_page;
    }

    public function getAllByGalleryPagination($bookId,$page,$limit){
        $page_first = ($page - 1) * $limit;
        $db = DBConfig::getDB();

        $stmt = $db->prepare('SELECT * FROM gallery_image where book_id = ? LIMIT ?,?');
        $stmt->bind_param("iii",$bookId, $page_first, $limit);
        $stmt->execute();
        $images = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $images;
    }

    public function updateDefaultGalleryByBookId($bookId,$imageId){

        $db = DBConfig::getDB();
    
        $stmt = $db->prepare('UPDATE gallery_image SET isShow = 0 WHERE book_id =?');
        $stmt->bind_param('i', $bookId);
    
        if($stmt->execute()){
            $stmt = $db->prepare('UPDATE gallery_image SET isShow = 1 WHERE image_id = ?');
            $stmt->bind_param('i', $imageId);
    
            $stmt->execute();

            return $stmt->affected_rows > 0;
        } else {
            return false;
        }
    }

    public function addNewGalleryByBookId($bookId,$image){
        $db = DBConfig::getDB();

        $stmt = $db->prepare("INSERT INTO gallery_image(address,book_id,isShow) values (?,?,0)");
        $stmt->bind_param("si", $image, $bookId);
        $stmt->execute();

    }

    public function deleteById($imageId){
        $db = DBConfig::getDB();

        $stmt = $db->prepare("DELETE FROM gallery_image WHERE image_id =?");
        $stmt->bind_param('i', $imageId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }



}





