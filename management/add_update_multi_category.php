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
                $reader = new Xlsx(); 
                $spreadsheet = $reader->load($_FILES['fileimport']['tmp_name']); 
                $worksheet = $spreadsheet->getActiveSheet();  
                $worksheet_arr = $worksheet->toArray(); 
                unset($worksheet_arr[0]);
                foreach($worksheet_arr as $row){
                    if($row[0] != null || $row[0] != ''){
                        importCategory($row[0]);
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


    function importCategory($category){
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