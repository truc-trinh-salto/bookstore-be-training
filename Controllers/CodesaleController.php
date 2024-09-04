<?php
namespace MVC\Controllers;
// require '../vendor/autoload.php';
use MVC\Controller;

use MVC\Services\CodesaleService;


session_start();

class CodesaleController extends Controller {
    public function codesale(){
        $data = CodesaleService::getInstance()->showCodesalePage();

        $this->render('user/codesale',$data);
    }

    public function codesaleManagement(){
        $searchKeyword = $_GET['search_keyword'];
        $data = CodesaleService::getInstance()->showCodesaleManagementPage($searchKeyword);
        
        $this->render('management/codesale',$data);
    }

    public function activateCode(){
        $action = 0;
        $codeId = $_GET['code_id'];
        if($_GET['action'] == 'in') {
            $action = 1;
        } 

        CodesaleService::getInstance()->activateCode($codeId, $action);

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }   

    public function pageAddCodesale(){
        $this->render('management/add/add_codesale');
    }

    public function addNewCodesale(){
        $description = $_POST['description'];
        $min = $_POST['min'];
        $max = $_POST['max'];
        $startAt = $_POST['startDate'];
        $endAt = $_POST['endDate'];
        $activate = $_POST['activate'];
        $method = $_POST['method'];
        $value = $_POST['value'];
        $code = $_POST['code'];

        if($method == 0){
            if($value > 100){
                $value = 100;
            }
        }

        CodesaleService::getInstance()->addNewCodesale($description, $min, $max, $startAt, $endAt, $activate, $method, $value, $code);

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    public function pageEditCodesale(){
        $codeId = $_GET['code_id'];
        $data = CodesaleService::getInstance()->showEditCodesalePage($codeId);

        $this->render('management/edit/edit_codesale', $data);
    }

    public function editCodesale(){
        $description = $_POST['description'];
        $min = $_POST['min'];
        $max = $_POST['max'];
        $startAt = $_POST['startDate'];
        $endAt = $_POST['endDate'];
        $activate = $_POST['activate'];
        $method = $_POST['method'];
        $value = $_POST['value'];
        $code = $_POST['code'];
        $codeId = $_POST['code_id'];
        if($method == 0){
           if($value > 100){
                $value = 100;
           }
        }

        CodesaleService::getInstance()->editCodesale($codeId,$description, $min, $max, $startAt, $endAt, $activate, $method, $value, $code);

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}


