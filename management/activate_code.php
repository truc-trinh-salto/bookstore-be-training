<?php 
    session_start();
    require_once('../database.php');

    $db = DBConfig::getDB();

    if(isset($_GET['code_id']) && isset($_GET['action'])) {
        $action = 0;
        $code_id = $_GET['code_id'];
        if($_GET['action'] == 'in') {
            $action = 1;
        } 

        $stmt = $db->prepare('UPDATE codesale SET deactivate =? WHERE id =?');
        $stmt->bind_param('ii', $action, $code_id);
        $stmt->execute();

        if($stmt->affected_rows > 0 && $action == 1) {
            $_SESSION['message'] = 'KHOÁ THÀNH CÔNG !';
        } else {
            $_SESSION['message'] = 'MỞ KHOÁ THÀNH CÔNG !';
        }

        header('Location: codesale.php');
    }
?>