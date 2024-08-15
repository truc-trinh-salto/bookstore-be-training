<?php 
    session_start();
    require_once('../database.php');

    $db = DBConfig::getDB();
    $date = date('d-m-Y');
    $import_id = $_POST['import_id'];
    $stmt = $db->prepare("UPDATE import SET status = 1 WHERE id = ?");
    $stmt ->bind_param("i", $import_id);
    $stmt->execute();
    
    if($stmt->affected_rows > 0){
        $_SESSION['message'] = 'Thực hiện nhập hàng thành công!';
    } else {
        $_SESSION['message'] = 'Thực hiện nhập hàng thất bại';
    }
    header('Location: inventory.php');


?>