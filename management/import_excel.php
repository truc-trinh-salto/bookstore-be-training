<?php
    require_once '../vendor/autoload.php'; 
    use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    session_start(); 
    // echo 'test';
    // echo $_FILES['file']['tmp_name'];
    if(isset($_POST['submit-import'])) {
        // echo 'test';
        // echo $_FILES['file']['tmp_name'];
        $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 

        if(!empty($_FILES['fileimport']['name']) && in_array($_FILES['fileimport']['type'], $excelMimes)){ 
            if(is_uploaded_file($_FILES['fileimport']['tmp_name'])){
                $reader = new Xlsx(); 
                $spreadsheet = $reader->load($_FILES['fileimport']['tmp_name']); 
                $worksheet = $spreadsheet->getActiveSheet();  
                $worksheet_arr = $worksheet->toArray(); 
                unset($worksheet_arr[0]);
                foreach($worksheet_arr as $row){
                    $index = array_search($row[0], $_SESSION['import_item']);
                    $_SESSION['qty_array_import'][$index] = $row[1];
                    
                }
                header('Location: import.php');
            }
        }
        header('Location: import.php');
    }
    header('Location: import.php');
?>