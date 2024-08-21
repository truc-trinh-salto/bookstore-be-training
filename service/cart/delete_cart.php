<?php
    session_start();
    $key = array_search($_GET['book_id'], $_SESSION['cart']);
    unset($_SESSION['cart'][$key]);

    unset($_SESSION['qty_array'][$_GET['index']]);


    //rerange array keys to keep the indexes consistent
    $_SESSION['qty_array'] = array_values($_SESSION['qty_array']);
    $_SESSION['message'] = "Book has been removed from the cart!";

    header('Location: ../../views/user/view_cart.php');


?>