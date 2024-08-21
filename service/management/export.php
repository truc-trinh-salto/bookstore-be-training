<?php
    session_start();
    require_once('../../database.php');
    require '../../vendor/autoload.php'; // Include Composer's autoloader

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $db = DBConfig::getDB();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set the header of the Excel file
    $headers = array('ID', 'Tên sách', 'Tác giả', 'Số Lượng', 'Thể loại', 'Giá bán', 'Số lượng đã bán');
    $sheet->fromArray($headers, NULL, 'A1');

    $date = $_GET['date_select'];
    if ($date != null) {
        $timestamp = strtotime($date);
    } else {
        $timestamp = strtotime(date('Y-m-d'));
    }

    $dateFrom = date('Y-m-01 00:00:00', $timestamp);
    $dateTo  = date('Y-m-t 23:59:59', $timestamp);

    $stmt = $db->prepare('SELECT b.title, b.book_id, b.stock, b.authors, c.name_category, b.price, tt.total
                            FROM books as b 
                            LEFT JOIN categories as c 
                            ON b.category_id = c.category_id
                            LEFT JOIN (SELECT SUM(od.quantity) as total, od.book_id
                                       FROM order_detail as od 
                                       LEFT JOIN order_item as oi
                                       ON od.order_id = oi.id
                                       LEFT JOIN transactions as t
                                       ON t.order_id = oi.id 
                                       WHERE t.createdAt >= ? and t.createdAt <= ?
                                       GROUP BY od.book_id) as tt
                            ON tt.book_id = b.book_id
                            ORDER BY total DESC');
    $stmt->bind_param('ss', $dateFrom, $dateTo);
    $stmt->execute();

    $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Populate the data into the spreadsheet
    $rowNum = 2; // Start from the second row since the first row is the header
    foreach ($books as $book) {
        $sheet->setCellValue('A' . $rowNum, $book['book_id']);
        $sheet->setCellValue('B' . $rowNum, $book['title']);
        $sheet->setCellValue('C' . $rowNum, $book['authors']);
        $sheet->setCellValue('D' . $rowNum, $book['stock']);
        $sheet->setCellValue('E' . $rowNum, $book['name_category']);
        $sheet->setCellValue('F' . $rowNum, $book['price']);
        $sheet->setCellValue('G' . $rowNum, $book['total']);
        $rowNum++;
    }

    // Generate the Excel file
    $fileName = "codexworld_export_data-" . date('Ymd') . ".xlsx";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$fileName\"");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    exit();
?>
