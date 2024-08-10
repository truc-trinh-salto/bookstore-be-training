<?php 
    session_start();
    require_once('../database.php');

    $db = DBConfig::getDB();
    $sum_quantity = array_sum($_SESSION['qty_array_import']);
    echo $sum_quantity;
    if($sum_quantity > 0){
        $date = date('d-m-Y');
        $title = 'Nhập hàng ngày '. $date;
        $stmt = $db->prepare('INSERT INTO import(quantity,title,import) VALUES(?,?, CURRENT_TIMESTAMP)');
        $stmt->bind_param('is', $sum_quantity,$title);
        $stmt->execute();

        $import_id = $stmt->insert_id;
        foreach($_SESSION['import_item'] as $book_id){
            $index = array_search($book_id, $_SESSION['import_item']);
            $quantity = $_SESSION['qty_array_import'][$index];
    
                $stmt = $db->prepare('SELECT * FROM books WHERE book_id =?');
                $stmt->bind_param('i', $book_id);
                $stmt->execute();
                $stock_book = $stmt->get_result()->fetch_assoc();

                $new_stock = $stock_book['stock'] + $quantity;

                $stmt = $db->prepare('INSERT INTO import_item(import_id, book_id, quantity,stock,after_stock) VALUES(?, ?,?,?,?)');
                $stmt->bind_param('iiii', $import_id, $book_id, $quantity, $stock_book['stock'],$new_stock);
                $stmt->execute();

                $stmt = $db->prepare('UPDATE books SET stock =? WHERE book_id =?');
                $stmt->bind_param('ii', $new_stock, $book_id);
                $stmt->execute();
        }

        unset($_SESSION['import_item']);
        unset($_SESSION['qty_array_import']);
        header('Location: inventory.php');
        $_SESSION['message'] = 'Thực hiện nhập hàng thành công!';
    } else {
        $_SESSION['message'] = 'Thực hiện nhập hàng thất bại';
        header('Location: inventory.php');
    }


?>