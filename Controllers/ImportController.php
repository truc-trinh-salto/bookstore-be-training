<?php
namespace MVC\Controllers;
// require '../vendor/autoload.php';
use MVC\Controller;


use MVC\Services\ImportService;

session_start();

class ImportController extends Controller {
    public function inventoryManagement(){
        $page = $_GET['page'] ?: 1;
        $searchKeyword = $_GET['search_keyword'];
        $limit = 6;

        $data = ImportService::getInstance()->showInventoryManagement($searchKeyword,$page,$limit);

        $this->render('management/inventory',$data);
    }

    public function detailInventoryManagement(){
        $importId = $_GET['import_id'];
        $page = $_GET['page'] ?: 1;
        $searchKeyword = $_GET['search_keyword'];
        $limit = 6;

        $data = ImportService::getInstance()->showDetailInventoryManagement($importId,$searchKeyword,$page,$limit);

        $this->render('management/detail/detail_import',$data);
    }

    public function addNewInventory(){
        $importId = ImportService::getInstance()->addNewInventory();

        header('Location: /management/detailInventory?import_id='.$importId);
    }

    public function deleteInventory(){
        $importId = $_GET['import_id'];
        ImportService::getInstance()->deleteInventory($importId);

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    public function updateQuantityInventory(){

        $bookId = $_POST['book_id'];
        $importId = $_POST['import_id'];
        $quantity = $_POST['quantity'];

        $result = ImportService::getInstance()->updateQuantityInventory($bookId,$importId,$quantity);

        echo json_encode($result);
    }

    public function confirmImport(){
        $importId = $_GET['import_id'];

        ImportService::getInstance()->confirmImport($importId);

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    public function importFile(){
        $importId = $_POST['import_id'];
        $file = $_FILES;

        ImportService::getInstance()->importFile($importId,$file);

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    public function exportFile(){
        $importId = $_POST['import_id'];

        ImportService::getInstance()->exportFile($importId);

        header('Location: '.$_SERVER['HTTP_REFERER']);

    }
}


