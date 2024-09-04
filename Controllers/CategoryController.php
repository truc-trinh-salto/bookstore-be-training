<?php
namespace MVC\Controllers;
// require '../vendor/autoload.php';
use MVC\Controller;


use MVC\Services\CategoryService;

session_start();

class CategoryController extends Controller {
    public function categoryManagment(){
        $page = $_GET['page'] ?: 1;
        $limit = 6;

        $searchKeyword = $_GET['search_keyword'];
        $data = CategoryService::getInstance()->showCategoryManagementPage($page,$limit,$searchKeyword);

        $this->render('management/category',$data);
    }

    public function pageAddCategory(){
        $this->render('management/add/add_category');
    }

    public function pageEditCategory(){
        $categoryId = $_GET['category_id'];

        $data = CategoryService::getInstance()->showEditCategoryPage($categoryId);

        $this->render('management/edit/edit_category',$data);
    }

    public function addCategory(){
        $name = $_POST['name'];
        
        CategoryService::getInstance()->addNewCategory($name);

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    public function deleteCategory(){
        $categoryId = $_GET['category_id'];

        CategoryService::getInstance()->deleteCategory($categoryId);

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    public function editCategory(){
        $categoryId = $_POST['category_id'];
        $name = $_POST['name'];
        
        CategoryService::getInstance()->editCategory($categoryId,$name);

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    public function addCategoryByFile(){
        $file = $_FILES;

        CategoryService::getInstance()->addCategoryByFile($file);

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    public function productOfCategoryManagement(){
        $categoryId = $_GET['category_id'];
        $page = $_GET['page']?: 1;
        $limit = 6;

        $searchKeyword = $_GET['search_keyword'];

        $data = CategoryService::getInstance()->showProductOfCategoryManagmentPage($categoryId, $page, $limit, $searchKeyword);

        $this->render('management/detail/product_category',$data);
    }
}


