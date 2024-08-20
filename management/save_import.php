<?php
    require_once('../database.php');
    session_start();
    $db = DBConfig::getDB();
    $message;
    if(isset($_POST['save'])){
        foreach ($_POST['indexes'] as $index) {
            $book_id = $_SESSION['import_item'][$index];

            $newQty = $_POST['qty_'.$index];
            
            if($newQty <= 0){
                $_SESSION['qty_array_import'][$index] = 0;
                $_SESSION['message'] = "Book has been removed from the cart!";
            } else {
                $_SESSION['qty_array_import'][$index] = $newQty;
            }
        }
        if($message){
            $_SESSION['message'] = $message;
        } else{
            $_SESSION['message'] = 'Cart updated successfully';
        }
		header('location: '. $_SERVER['HTTP_REFERER']);
    }
