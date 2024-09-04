<?php
namespace MVC\Services;

use MVC\Repository\BookRepository;
use MVC\Repository\BranchRepository;
use MVC\Repository\CategoryRepository;
use MVC\Repository\CodesaleRepository;
use MVC\Repository\GalleryImageRepository;
use MVC\Repository\CommentRepository;
use MVC\Repository\OrderRepository;
use MVC\Repository\RatingRepository;
use MVC\Repository\RouteRepository;
use MVC\Repository\TransportRepository;
use MVC\Repository\TransactionRepository;


session_start();

class TransactionService {

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
    
    public function showHistoryPage($userId,$page,$limit){
        $page_first = ($page - 1) * $limit;

        $number_page = TransactionRepository::getInstance()->getNumberPageOfHistoryPage($limit,$userId);

        $transactions = TransactionRepository::getInstance()->getByHistoryPagination($userId,$page_first,$limit);

        $categories = CategoryRepository::getInstance()->getAllCategories();

        $cartArray = $_SESSION['cart'];

        if(count($cartArray) > 0){
            $books_cart = BookRepository::getInstance()->getAllInCart($cartArray);
            $carts = GalleryImageRepository::getInstance()->getImageBooks($books_cart);
        }

        return ['categories' => $categories,'book_cart' => $carts,
                'number_page'=>$number_page,'transactions'=>$transactions];
    }

    public function showDetailTransationPage($orderId){
        // GET ALL ORDER DETAILS OF THIS TRANSACTION
        $orderDetails = OrderRepository::getInstance()->getAllOrderDetailsByOrderid($orderId);

        // GET THIS TRANSACTION
        $transaction = TransactionRepository::getInstance()->findByOrderId($orderId);

        // GET ALL ROUTES OF THIS TRANSACTION
        $routes = RouteRepository::getInstance()->getAllRoutesByTransportId($transaction['transport_id']);

        // GET ALL CATEGORIES
        $categories = CategoryRepository::getInstance()->getAllCategories();

        // GET ALL ITEM IN CART
        $cartArray = $_SESSION['cart'];

        if(count($cartArray) > 0){
            $books_cart = BookRepository::getInstance()->getAllInCart($cartArray);
            $carts = GalleryImageRepository::getInstance()->getImageBooks($books_cart);
        }

        return ['order_details'=>$orderDetails,'transaction'=>$transaction,
                'routes'=>$routes,'categories'=>$categories,
                'book_cart' => $carts];
    }

    public function showRevenueManagementPage($from,$to,$page,$limit){

        $number_page = TransactionRepository::getInstance()->getNumberPageOfRevenueManagementPage($from,$to,$limit);
        $transactions = TransactionRepository::getInstance()->getAllByRevenueManagementPagination($from,$to,$page,$limit);
        return ['number_page' => $number_page,'transactions' => $transactions];
    }
}

