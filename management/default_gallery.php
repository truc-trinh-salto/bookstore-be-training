<?php
session_start();
require_once('../database.php');

$db = DBConfig::getDB();

if(isset($_GET['image_id']) && isset($_GET['book_id'])){
    $image_id = $_GET['image_id'];
    $book_id = $_GET['book_id'];

    $stmt = $db->prepare('UPDATE gallery_image SET isShow = 0 WHERE book_id =?');
    $stmt->bind_param('i', $book_id);

    if($stmt->execute()){
        echo $image_id;
        $stmt = $db->prepare('UPDATE gallery_image SET isShow = 1 WHERE image_id = ?');
        $stmt->bind_param('i', $image_id);

        if($stmt->execute()){
            $_SESSION['message'] = "Cập nhật mặc định thành công";
        } else {
            $_SESSION['message'] = "Cập nhật mặc định thất bại";
        }
    } else {
        $_SESSION['message'] = "Cập nhật mặc định thất bại";
    }

}

header('Location: ' . $_SERVER['HTTP_REFERER']);