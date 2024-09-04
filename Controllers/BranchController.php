<?php
namespace MVC\Controllers;
// require '../vendor/autoload.php';
use MVC\Controller;

use MVC\Services\BranchService;


session_start();

class BranchController extends Controller {
    public function branch(){
        $data = BranchService::getInstance()->showStoreSystemPage();

        $this->render('user/store_system',$data);
    }

    public function branchManagement(){
        $searchKeyword = $_GET['search_keyword'];
        $data = BranchService::getInstance()->showBranchManagementPage($searchKeyword);
        
        $this->render('management/store_system',$data);
    }

    public function pageAddBranch(){
        $this->render('management/add/add_store');
    }

    public function pageEditBranch(){
        $branchId = $_GET['branch_id'];

        $data = BranchService::getInstance()->showEditBranchPage($branchId)
        ;
        $this->render('management/edit/edit_store',$data);
    }

    public function detailBranch(){
        $branchId = $_GET['branch_id'];
        $searchKeyword = $_GET['search_keyword'];

        $page = $_GET['page'] ?: 1;

        $limit = 6;

        $data = BranchService::getInstance()->showDetailOfBranchPage($branchId,$searchKeyword,$page,$limit);

        $this->render('management/detail/branch_stock',$data);
    }

    public function addBranch(){
        $name = $_POST['name'];
        $address = $_POST['address'];
        $hotline = $_POST['hotline'];
        $image = $_FILES;

        BranchService::getInstance()->addNewBranch($name, $address, $hotline, $image);

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    public function editBranch(){
        $name = $_POST['name'];
        $address = $_POST['address'];
        $hotline = $_POST['hotline'];
        $image = $_FILES;
        $branchId = $_POST['branch_id'];

        BranchService::getInstance()->editBranch($branchId,$name, $address, $hotline, $image);

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    public function deleteBranch(){
        $branchId = $_GET['branch_id'];
        BranchService::getInstance()->deleteBranch($branchId);

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    public function selectWareHouse(){
        $branchId = $_POST['branch_select'];
        $bookId = $_POST['book_id'];

        echo $branchId;
        echo $bookId;

        BranchService::getInstance()->editBranchSelectWareHouse($bookId, $branchId);

        header('Location: '. $_SERVER['HTTP_REFERER']);
    }

    public function actionStock(){
        $action = 0;
        if($_GET['action'] == 'in'){
            $action = 1;
        }

        $bookId = $_GET['book_id'];
        $branchId = $_GET['branch_id'];

        BranchService::getInstance()->actionStock($bookId, $branchId, $action);

        header('Location: '. $_SERVER['HTTP_REFERER']);
    }
}


