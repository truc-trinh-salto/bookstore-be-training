<?php
    session_start(); 
    session_destroy();
    // if(isset($_SERVER['HTTP_REFERER'])) {
    //     header('Location: '. $_SERVER['HTTP_REFERER']);
    // }
    header('Location: views/user/home.php');
    exit();
?>