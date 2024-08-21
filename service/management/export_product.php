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
    $headers = array('Tên sách', 'Mô tả', 'Thể loại', 'Giá bán', 'Tác giả', 'Số lượng', 'Hiện trang chủ','Giảm giá');
    $sheet->fromArray($headers, NULL, 'A1');

    $date = $_GET['date_select'];
    if ($date != null) {
        $timestamp = strtotime($date);
    } else {
        $timestamp = strtotime(date('Y-m-d'));
    }

    $dateFrom = date('Y-m-01 00:00:00', $timestamp);
    $dateTo  = date('Y-m-t 23:59:59', $timestamp);

    $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                            b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category
                            FROM books as b 
                            LEFT JOIN categories as c 
                            ON b.category_id = c.category_id 
                            ORDER BY b.book_id');
    $stmt->execute();

    $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Populate the data into the spreadsheet
    $rowNum = 2; // Start from the second row since the first row is the header
    foreach ($books as $book) {
        $sheet->setCellValue('A' . $rowNum, $book['title']);
        $sheet->setCellValue('B' . $rowNum, $book['description']);
        $sheet->setCellValue('C' . $rowNum, $book['name_category']);
        $sheet->setCellValue('D' . $rowNum, $book['price']);
        $sheet->setCellValue('E' . $rowNum, $book['authors']);
        $sheet->setCellValue('F' . $rowNum, $book['stock']);
        $sheet->setCellValue('G' . $rowNum, $book['hotItem']);
        $sheet->setCellValue('H' . $rowNum, $book['sale']);
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
