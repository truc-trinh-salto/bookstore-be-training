<?php
    session_start();
    unset($_SESSION['cart']);
    unset($_SESSION['qty_array']);
    $_SESSION['message'] = 'Cart cleared successfully';
    header('location: ../../views/user/home.php');

?>