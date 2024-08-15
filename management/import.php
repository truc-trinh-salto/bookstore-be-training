<?php
    session_start();
    require_once('../database.php');
    require_once('../books.php');
    $date = date('d-m-Y');

    $db = DBConfig::getDB();

    $stmt = $db->prepare('SELECT * FROM books');
    $stmt->execute();
    $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);



    $title = 'Nhập hàng ngày '. $date;
    $stmt = $db->prepare('INSERT INTO import(quantity,title,import,status) VALUES(0,?, CURRENT_TIMESTAMP,0)');
    $stmt->bind_param('s', $title);
    $stmt->execute();
    $import_id = $stmt->insert_id;


    foreach($books as $book){
        $stmt = $db->prepare('INSERT INTO import_item(import_id, book_id, quantity,stock,after_stock) VALUES(?,?,0,?,?)');
        $stmt->bind_param('iiii', $import_id, $book['book_id'], $book['stock'],$book['stock']);
        $stmt->execute();
    }

    header('Location: detail_import.php?import_id='.$import_id);

    