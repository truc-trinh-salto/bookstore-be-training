<?php
    session_start();
    require_once('../database.php');
    $db = DBConfig::getDB();
    if($_GET['category_id']){
        $stmt = $db->prepare('DELETE FROM categories WHERE category_id =?');
        $stmt->bind_param('i', $_GET['category_id']);
        $stmt->execute();
        $_SESSION['message'] = 'Category deleted successfully!';
        
        if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }
?>