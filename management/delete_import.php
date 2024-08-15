<?php 
session_start();
require_once('../database.php');

$db = DBConfig::getDB();

if(isset($_GET['import_id'])){
    $import_id = $_GET['import_id'];

    $stmt = $db->prepare('SELECT * FROM import_item WHERE import_id =?');
    $stmt->bind_param('i', $import_id);
    $stmt->execute();

    $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    foreach($items as $item){
        $stmt = $db->prepare('UPDATE books set stock = stock - ? WHERE book_id =?');
        $stmt->bind_param('ii',$item['quantity'],$item['book_id'] );
        $stmt->execute();
    }
    
    $stmt = $db->prepare('DELETE FROM import_item WHERE import_id =?');
    $stmt->bind_param('i', $import_id);
    $stmt->execute();

    $stmt = $db->prepare('DELETE FROM import WHERE id =?');
    $stmt->bind_param('i', $import_id);
    $stmt->execute();

    header('Location: '.$_SERVER['HTTP_REFERER']);
    exit();
}