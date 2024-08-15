<?php
    require_once '../vendor/autoload.php'; 
    use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    session_start(); 
    require_once '../database.php';
    $db = DBConfig::getDB();

    if(isset($_POST['submit-import'])) {

        $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 

        if(!empty($_FILES['fileimport']['name']) && in_array($_FILES['fileimport']['type'], $excelMimes)){ 
            if(is_uploaded_file($_FILES['fileimport']['tmp_name'])){
                // echo 'test';
                $reader = new Xlsx(); 
                $spreadsheet = $reader->load($_FILES['fileimport']['tmp_name']); 
                $worksheet = $spreadsheet->getActiveSheet();  
                $worksheet_arr = $worksheet->toArray(); 
                unset($worksheet_arr[0]);
                foreach($worksheet_arr as $row){
                    if(checkExistence($row[0])){
                        updateBook($row[0],$row[1],$row[2],$row[3],
                            $row[4],$row[5],$row[6],$row[7],$row[8]);
                    } else {
                        addBook($row[0],$row[1],$row[2],$row[3],
                                        $row[4],$row[5],$row[6],$row[7],$row[8]);
                    }
                }

                $_SESSION['message'] = 'Nhập dữ liệu thành công';
                header('Location: '.$_SERVER['HTTP_REFERER']);
            } else {
                $_SESSION['message'] = 'Nhập dữ liệu thất bại';
                header('Location: '.$_SERVER['HTTP_REFERER']);
            }
        } else {
            $_SESSION['message'] = 'Nhập dữ liệu thất bại';
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }

    } else {
        $_SESSION['message'] = 'Nhập dữ liệu thất bại';
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    function checkExistence($book_id){
        $stmt = DBConfig::getDB()->prepare('SELECT * FROM books WHERE book_id =?');
        $stmt->bind_param('i', $book_id);
        $stmt->execute();

        $count = $stmt->get_result()->num_rows;

        return $count > 0;
    }

    function addBook($book_id,$title,$description,$category,$price,$authors,$quantity,$hotItem,$sale){
        $db = DBConfig::getDB();
        $category_id = checkCategoryExistence($category);
        if($hotItem == '' || $hotItem == null){
            $hotItem = 0;
        }

        if($sale == '' || $sale == null){
            $sale = 0;
        }

        $stmt = $db->prepare('INSERT INTO books (book_id, title, description, category_id, price, stock, authors, created_at, hotItem, sale) 
                                VALUES (?,?,?,?,?,?,?, NOW(),?,?)');
        $stmt->bind_param('issidisid', $book_id, $title, $description, $category_id, $price, $quantity, $authors, $hotItem, $sale);
        $stmt->execute();


    }

    function updateBook($book_id,$title,$description,$category,$price,$authors,$quantity,$hotItem,$sale){
        if($hotItem == '' || $hotItem == null){
            $hotItem = 0;
        }

        if($sale == '' || $sale == null){
            $sale = 0;
        }
        $db = DBConfig::getDB();
        $category_id = checkCategoryExistence($category);

        $stmt = $db->prepare('UPDATE books set title = ?, description = ?, category_id = ? , price = ?, 
                                                stock = ?, authors = ?, updated_at = NOW(), hotItem = ?, sale = ?
                                                WHERE book_id = ?');
        $stmt->bind_param('ssidisidi', $title, $description, $category_id, $price, $quantity, $authors,$hotItem,$sale, $book_id);
        $stmt->execute();

        
    }

    function checkCategoryExistence($category){
        $db = DBConfig::getDB();
        $stmt = $db->prepare('SELECT * FROM categories WHERE LOWER(name_category) =?');
        $stmt->bind_param('s', strtolower($category));
        $stmt->execute();

        $category_select = $stmt->get_result()->fetch_assoc();
        if($category_select){
            return $category_select['category_id'];
        } else {
            $stmt = $db->prepare('INSERT INTO categories (name_category) VALUES (?)');
            $stmt->bind_param('s', $category);
            $stmt->execute();
            return $db->insert_id;
        }
    }


?>