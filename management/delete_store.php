<?php
    session_start();
    require_once('../database.php');
    $db = DBConfig::getDB();
    if($_GET['branch_id']){
        $stmt = $db->prepare('DELETE FROM branch WHERE branch_id =?');
        $stmt->bind_param('i', $_GET['branch_id']);
        $stmt->execute();
        $_SESSION['message'] = 'Branch deleted successfully!';
        header('Location: store_system.php');
    }
?>