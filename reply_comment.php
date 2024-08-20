<?php
    session_start();
    require_once('database.php');
    $db = DBConfig::getDB();

    if(!$_SESSION['user_id']){
        header('Location: index.php');
        exit();
    } else if(isset($_POST['comment']) && isset($_POST['text_comment']) &&!empty($_POST['text_comment'])){
        $book_id = $_POST['book_id'];
        $user_id = $_SESSION['user_id'];
        $text_comment = $_POST['text_comment'];
        $parent_id = $_POST['comment_id'];


        $stmt = $db->prepare('INSERT INTO comments (book_id, user_id, text, createdAt, parent_id) VALUES (?,?,?,NOW(),?)');
        $stmt->bind_param('iisi', $book_id, $user_id, $text_comment,$parent_id);
        $stmt->execute();

        if($stmt->affected_rows > 0)
        {
            header('Location: detail_product.php?book_id='. $book_id);
            $_SESSION['message'] = 'Comment added successfully';
        } else {
            echo 'Error adding comment';
            $_SESSION['message'] = 'Comment added unsuccessfully';
        }
    }
