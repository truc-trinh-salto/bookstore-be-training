<?php
session_start();
require_once('../../database.php');

$db = DBConfig::getDB();

if(isset($_POST['submit'])){
    $route_id = $_POST['route_id'];
    $transport_id = $_POST['transport_id'];
    $point = $_POST['point'];

    echo $route_id;
    echo $transport_id;
    echo $point;

    $stmt = $db->prepare("UPDATE route SET status = 1 WHERE id =? and transport_id =? AND status = 0");
    $stmt->bind_param("ii", $route_id, $transport_id);
    $stmt->execute();

    if($point == 2){
        $stmt = $db->prepare("UPDATE transport SET status = 1, actualAt = NOW() WHERE id =?");
        $stmt->bind_param("i", $transport_id);
        $stmt->execute();
    }
    header("location: ".$_SERVER['HTTP_REFERER']);
    
}