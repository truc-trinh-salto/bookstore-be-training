<?php
namespace MVC\Controllers;
// require '../vendor/autoload.php';
use LDAP\Result;
use MVC\Controller;

use MVC\Services\BookService;


use DBConfig;

session_start();


class BookController extends Controller {

    public function home($queryParams = []) {

        $data = BookService::getInstance()->showHomePage();
    
        $this->render('user/home',$data);

    }

    public function getMoreInfinityData() {
        $lastID = $_POST['id'];

        $limit = 1;
        
        $data = BookService::getInstance()->getMoreInfinityData($lastID,$limit);

        $this->render('user/templates/get_data',$data);
    }

    public function category($queryParams= []){

        $category_id = $_GET['category_id'] ?: null;
        $minprice = $_GET['minprice'] ?: null;
        $maxprice = $_GET['maxprice'] ?: null;
        $page = $_GET['page'] ?: 1;

        $limit = 6;

        $data = BookService::getInstance()->showFillerCategoryPage($category_id, $minprice, $maxprice, $page, $limit);

    
        $this->render('user/category',$data);
    }

    public function filter($queryParams= []){

        $searchKeyword = $_GET['search_keyword'] ?: null;
        $minprice = $_GET['minprice'] ?: null;
        $maxprice = $_GET['maxprice'] ?: null;
        $page = $_GET['page'] ?: 1;

        $limit = 6;


        $data = BookService::getInstance()->showFilterSearchPage($searchKeyword,$minprice, $maxprice, $page, $limit);

    
        $this->render('user/filter',$data);
    }

    public function detailProduct(){
        $bookId = $_GET['book_id'];
        $userId = $_SESSION['user_id'];

        //GET ALL CATEGORIES
        $data = BookService::getInstance()->showDetailProductPage($bookId,$userId);

        
        $this->render('user/detail_product',$data);
    }

    public function productManagement(){
        $limit = 6;
        $page = $_GET['page'] ?:1;

        $searchKeyword = $_GET['search_keyword'];
        

        $data = BookService::getInstance()->showProductManagementPage($searchKeyword,$page,$limit);
        

        $this->render('management/product',$data);
    }

    public function pageAddProduct(){
        $data = BookService::getInstance()->showAddNewProductPage();
        $this->render('management/add/add_product',$data);
    }

    public function pageEditProduct(){

        $bookId = $_GET['book_id'];
        $data = BookService::getInstance()->showEditProductPage($bookId);

        $this->render('management/edit/edit_product',$data);
    }

    public function addProduct(){
        $image = $_POST['image'];
        $name = $_POST['name'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $hotItem = $_POST['hotItem'];
        $categoryId = $_POST['category'];
        $authors = $_POST['authors'];
        $description = $_POST['description'];
        $files = $_FILES;

        BookService::getInstance()->addNewProduct($image,$name,$quantity,$price,
                                                    $hotItem,$categoryId,$authors,
                                                    $description,$files);

        header('Location: /management/pageAddProduct');
    }

    public function editProduct(){
        $bookId = $_POST['book_id'];
        $image = $_POST['image_id'];
        $name = $_POST['name'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $hotItem = $_POST['hotItem'];
        $categoryId = $_POST['category'];
        $authors = $_POST['authors'];
        $description = $_POST['description'];
        $sale = $_POST['sale'];

        BookService::getInstance()->editProduct($image,$name,$quantity,$price,
                                                $hotItem,$categoryId,$authors,
                                                $description,$sale,$bookId);

        header('Location: /management/pageEditProduct?book_id='.$bookId);
    }

    public function addProductByFile(){

        $file = $_FILES;


        BookService::getInstance()->addProductByFile($file);

        header("Location: /management/product");
    }

    public function deleteProduct(){
        $bookId = $_GET['book_id'];
        BookService::getInstance()->deleteProduct($bookId);
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    public function exportListAllOfProduct(){
        BookService::getInstance()->exportListAllOfProduct();

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    public function hotItem(){
        $page = $_GET['page'] ?:1;
        $date = $_GET['date_select'];
        $searchKeyword = $_GET['search_keyword'];

        $limit = 6;

        $data = BookService::getInstance()->showHotItemPage($searchKeyword,$page,$limit,$date);


        $this->render('management/hot_item',$data);
    }

    public function exportListAllOfHotItems(){
        $date = $_GET['date_select'];

        BookService::getInstance()->exportListAllOfHotItems($date);

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    
}


