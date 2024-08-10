<?php 
    session_start();
    require_once('../database.php');

    $db = DBConfig::getDB();

    if(isset($_POST['submit'])){
        $book_id = $_POST['book_id'];
        echo $book_id;
        $branch_select = $_POST['branch_select'];
        echo $branch_select;

        $stmt = $db->prepare("UPDATE branchstockitem SET branch_select = 0 where book_id = ?");
        $stmt->bind_param('i',$book_id);
        $stmt->execute();

        $stmt = $db->prepare("UPDATE branchstockitem SET branch_select = 1 where book_id = ? and branch_id = ?");
        $stmt->bind_param('ii',$book_id,$branch_select);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $_SESSION['message'] = "Chọn nơi xuất kho thành công";
        } else {
            $_SESSION['message'] = "Chọn nơi xuất kho thất bại";
        }

        if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }
?>