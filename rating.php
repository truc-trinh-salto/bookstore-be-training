<?php
    session_start();
    require_once('database.php');
    if(!$_SESSION['user_id']){
        header('Location: index.php');
        exit();
    } else if(isset($_POST['submit']) && isset($_POST['rating'])){
        $user_id = $_SESSION['user_id'];
        $rating = $_POST['rating'];
        $book_id = $_POST['book_id_rate'];
        
        $db = DBConfig::getDB();
        $stmt = $db->prepare("SELECT * FROM rate where user_id =? AND book_id =?");
        $stmt->bind_param("ii", $user_id, $book_id);
        $stmt->execute();


        $count = $stmt->get_result()->num_rows;
        if($count > 0){
            $stmt = $db->prepare('UPDATE rate SET value = ? WHERE user_id =? AND book_id =?');
            $stmt->bind_param('iii', $rating, $user_id, $book_id);
            $stmt->execute();

            if($stmt->affected_rows > 0){
                header('Location: detail_product.php?book_id='. $book_id);
                $_SESSION['message'] = 'Rating added successfully';
            } else {
                echo 'Error adding rating';
                $_SESSION['message'] = 'Rating added unsuccessfully';
            }
        } else {

            $stmt= $db->prepare('INSERT INTO rate (user_id, book_id, value) VALUES (?,?,?)');
            $stmt->bind_param('iii', $user_id, $book_id, $rating);
            $stmt->execute();

            if($stmt->affected_rows > 0){
                header('Location: detail_product.php?book_id='. $book_id);
                $_SESSION['message'] = 'Rating added successfully';
            } else {
                echo 'Error adding rating';
                $_SESSION['message'] = 'Rating added unsuccessfully';
            }
        }
    }
?>