<?php
    require_once '../../vendor/autoload.php'; 
    use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    session_start(); 
    require_once '../../database.php';
    $db = DBConfig::getDB();

    if(isset($_POST['submit-import'])) {

        $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 

        if(!empty($_FILES['fileimport']['name']) && in_array($_FILES['fileimport']['type'], $excelMimes)){ 
            if(is_uploaded_file($_FILES['fileimport']['tmp_name'])){
                $reader = new Xlsx(); 
                $spreadsheet = $reader->load($_FILES['fileimport']['tmp_name']); 
                $worksheet = $spreadsheet->getActiveSheet();  
                $worksheet_arr = $worksheet->toArray(); 
                unset($worksheet_arr[0]);
                foreach($worksheet_arr as $row){
                    if($row[0] != null || $row[0] != ''){

                        if(checkExistence($row[0])){
                            updateBook($row[0],$row[1],$row[2],$row[3],
                                $row[4],$row[5],$row[6],$row[7]);
                        } else {
                            echo 'test';
                            addBook($row[0],$row[1],$row[2],$row[3],
                                            $row[4],$row[5],$row[6],$row[7]);
                        }
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

    function checkExistence($name){
        $stmt = DBConfig::getDB()->prepare('SELECT * FROM books WHERE LOWER(title) =?');
        $stmt->bind_param('s', strtolower($name));
        $stmt->execute();

        $count = $stmt->get_result()->num_rows;

        return $count > 0;
    }

    function getBook($name){
        $stmt = DBConfig::getDB()->prepare('SELECT * FROM books WHERE LOWER(title) =?');
        $stmt->bind_param('s', strtolower($name));
        $stmt->execute();

        $book = $stmt->get_result()->fetch_assoc();

        return $book;
    }

    function addBook($title,$description,$category,$price,$authors,$quantity,$hotItem,$sale){
        $db = DBConfig::getDB();
        $category_id = checkCategoryExistence($category);
        echo $category_id;
        $quantity = intval($quantity);
        $price = floatval($price);
        $hotItem = intval($hotItem);
        $sale = floatval($sale);

        if($quantity == '' || $quantity == null || $quantity < 0){
            var_dump($quantity);
            $quantity = 0;
        }
        if($price == '' || $price < 1000.0 || $price == null) {
            $price = 1000.0;
        }

        if($hotItem == '' || $hotItem == null || $hotItem > 1 || $hotItem <0){
            $hotItem = 0;
        }

        if($sale == '' || $sale == null || $sale < 0.0 || $sale > 100.0){
            $sale = 0.0;
        }

        $stmt = $db->prepare('INSERT INTO books (title, description, category_id, price, stock, authors, created_at, hotItem, sale) 
                                VALUES (?,?,?,?,?,?, NOW(),?,?)');
        $stmt->bind_param('ssidisid', $title, $description, $category_id, $price, $quantity, $authors, $hotItem, $sale);
        $stmt->execute();

        $book_id = $stmt->insert_id;

        $stmt = $db->prepare('SELECT * FROM branch');
        $stmt->execute();
        $branches = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach($branches as $branch){
            $stmt = $db->prepare('INSERT INTO branchstockitem (book_id, branch_id, status,branch_select) values (?,?,1,0)');
            $stmt->bind_param('ii', $book_id, $branch['branch_id']);
            $stmt->execute();
        }

        
    }

    function updateBook($title,$description,$category,$price,$authors,$quantity,$hotItem,$sale){
        $book = getBook($title);
        $quantity = intval($quantity);
        $price = floatval($price);
        $hotItem = intval($hotItem);
        $sale = floatval($sale);

        if($quantity == '' || $quantity == null || $quantity < 0){
            var_dump($quantity);
            $quantity = 0;
        }
        if($price == '' || $price < 1000.0 || $price == null) {
            $price = 1000.0;
        }

        if($hotItem == '' || $hotItem == null || $hotItem > 1 || $hotItem <0){
            $hotItem = 0;
        }

        if($sale == '' || $sale == null || $sale < 0.0 || $sale > 100.0){
            $sale = 0.0;
        }
        $db = DBConfig::getDB();
        $category_id = checkCategoryExistence($category);

        $stmt = $db->prepare('UPDATE books set title = ?, description = ?, category_id = ? , price = ?, 
                                                stock = ?, authors = ?, updated_at = NOW(), hotItem = ?, sale = ?
                                                WHERE book_id = ?');
        $stmt->bind_param('ssidisidi', $title, $description, $category_id, $price, $quantity, $authors,$hotItem,$sale, $book['book_id']);
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


