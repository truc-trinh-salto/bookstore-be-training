<?php
    session_start();
    require_once('../../database.php');
    $db = DBConfig::getDB();

    function filterData(&$str){ 
        $str = preg_replace("/\t/", "\\t", $str); 
        $str = preg_replace("/\r?\n/", "\\n", $str); 
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
    }

    $fileName = "codexworld_export_data-" . date('Ymd') . ".csv"; 

    $fileds = array('ID','Tên sách','Tác giả','Só Lượng','Thể loại','Giá bán','Số lượng đã bán');

    $excelData = implode("\t", array_values($fileds)). "\n"; 

    $date = $_GET['date_select'];
    if($date != null){
        $timestamp = strtotime($date);
    } else {
        $timestamp = strtotime(date('Y-m-d'));
    }

    $dateFrom = date('Y-m-01 00:00:00', $timestamp);
    $dateTo  = date('Y-m-t 23:59:59', $timestamp);

    $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category, tt.total
                                        FROM books as b 
                                        LEFT JOIN categories as c 
                                        ON b.category_id = c.category_id
                                        LEFT JOIN (SELECT SUM(od.quantity)as total, od.book_id
                                                    FROM order_detail as od 
                                                    LEFT JOIN order_item as oi
                                                    ON od.order_id = oi.id
                                                    LEFT JOIN transactions as t
                                                    on t.order_id = oi.id 
                                                    WHERE t.createdAt >= ? and t.createdAt <= ?
                                                    GROUP BY od.book_id) as tt
                                        ON tt.book_id = b.book_id
                                        ORDER BY total DESC');
    $stmt->bind_param('ss',$dateFrom,$dateTo);
    $stmt->execute();

    $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    foreach($books as $book){
        $lineData = array($book['book_id'],$book['title'],$book['authors'],$book['stock'],$book['name_category'],$book['price'],$book['total']);
        array_walk($lineData, 'filterData');
        $excelData .= implode("\t", array_values($lineData)). "\n"; 

    }

    header("Content-Disposition: attachment; filename=\"$fileName\""); 
    header("Content-Transfer-Encoding: binary");
    header("Content-Type: application/vnd.ms-excel"); 

    echo chr(0xEF);
    echo chr(0xBB);
    echo chr(0xBF);

    echo $excelData; 

    exit();
?>