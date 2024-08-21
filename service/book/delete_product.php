<?php
    session_start();
    require_once('../../database.php');
    $db = DBConfig::getDB();
    if($_GET['book_id']){
        $stmt = $db->prepare('DELETE FROM books WHERE book_id =?');
        $stmt->bind_param('i', $_GET['book_id']);
        $stmt->execute();
        $_SESSION['message'] = 'Book deleted successfully!';
        
        if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }
?>