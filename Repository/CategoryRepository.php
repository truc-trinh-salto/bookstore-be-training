<?php
namespace MVC\Repository;

use MVC\Models\Book;
use MVC\Models\Category;
use MVC\Models\GalleryImage;
use MVC\Models\User;
use MVC\Models\Rating;


class CategoryRepository {
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

    public function getAllCategories(){
        return Category::getInstance()->getAllCategories();;
    }

    public function getInfinityCategory(){
        return Category::getInstance()->getInfinityCategories();
    }

    public function findByCategoryId($categoryId){
        return Category::getInstance()->findByCategoryId($categoryId);
    }

    public function findCategoryExistence($categoryName){
        return Category::getInstance()->findCategoryExistence($categoryName);
    }

    public function getNumberPageOfCategoryManagementPage($searchKeyword,$limit){
        return Category::getInstance()->getNumberPageOfCategoryManagementPage($searchKeyword,$limit);
    }

    public function getAllByCategoryPagination($searchKeyword,$page, $limit){
        return Category::getInstance()->getAllByCategoryPagination($searchKeyword,$page, $limit);
    }

    public function getTotalBooksOfQuantity($categories){
        $result = [];
        foreach($categories as $category) {
            $total = $this->findTotalBookOfCategoryById($category['category_id']);
            $category['total'] = $total['total'];
            $result[] = $category;
        }

        return $result;
    }

    public function findTotalBookOfCategoryById($categoryId){
        return Category::getInstance()->findTotalBookOfCategoryById($categoryId);
    }

    public function addNewCategory($categoryName){
        return Category::getInstance()->addNewCategory($categoryName);
    }

    public function checkExistenceCategory($categoryName){
        return Category::getInstance()->checkExistenceCategory($categoryName);
    }

    public function deleteById($categoryId){
        return Category::getInstance()->deleteById($categoryId);
    }

    public function updateCategory($categoryId,$categoryName){
        return Category::getInstance()->updateCategory($categoryId,$categoryName);
    }
}


