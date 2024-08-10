<?php
    session_start();
    require_once('database.php');
    $db = DBConfig::getDB();

    addBookBranch(4);

    function addBookBranch($branch_id){
        $db = DBConfig::getDB();
        for($i = 3;$i <= 52; $i++){
            $stmt = $db->prepare('UPDATE import_item set after_stock = stock WHERE id =?');
            $stmt->bind_param('i', $i);
            $stmt->execute();
        }
        
    }
?>