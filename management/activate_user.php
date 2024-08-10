<?php 
    session_start();
    require_once('../database.php');

    $db = DBConfig::getDB();

    if(isset($_GET['user_id']) && isset($_GET['action'])) {
        $action = 0;
        $user_id = $_GET['user_id'];
        if($_GET['action'] == 'lock') {
            $action = 1;
        } else {
            $action = 0;
        }

        $stmt = $db->prepare('UPDATE users SET deactivate =? WHERE id =?');
        $stmt->bind_param('ii', $action, $user_id);
        $stmt->execute();

        if($stmt->affected_rows > 0 && $action == 1) {
            $_SESSION['message'] = 'KHOÁ THÀNH CÔNG !';
        } else {
            $_SESSION['message'] = 'MỞ KHOÁ THÀNH CÔNG !';
        }

        header('Location: users.php');
    }
?>