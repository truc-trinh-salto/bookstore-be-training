<?php 
    session_start();
    require_once('../../database.php');

    if(isset($_GET['book_id']) && isset($_GET['branch_id']) && isset($_GET['action'])){
        $action = 0;
        if($_GET['action'] == 'in'){
            $action = 1;
        }

        $book_id = $_GET['book_id'];
        $branch_id = $_GET['branch_id'];

        $db = DBConfig::getDB();
        $stmt = $db->prepare('UPDATE branchstockitem SET status =? WHERE book_id =? AND branch_id =?');
        $stmt->bind_param('iii', $action, $book_id, $branch_id);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $_SESSION['message'] = "Cập nhật stock thành công";
        } else {
            $_SESSION['message'] = "Cập nhật stock thất bại";
        }
        
        if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }
?>