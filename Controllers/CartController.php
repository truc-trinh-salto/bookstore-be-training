<?php
namespace MVC\Controllers;
// require '../vendor/autoload.php';
use MVC\Controller;


use MVC\Services\CartService;



session_start();

class CartController extends Controller {

    public function inCart(){
        $bookId = $_POST['book_id'];
        
        $data = CartService::getInstance()->showDropdownInCart($bookId);
        $this->render('user/templates/in_cart',$data);
    }

    public function viewCart(){
        $cartArray = $_SESSION['cart'];
        $qtyArray = $_SESSION['qty_array'];
        $data = CartService::getInstance()->showAllInCart($cartArray);
        $this->render('user/view_cart',$data);
    }

    public function checkOut(){
        $cartArray = $_SESSION['cart'];
        $qtyArray = $_SESSION['qty_array'];
        $data = CartService::getInstance()->showAllInCart($cartArray);
        
        $this->render('user/check_out',$data);
    }

    public function saveCart(){
        $indexes = $_POST['indexes'];
        CartService::getInstance()->saveCart($indexes);
		header('location: /view_cart');
    }

    public function deleteCart(){
        $bookId = $_GET['book_id'];
        CartService::getInstance()->deleteCart($bookId);

        header('location: /view_cart');
    }

    public function clearCart(){
        CartService::getInstance()->clearCart();

        header('location: /');
    }

    public function applyCoupon(){
        $code = $_POST['code'];
        $total = $_POST['total'];
        $userId = $_SESSION['user_id'];

        $data = CartService::getInstance()->applyCoupon($code,$total,$userId);

        echo json_encode($data);
    }

    public function confirmCheckOut(){
        $cartArray = $_SESSION['cart'];
        $userId = $_SESSION['user_id'];
        if(!$userId){
            header('Location: /login');
            exit();
        } else {
            CartService::getInstance()->confirmCheckOut($cartArray,$userId);
            header('Location: /');
        }
    }

    
}


