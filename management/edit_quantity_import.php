<?php 
    session_start();
    require_once('../database.php');
    $db = DBConfig::getDB();
    if(isset($_POST['quantity']) && isset($_POST['book_id']) && isset($_POST['import_id'])){
        $quantity = $_POST['quantity'];
        if($quantity < 0){
            $quantity = 0;
        }
        $book_id = $_POST['book_id'];
        $import_id = $_POST['import_id'];

        $db = DBConfig::getDB();
        $stmt = $db->prepare('SELECT * FROM import_item WHERE book_id =? AND import_id =?');
        $stmt->bind_param('ii', $book_id, $import_id);
        $stmt->execute();

        $book = $stmt->get_result()->fetch_assoc();

        $distance_quantity = abs($quantity - $book['quantity']);

        $new_after_stock = $book['stock'] + $quantity;
        $new_quantity = $quantity;

        $stmt = $db->prepare('UPDATE import_item SET after_stock =?, quantity =? WHERE book_id =? AND import_id =?');
        $stmt->bind_param('iiii', $new_after_stock, $new_quantity, $book_id, $import_id);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $stmt = $db->prepare('SELECT * FROM books WHERE book_id =?');
            $stmt->bind_param('i', $book_id);
            $stmt->execute();
            $old_stock = $stmt->get_result()->fetch_assoc();
            $update_stock_book = $quantity < $book['quantity'] ? $old_stock['stock'] - $distance_quantity : $old_stock['stock'] + $distance_quantity;

            $stmt = $db->prepare('UPDATE books SET stock = ? WHERE book_id =?');
            $stmt->bind_param('ii', $update_stock_book, $book_id);
            $stmt->execute();

            if($quantity < $book['quantity']){
                $stmt = $db->prepare('UPDATE import SET quantity = quantity - ? WHERE id =?');
            } else {
                $stmt = $db->prepare('UPDATE import SET quantity = quantity + ? WHERE id =?');
            }
            $stmt->bind_param('ii', $distance_quantity, $import_id);

            $stmt->execute();

            echo json_encode(['status' => true,'quantity' => $new_quantity, 'new_after_stock' => $new_after_stock]);
        } else {
            echo json_encode(['status' => true,'quantity' => $quantity, 'new_after_stock' => $book['after_stock']]);
        }

    }
