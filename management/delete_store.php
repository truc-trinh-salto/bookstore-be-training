<?php
    session_start();
    require_once('../database.php');
    $db = DBConfig::getDB();

    if($_GET['branch_id']){

        $stmt = $db->prepare('DELETE FROM branchstockitem WHERE branch_id =?');
        $stmt->bind_param('i', $_GET['branch_id']);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $stmt = $db->prepare('DELETE FROM branch WHERE branch_id =?');
            $stmt->bind_param('i', $_GET['branch_id']);
            $stmt->execute();
            $_SESSION['message'] = 'Branch deleted successfully!';
        } else {
            $_SESSION['message'] = 'Failed to delete branch!'; 
        }
        header('Location: store_system.php');
    }
?>