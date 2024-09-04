<?php
namespace MVC\Repository;

use MVC\Models\Book;
use MVC\Models\Category;
use MVC\Models\GalleryImage;
use MVC\Models\User;
use MVC\Models\Rating;


session_start();

class BookRepository {
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
    public function findByCategoryIdForInfinity($categoryId){
        return Book::getInstance()->findByCategoryIdForInfinity($categoryId);
    }

    public function getAllInCart($cartArray){
        return Book::getInstance()->getAllInCart($cartArray);
    }
    
    public function getMoreBooksForInfinity($lastID,$limit){
        return Book::getInstance()->getMoreBooksForInfinity($lastID,$limit);
    }

    public function getNumberPageOfCategoryPage($categoryId,$minprice,$maxprice,$limit){
        return Book::getInstance()->getNumberPageOfCategoryPage($categoryId,$minprice,$maxprice,$limit);
    }

    public function getByCategoryPagination($categoryId, $minprice, $maxprice, $page){
        return Book::getInstance()->getByCategoryPagination($categoryId, $minprice, $maxprice, $page);
    }

    public function getNumberPageOfFilterPage($searchKeyword,$minprice,$maxprice,$limit){
        return Book::getInstance()->getNumberPageOfFilterPage($searchKeyword,$minprice,$maxprice,$limit);
    }

    public function getByFilterPagination($searchKeyword, $minprice, $maxprice, $page){
        return Book::getInstance()->getByFilterPagination($searchKeyword, $minprice, $maxprice, $page);
    }

    public function findById($bookId){
        return Book::getInstance()->findById($bookId);
    }

    public function getAllHotItem($bookId){
        return Book::getInstance()->getAllHotItem($bookId);
    }

    public function getAllSameCategoryItem($bookId,$categoryId){
        return Book::getInstance()->getAllSameCategoryItem($bookId,$categoryId);
    }

    public function updateStockOfBook($bookId,$quantity){
        return Book::getInstance()->updateStockOfBook($bookId,$quantity);
    }

    public function getNumberPageOfProductManagementPage($searchKeyword, $limit){
        return Book::getInstance()->getNumberPageOfProductManagementPage($searchKeyword, $limit);
    }

    public function getByProductManagmentPagination($searchKeyword,$page,$limit){
        return Book::getInstance()->getByProductManagmentPagination($searchKeyword,$page,$limit);
    }    

    public function checkExistenceBook($name){
        return Book::getInstance()->checkExistenceBook($name);
    }

    public function checkExistencById($bookId){
        return Book::getInstance()->checkExistencById($bookId);
    }

    public function addNewBook($name, $quantity, $price, $hotItem, $categoryId, $authors, $description, $sale){
        return Book::getInstance()->addNewBook($name, $quantity, $price, $hotItem, $categoryId, $authors, $description, $sale);
    }

    public function updateBook($name,$quantity,$price,$hotItem,$categoryId,$authors,$description,$sale,$bookId){
        return Book::getInstance()->updateBook($name,$quantity,$price,$hotItem,$categoryId,$authors,$description,$sale,$bookId);
    }

    public function updateStockForInventory($bookId,$stock){
        return Book::getInstance()->updateStockForInventory($bookId,$stock);
    }

    public function checkExistenceBookById($name,$bookId){
        return Book::getInstance()->checkExistenceBookById($name,$bookId);
    }

    public function findByName($name){
        return Book::getInstance()->findByName($name);
    }

    public function deleteById($bookId){
        return Book::getInstance()->deleteById($bookId);
    }

    public function getAllBooks(){
        return Book::getInstance()->getAllBooks();
    }

    public function getAllForImportByImportId($importId){
        return Book::getInstance()->getAllForImportByImportId($importId);
    }

    public function getNumberPageOfHotItemManagementPage($searchKeyword,$limit){
        return Book::getInstance()->getNumberPageOfHotItemManagementPage($searchKeyword,$limit);
    }

    public function getAllByHotItemPagination($searchKeyword,$page,$limit,$dateTo,$dateFrom,$importId){
        return Book::getInstance()->getAllByHotItemPagination($searchKeyword,$page,$limit,$dateTo,$dateFrom,$importId);
    }

    public function getAllHotItemsInMonth($dateTo, $dateFrom){
        return Book::getInstance()->getAllHotItemsInMonth($dateTo, $dateFrom);
    }

    public function getNumberPageOfDetailCategoryManagmentPage($categoryId,$searchKeyword,$limit){
        return Book::getInstance()->getNumberPageOfDetailCategoryManagmentPage($categoryId,$searchKeyword,$limit);
    }

    public function getAllByDetailCategoryManagementPage($categoryId,$searchKeyword,$page,$limit){
        return Book::getInstance()->getAllByDetailCategoryManagementPage($categoryId,$searchKeyword,$page,$limit);
    }

    public function getNumberPageOfDetailBranchManagementPage($branchId,$searchKeyword,$limit){
        return Book::getInstance()->getNumberPageOfDetailBranchManagementPage($branchId,$searchKeyword,$limit);
    }

    public function getAllByDetailBranchManagementPage($branchId,$searchKeyword,$page,$limit){
        return Book::getInstance()->getAllByDetailBranchManagementPage($branchId,$searchKeyword,$page,$limit);
    }

    public function getNumberPageOfDetailInventoryManagementPage($importId,$searchKeyword,$limit){
        return Book::getInstance()->getNumberPageOfDetailInventoryManagementPage($importId,$searchKeyword,$limit);
    }

    public function getAllByDetailInventoryManagementPagination($importId,$searchKeyword,$page,$limit){
        return Book::getInstance()->getAllByDetailInventoryManagementPagination($importId,$searchKeyword,$page,$limit);
    }
    
}


