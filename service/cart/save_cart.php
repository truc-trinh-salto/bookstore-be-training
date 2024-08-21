<?php
    require_once('../../database.php');
    session_start();
    $db = DBConfig::getDB();
    $message;
    if(isset($_POST['save'])){
        foreach ($_POST['indexes'] as $index) {
            $book_id = $_SESSION['cart'][$index];

            $stmt = $db->prepare("SELECT * FROM books WHERE book_id = ?");
            $stmt->bind_param("i", $book_id);
            $stmt->execute();

            $book = $stmt->get_result()->fetch_assoc();

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
		header('location: ../../views/user/view_cart.php');
    }
?>