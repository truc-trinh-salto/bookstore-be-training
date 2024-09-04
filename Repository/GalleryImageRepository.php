<?php
namespace MVC\Repository;

use MVC\Models\Book;
use MVC\Models\Category;
use MVC\Models\GalleryImage;
use MVC\Models\User;
use MVC\Models\Rating;

session_start();

class GalleryImageRepository {

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

    public function findShowByBookId($bookId){
        return GalleryImage::getInstance()->findShowByBookId($bookId);
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

    public function getAllImagesByBookId($bookId){
        return GalleryImage::getInstance()->getAllImagesByBookId($bookId);
    }

    public function findDefaultImageByBookId($bookId){
        return GalleryImage::getInstance()->findDefaultImageByBookId($bookId);
    }

    public function addNewGalleryOfBook($image,$bookId,$isShow){
        return GalleryImage::getInstance()->addNewGalleryOfBook($image,$bookId,$isShow);
    }

    public function updateDefaultGalleryOfBook($bookId,$imageId){
        return GalleryImage::getInstance()->updateDefaultGalleryOfBook($bookId,$imageId);
    }

    public function getNumberPageOfGalleryPage($bookId, $limit){
        return GalleryImage::getInstance()->getNumberPageOfGalleryPage($bookId,$limit);
    }

    public function getAllByGalleryPagination($bookId,$page,$limit){
        return GalleryImage::getInstance()->getAllByGalleryPagination($bookId,$page,$limit);
    }

    public function updateDefaultGalleryByBookId($bookId,$imageId){
        return GalleryImage::getInstance()->updateDefaultGalleryByBookId($bookId,$imageId);
    }

    public function addNewGalleryByBookId($bookId,$image){
        return GalleryImage::getInstance()->addNewGalleryByBookId($bookId,$image);
    }

    public function deleteById($imageId){
        return GalleryImage::getInstance()->deleteById($imageId);
    }

    
}


