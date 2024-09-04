<?php
namespace MVC\Services;

use MVC\Repository\BookRepository;
use MVC\Repository\BranchRepository;
use MVC\Repository\CategoryRepository;
use MVC\Repository\CodesaleRepository;
use MVC\Repository\GalleryImageRepository;
use MVC\Repository\CommentRepository;
use MVC\Repository\OrderRepository;
use MVC\Repository\RatingRepository;
use MVC\Repository\RouteRepository;
use MVC\Repository\TransportRepository;
use MVC\Repository\TransactionRepository;
use MVC\Repository\ImportRepository;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;



session_start();

class ImportService {

    private static $instance;
    private function __construct(){}
    private function __clone(){}

    public static function getInstance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname;
        }
        return self::$instance;
    }

    public function showInventoryManagement($searchKeyword,$page,$limit){
        $number_page = ImportRepository::getInstance()->getNumberPageOfInventoryManagementPage($searchKeyword,$limit);

        $imports = ImportRepository::getInstance()->getAllByInventoryManagementPagination($searchKeyword,$page,$limit);

        return ['number_page'=> $number_page,'imports' => $imports];
    }

    public function showDetailInventoryManagement($importId,$searchKeyword,$page,$limit){
        $number_page = BookRepository::getInstance()->getNumberPageOfDetailInventoryManagementPage($importId,$searchKeyword,$limit);

        $books = BookRepository::getInstance()->getAllByDetailInventoryManagementPagination($importId,$searchKeyword,$page,$limit);

        $books_result = GalleryImageRepository::getInstance()->getImageBooks($books);

        $import = ImportRepository::getInstance()->findById($importId);

        return ['number_page'=> $number_page,'books' => $books_result, 'import' => $import];
    }

    public function addNewInventory(){
        $books = BookRepository::getInstance()->getAllBooks();

        $importId = ImportRepository::getInstance()->addImport($books);

        return $importId;
    }

    public function deleteInventory($importId){
        ImportRepository::getInstance()->deleteImportById($importId);
    }

    public function updateQuantityInventory($bookId,$importId,$quantity){

        $book = ImportRepository::getInstance()->findImportDetailByBookIdAndImportId($bookId, $importId);

        if($bookId != null && $quantity != null && $importId != null){
            if($quantity < 0){
                $quantity = 0;
            }
    
            $distanceQuantity = abs($quantity - $book['quantity']);
    
            $newAfterStock = $book['stock'] + $quantity;
            $newQuantity = $quantity;
    
            $isUpdatedItem = ImportRepository::getInstance()->updateImportDetail($newAfterStock,$newQuantity,$bookId,$importId);
    
            if($isUpdatedItem){

                $oldStock = BookRepository::getInstance()->findById($bookId);

                $updateStockBook = $quantity < $book['quantity'] ? $oldStock['stock'] - $distanceQuantity : $oldStock['stock'] + $distanceQuantity;

                BookRepository::getInstance()->updateStockForInventory($bookId,$updateStockBook);

                ImportRepository::getInstance()->updateQuantityInventory($quantity - $book['quantity'],$importId);
    
                return ['status' => true,'quantity' => $newQuantity, 'new_after_stock' => $newAfterStock];
            } else {
                return ['status' => true,'quantity' => $quantity, 'new_after_stock' => $book['after_stock']];
            }
        } else {
            return ['status' => true,'quantity' => $quantity, 'new_after_stock' => $book['after_stock']];
        }
    }

    public function confirmImport($importId){
        $isUpdated = ImportRepository::getInstance()->updateStatusImport($importId);

        if($isUpdated){
            $_SESSION['message'] = 'Thực hiện nhập hàng thành công!';
        } else {
            $_SESSION['message'] = 'Thực hiện nhập hàng thất bại';
        }
    }

    public function importFile($importId,$file){
        if($importId != null) {

            $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
    
            if(!empty($file['fileimport']['name']) && in_array($file['fileimport']['type'], $excelMimes)){ 
                if(is_uploaded_file($file['fileimport']['tmp_name'])){
                    // echo 'test';
                    $reader = new XlsxReader(); 
                    $spreadsheet = $reader->load($file['fileimport']['tmp_name']); 
                    $worksheet = $spreadsheet->getActiveSheet();  
                    $worksheet_arr = $worksheet->toArray(); 
                    unset($worksheet_arr[0]);
                    foreach($worksheet_arr as $row){
                        if($row[0] != null && $row[0] != ''){
                            if(BookRepository::getInstance()->checkExistencById($row[0])){
                                $this->importQuantity($row[0], $row[6], $importId);
                            } else {
                                $this->addMoreImport($row[1],$row[2],$row[3],
                                                $row[4],$row[5],$row[6], $importId);
                            }
                        }
                    }
                    $_SESSION['message'] = 'File import thành công';
                } else {
                    $_SESSION['message'] = 'File import không tải lên!';
                }
            } else {
                $_SESSION['message'] = 'File import không đúng định dạng!';
            }
        } else {
            $_SESSION['message'] = 'File import thất bại!';
        }
    }

    public function importQuantity($bookId, $quantity, $importId){
        $quantity = intval($quantity);

        if($quantity == '' || $quantity == null || $quantity < 0){
            $quantity = 0;
        }

        $stockBook = BookRepository::getInstance()->findById($bookId);

        $oldImportItem = ImportRepository::getInstance()->findImportDetailByBookIdAndImportId($bookId,$importId);
        if($oldImportItem){
            $distance = $quantity - $oldImportItem['quantity'];
            $newAfterStock = $stockBook['stock'] + $distance;

            ImportRepository::getInstance()->updateImportDetail($newAfterStock,$quantity,$bookId,$importId);

        } else {
            $distance = $quantity;
            $newAfterStock = $stockBook['stock'] + $distance;

            ImportRepository::getInstance()->addImportDetail($bookId,$importId,$quantity,$stockBook['stock'],$newAfterStock);

        }

        ImportRepository::getInstance()->updateQuantityInventory($distance,$importId);

        BookRepository::getInstance()->updateStockForInventory($bookId,$newAfterStock);

    } 

    public function addMoreImport($title,$description,$category,$price,$authors,$quantity, $importId){
        $categoryId = CategoryRepository::getInstance()->checkExistenceCategory($category);

        $bookId = BookRepository::getInstance()->addNewBook($title,$quantity,$price,0,$categoryId,$authors,$description,0);

        if($bookId){

            ImportRepository::getInstance()->addImportDetail($bookId,$importId,$quantity,0,$quantity);
            ImportRepository::getInstance()->updateQuantityInventory($quantity,$importId);

        }
    }

    public function exportFile($importId){

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the header of the Excel file
        $headers = array('ID','Tên sách', 'Tác giả', 'Số Lượng', 'Thể loại', 'Giá bán', 'Số lượng nhập', 'Số lượng còn','Số lượng sau nhập');
        $sheet->fromArray($headers, NULL, 'A1');


        $books = BookRepository::getInstance()->getAllForImportByImportId($importId);

        // Populate the data into the spreadsheet
        $rowNum = 2; // Start from the second row since the first row is the header
        foreach ($books as $book) {
            $sheet->setCellValue('A' . $rowNum, $book['book_id']);
            $sheet->setCellValue('B' . $rowNum, $book['title']);
            $sheet->setCellValue('C' . $rowNum, $book['authors']);
            $sheet->setCellValue('D' . $rowNum, $book['stock']);
            $sheet->setCellValue('E' . $rowNum, $book['name_category']);
            $sheet->setCellValue('F' . $rowNum, $book['price']);
            $sheet->setCellValue('G' . $rowNum, $book['quantity']);
            $sheet->setCellValue('H' . $rowNum, $book['before_import']);
            $sheet->setCellValue('I' . $rowNum, $book['after_stock']);
            $rowNum++;
        }

        // Generate the Excel file
        $fileName = "codexworld_export_data-" . date('Ymd') . ".xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $writer = new XlsxWriter($spreadsheet);
        $writer->save('php://output');

        exit();
    }
    
    
}

