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
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;



session_start();

class CategoryService {

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
    
    public function showCategoryManagementPage($page, $limit,$searchKeyword){
        
        $number_page = CategoryRepository::getInstance()->getNumberPageOfCategoryManagementPage($searchKeyword,$limit);

        $categories = CategoryRepository::getInstance()->getAllByCategoryPagination($searchKeyword,$page, $limit);

        $categories_result = CategoryRepository::getInstance()->getTotalBooksOfQuantity($categories);

        return ['number_page' => $number_page,'categories' => $categories_result];
    }

    public function addNewCategory($categoryName){
        if(!CategoryRepository::getInstance()->checkExistenceCategory($categoryName)){
            $isAddedCategory = CategoryRepository::getInstance()->addNewCategory($categoryName);
            if($isAddedCategory)
            {
                $_SESSION['message'] = 'Thêm thể loại mới thành công';
            }
            else
            {
                $_SESSION['message'] = 'Thêm thể loại mới thất bại';
            }
        } else {
            $_SESSION['message'] = 'Thể loại đã tồn tại';
        }
    }

    public function deleteCategory($categoryId){
        $isDeletedCategory = CategoryRepository::getInstance()->deleteById($categoryId);
        if($isDeletedCategory) {
            $_SESSION['message'] = 'Category deleted successfully!';
        } else {
            $_SESSION['message'] = 'Failed to delete category!';
        }
    }

    public function addCategoryByFile($file){
        $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 

        if(!empty($file['fileimport']['name']) && in_array($file['fileimport']['type'], $excelMimes)){ 
            if(is_uploaded_file($file['fileimport']['tmp_name'])){
                $reader = new Xlsx(); 
                $spreadsheet = $reader->load($file['fileimport']['tmp_name']); 
                $worksheet = $spreadsheet->getActiveSheet();  
                $worksheet_arr = $worksheet->toArray(); 
                unset($worksheet_arr[0]);
                foreach($worksheet_arr as $row){
                    if($row[0] != null || $row[0] != ''){
                        CategoryRepository::getInstance()->findCategoryExistence($row[0]);
                    }
                }
                $_SESSION['message'] = 'Nhập dữ liệu thành công';
            } else {
                $_SESSION['message'] = 'Nhập dữ liệu thất bại';
            }
        } else {
            $_SESSION['message'] = 'Nhập dữ liệu thất bại';
        }
    }

    public function showEditCategoryPage($categoryId){

        $category = CategoryRepository::getInstance()->findByCategoryId($categoryId);
        return ['category'=>$category];
    }

    public function editCategory($categoryId,$categoryName){
        if(!CategoryRepository::getInstance()->checkExistenceCategory($categoryName)){
            $isUpdatedCategory = CategoryRepository::getInstance()->updateCategory($categoryId,$categoryName);

            if($isUpdatedCategory)
            {
                $_SESSION['message'] = 'Cập nhật thành công';
            }
            else
            {
                $_SESSION['message'] = 'Cập nhật thất bại';
            }
        } else {
            $_SESSION['message'] = 'Tên thể loại đã tồn tại';
        }
    }

    public function showProductOfCategoryManagmentPage($categoryId, $page, $limit, $searchKeyword){

        $number_page = BookRepository::getInstance()->getNumberPageOfDetailCategoryManagmentPage($categoryId,$searchKeyword,$limit);

        $books = BookRepository::getInstance()->getAllByDetailCategoryManagementPage($categoryId,$searchKeyword,$page,$limit);

        $books_result = GalleryImageRepository::getInstance()->getImageBooks($books);

        return ['number_page' => $number_page,'books' => $books_result];
    }

}

