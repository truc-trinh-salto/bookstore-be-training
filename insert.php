<?php
    session_start();
    require_once('database.php');
    $db = DBConfig::getDB();

    // $timestamp = strtotime(date('Y-m-d'));
    // $dateFrom = date('Y-m-01 00:00:00', $timestamp);
    // $dateTo  = date('Y-m-t 23:59:59', $timestamp);

    // $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
    //                                     b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category, 
    //                                     tt.total, s.after_stock
    //                                     FROM books as b 
    //                                     LEFT JOIN categories as c 
    //                                     ON b.category_id = c.category_id
    //                                     LEFT JOIN (SELECT SUM(od.quantity)as total, od.book_id
    //                                                 FROM order_detail as od 
    //                                                 LEFT JOIN order_item as oi
    //                                                 ON od.order_id = oi.id
    //                                                 LEFT JOIN transactions as t
    //                                                 on t.order_id = oi.id 
    //                                                 WHERE t.createdAt >= ? and t.createdAt <= ?
    //                                                 GROUP BY od.book_id) as tt
    //                                     ON tt.book_id = b.book_id

    //                                     LEFT JOIN (SELECT ii.book_id, ii.after_stock as after_stock
    //                                                 FROM import_item as ii
    //                                                 LEFT JOIN import as i
    //                                                 ON i.id = ii.import_id
    //                                                 WHERE YEAR(i.import) = YEAR(?) and MONTH(i.import) = MONTH(?)) as s
    //                                     ON s.book_id = b.book_id
    //                                     ORDER BY total DESC');
    //         $stmt->bind_param('ssss',$dateFrom,$dateTo,$dateFrom,$dateFrom);
    //         $stmt->execute();

    //         $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
    //         foreach($books as $book){
    //             $new_stock = $book['stock'] - $book['total'];
    //             $stmt = $db->prepare('UPDATE books set stock =? WHERE book_id = ? ');
    //             $stmt->bind_param('ii', $new_stock, $book['book_id']);
    //             $stmt->execute();
    //         }

    $a = '33b';
    $a = intval($a);
    var_dump($a);
    function addBookBranch(){
            $db = DBConfig::getDB();
            $stmt = $db->prepare('SELECT * FROM import_item WHERE import_id =?');
            $stmt->bind_param('i', 2);
            $stmt->execute();

            $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            foreach($items as $item){
                $stmt = $db->prepare('UPDATE books set stock = ? WHERE book_id =?');
                $stmt->bind_param('ii',$item['quantity'],$item['book_id'] );
                $stmt->execute();
            }
            
        }
