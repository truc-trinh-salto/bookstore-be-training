<?php
session_start();
require_once('../database.php');

$db = DBConfig::getDB();

if(isset($_GET['image_id'])){
    $image_id = $_GET['image_id'];



    $stmt = $db->prepare("DELETE FROM gallery_image WHERE image_id =?");
    $stmt->bind_param('i', $image_id);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        $_SESSION['message'] = 'Xoá hình ảnh thành công';
        header('Location: '.$_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['message'] = 'Xoá hình ảnh thất bại';
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}