<?php
    require_once '../../vendor/autoload.php'; 
    use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    session_start(); 
    require_once '../../database.php';
    $db = DBConfig::getDB();

    if(isset($_POST['submit-import'])) {
        $import_id = $_POST['import_id'];
        // echo $import_id;

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
                    if($row[0] != null && $row[0] != ''){
                        if(checkExistence($row[0])){
                            import_quantity($row[0], $row[6], $import_id);
                        } else {
                            addMoreImport($row[1],$row[2],$row[3],
                                            $row[4],$row[5],$row[6], $import_id);
                        }
                    }
                }
                header('Location: '.$_SERVER['HTTP_REFERER']);
            }
        }
        header('Location: '.$_SERVER['HTTP_REFERER']);

    }
    header('Location: '.$_SERVER['HTTP_REFERER']);

    function import_quantity($book_id, $quantity, $import_id){
        $quantity = intval($quantity);

        if($quantity == '' || $quantity == null || $quantity < 0){
            var_dump($quantity);
            $quantity = 0;
        }

        $db = DBConfig::getDB();
        $stmt = $db->prepare('SELECT * FROM books WHERE book_id =?');
        $stmt->bind_param('i', $book_id);
        $stmt->execute();

        $stock_book = $stmt->get_result()->fetch_assoc();

        $stmt = $db->prepare('SELECT * FROM import_item WHERE book_id =? AND import_id =?');
        $stmt->bind_param('ii', $book_id, $import_id);
        $stmt->execute();

        // $new_stock = $stock_book['stock'] + $quantity;

        $old_import_item = $stmt->get_result()->fetch_assoc();
        if($old_import_item){
            $distance = $quantity - $old_import_item['quantity'];
            $new_stock = $stock_book['stock'] + $distance;
            $stmt = $db->prepare('UPDATE import_item set quantity = ?, after_stock = ? where import_id =? AND book_id =?');
            $stmt->bind_param('iiii', $quantity, $new_stock, $import_id, $book_id);
            $stmt->execute();

        } else {
            $distance = $quantity;
            $new_stock = $stock_book['stock'] + $distance;
            $stmt = $db->prepare('INSERT INTO import_item (book_id, import_id, quantity, stock, after_stock) VALUES (?,?,?,?,?)');
            $stmt->bind_param('iiiii', $book_id, $import_id, $quantity, $stock_book['stock'], $new_stock);
            $stmt->execute();

        }

        $stmt = $db->prepare('UPDATE import SET quantity = quantity + ? WHERE id =?');
        $stmt->bind_param('ii',$distance, $import_id);
        $stmt->execute();


        $stmt = $db->prepare('UPDATE books SET stock =? WHERE book_id =?');
        $stmt->bind_param('ii', $new_stock, $book_id);
        $stmt->execute();
        
    } 

    function checkExistence($book_id){
        $stmt = DBConfig::getDB()->prepare('SELECT * FROM books WHERE book_id =?');
        $stmt->bind_param('i', $book_id);
        $stmt->execute();

        $count = $stmt->get_result()->num_rows;

        return $count > 0;
    }

    function addMoreImport($title,$description,$category,$price,$authors,$quantity, $import_id){
        $db = DBConfig::getDB();
        $category_id = checkCategoryExistence($category);

        $stmt = $db->prepare('INSERT INTO books (title, description, category_id, price, stock, authors, created_at, hotItem) 
                                VALUES (?,?,?,?,?,?, NOW(),0)');
        $stmt->bind_param('ssidis', $title, $description, $category_id, $price, $quantity, $authors);
        $stmt->execute();

        $inserted_book_id = $db->insert_id;

        if($inserted_book_id){
            $stmt = $db->prepare('INSERT INTO import_item (book_id, import_id, quantity, stock, after_stock) VALUES (?,?,?,0,?)');
            $stmt->bind_param('iiii', $inserted_book_id, $import_id, $quantity, $quantity);
            $stmt->execute();

            $stmt = $db->prepare('UPDATE import SET quantity = quantity + ? WHERE id =?');
            $stmt->bind_param('ii',$quantity, $import_id);
            $stmt->execute();

            $stmt = $db->prepare('SELECT * FROM branch');
            $stmt->execute();
            $branches = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            foreach($branches as $branch){
                $stmt = $db->prepare('INSERT INTO branchstockitem (book_id, branch_id, status,branch_select) values (?,?,1,0)');
                $stmt->bind_param('ii', $inserted_book_id, $branch['branch_id']);
                $stmt->execute();
            }
        }
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


