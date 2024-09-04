<?php
namespace MVC\Controllers;
// require '../vendor/autoload.php';
use MVC\Controller;


use MVC\Services\TransactionService;




session_start();

class TransactionController extends Controller {
    public function history(){

        $userId = $_SESSION['user_id'];

        $page = $_GET['page'] ?: 1;

        $limit = 6;

        $data = TransactionService::getInstance()->showHistoryPage($userId,$page,$limit);


        $this->render('user/history',$data);
    }

    public function detailTransaction(){
        $orderId = $_GET['order_id'];

        $data = TransactionService::getInstance()->showDetailTransationPage($orderId);

        $this->render('user/detail_transaction',$data);

    }

    public function transactionOfUserManagement(){
        $userId = $_GET['user_id'];

        $page = $_GET['page'] ?: 1;

        $limit = 6;

        $data = TransactionService::getInstance()->showHistoryPage($userId,$page,$limit);

        $this->render('management/detail/transaction_user',$data);
    }

    public function detailTransactionOfUserManagement(){
        $orderId = $_GET['order_id'];

        $data = TransactionService::getInstance()->showDetailTransationPage($orderId);

        $this->render('management/detail/detail_transaction',$data);

    }

    public function revnenueManagement(){
        $from = $_GET['dateFrom'];
        $to = $_GET['dateTo'];

        $page = $_GET['page'] ?: 1;
        $limit = 6;


        $data = TransactionService::getInstance()->showRevenueManagementPage($from,$to,$page,$limit);

        $this->render('management/revenue',$data);
    }

    public function transportManangement(){
        $from = $_GET['dateFrom'];
        $to = $_GET['dateTo'];

        $page = $_GET['page'] ?: 1;
        $limit = 6;

        $data = TransactionService::getInstance()->showRevenueManagementPage($from,$to,$page,$limit);

        $this->render('management/transport/home',$data);
    }

    public function detailTransportManagement(){
        $orderId = $_GET['order_id'];

        $data = TransactionService::getInstance()->showDetailTransationPage($orderId);

        $this->render('management/transport/detail_transaction',$data);
    }
}


