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

class CartService {

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
    
    public function showDropdownInCart($bookId){
        $book = BookRepository::getInstance()->findById($bookId);

        $cartArray = $_SESSION['cart'];
        $qtyArray = $_SESSION['qty_array'];
        $message = '';

        $quantity = 1;
        if($_POST['quantity'] == '' || $_POST['quantity'] <= 0){
            $quantity = 1;
        } else {
            $quantity = $_POST['quantity'];
        }

        if(!in_array($bookId, $cartArray)) {
            if($book['stock'] < $quantity){
                $message = 'Sản phẩm đã hết hàng!';
            } else{
                array_push($_SESSION['cart'], $bookId);
                array_push($_SESSION['qty_array'], $quantity);
                $message = 'Product added to cart!';
            }
        } else {
            $index = array_search($bookId,$cartArray);
            $newQty = $qtyArray[$index] + $quantity;
            if($book['stock'] < $newQty ){
                $message = 'Sản phẩm đã vượt quá số lượng cho phép!';
            } else {
                $_SESSION['qty_array'][$index] = $newQty;
                $message= 'Product already in the cart!'; 
            }
        }


        $books_cart = BookRepository::getInstance()->getAllInCart($cartArray);
        $carts = GalleryImageRepository::getInstance()->getImageBooks($books_cart);  
        return ['book_cart' => $carts];
    }

    public function showAllInCart($cartArray){
        if(count($cartArray) > 0){
            $cart = BookRepository::getInstance()->getAllInCart($cartArray);
        }
        $categories = CategoryRepository::getInstance()->getAllCategories();
        
        return ['carts' => $cart,'categories' => $categories];
    }

    public function saveCart($indexes){
        foreach ($indexes as $index) {
            $message = '';
            $book_id = $_SESSION['cart'][$index];

            $book = BookRepository::getInstance()->findById($book_id);
            $newQty = $_POST['qty_'.$index];
            
            if($newQty > $book['stock']){
                $message .= '<br> Sản phẩm '.$book['title']. ' đã vượt quá số lượng cho phép là '. $book['stock'] .'</br>'; 
            } else if($newQty <= 0){
                $key = array_search($book_id, $_SESSION['cart']);
                unset($_SESSION['cart'][$key]);
                unset($_SESSION['qty_array'][$_GET['index']]);
        
                $_SESSION['qty_array'] = array_values($_SESSION['qty_array']);
                $_SESSION['message'] = "Book has been removed from the cart!";
            } else {
                $_SESSION['qty_array'][$index] = $newQty;
            }
        }
        if($message){
            $_SESSION['message'] = $message;
        } else{
            $_SESSION['message'] = 'Cart updated successfully';
        }
    }

    public function deleteCart($bookId){
        $key = array_search($bookId, $_SESSION['cart']);
        unset($_SESSION['cart'][$key]);
    
        unset($_SESSION['qty_array'][$_GET['index']]);
    
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        $_SESSION['qty_array'] = array_values($_SESSION['qty_array']);
        $_SESSION['message'] = "Book has been removed from the cart!";
    }

    public function clearCart(){
        unset($_SESSION['cart']);
        unset($_SESSION['qty_array']);
        $_SESSION['message'] = 'Cart cleared successfully';
    }

    public function applyCoupon($code,$total,$userId){
        $codesale = CodesaleRepository::getInstance()->findByCode($code);
        $message = '';
        if($codesale){
            $user_code = CodesaleRepository::getInstance()->checkUserCode($codesale['code_id'],$userId);
            if($codesale['endAt'] < date('Y-m-d') || $codesale['deactivate'] == 0) {
                $message = 'Mã này đã hết hiệu lực';
            } else if($codesale['min'] > $total){
                $message = 'Đơn hàng của bạn phải tối thiểu '. $codesale['min']. 'đ để nhận mã giảm giá';
            }else if($user_code){
                $message = 'Bạn đã sử dụng mã giảm giá này';
            } else {
                $message = ''.$codesale['code'].'
                            '.$codesale['description'].'';
                if($codesale['method'] == 0){
                    $value_discount = ($total * (float)$codesale['value'] / 100);
                    if($value_discount > $codesale['max'] && $codesale['max'] != null & $codesale['max'] != ''){
                    $value_discount = $codesale['max'];
                    }
                    $total = $total - $value_discount;
                } else {
                    $total = $total - (float)$codesale['value'];
                }

            }
        } else {
            $message = 'Mã giảm giá không tồn tại';
        }
        return ['success' => true,'message' => $message, 'code_id' => $codesale['id'], 'total' => $total];
    }

    public function confirmCheckOut($cartArray,$userId){
        $books = BookRepository::getInstance()->getAllInCart($cartArray);

        if(!$this->checkStock($books)){
            $_SESSION['message'] = 'Có lỗi khi đặt hàng';
        } else {
            $order_id = OrderRepository::getInstance()->addNewOrder($userId);

            $index = 0;
            $total = 0;
            //ADD ORDER DETAIL AND UPDATE STOCK
            foreach($books as $row)  {
                $qty = $_SESSION['qty_array'][$index];
                if($row['sale'] != null && $row['sale'] != 0){
                    $price = $row['price'] - ($row['price'] * $row['sale'] /100);
                } else {
                    $price = $row['price'];
                }
                $total_item = $qty * $price;
                $total += $total_item;

                OrderRepository::getInstance()->addNewOrderDetail($row['book_id'],$qty,$price,$order_id,$total_item);
                BookRepository::getInstance()->updateStockOfBook($row['book_id'],$qty);

                $index ++;
            }


            $fullname= $_POST['firstname'].' '.$_POST['lastname'];
            $address = $_POST['address'].' '.$_POST['country'] .' '.$_POST['state'];
            $date = strtotime("+7 day");
            if(isset($_POST['code-user']) && $_POST['code-user'] != null) {
                $code_id = $_POST['code-user'];

                $codesale = CodesaleRepository::getInstance()->findById($code_id);

                if($codesale['method'] == 0){
                    $total = $total - ($total * (float)$codesale['value'] / 100);
                } else {
                    $total = $total - (float)$codesale['value'];
                }

                CodesaleRepository::getInstance()->addUserCode($code_id,$userId);
            }

            $insert_transport = TransportRepository::getInstance()->addNewTransport();
            
            TransactionRepository::getInstance()->addNewTransaction($address,$fullname,$order_id,$total,$codesale['id'],$insert_transport);

            RouteRepository::getInstance()->addNewRouteForTransport($insert_transport);
            
            unset($_SESSION['cart']);
            unset($_SESSION['qty_array']);

            $_SESSION['message'] = 'Đặt hàng thành công';
        }
    }

    function checkStock($books){
        $cartArray = $_SESSION['cart'];
        $qtyArray = $_SESSION['qty_array'];
        var_dump($books);
        foreach($books as $book){
            $index = array_search($book['book_id'], $cartArray);
            if($book['stock'] < $qtyArray[$index]){
                echo $book['book_id'];
                return false;
            }
            return true;
        }
    }
}

