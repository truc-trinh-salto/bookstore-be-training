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


session_start();

class BranchService {

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
    
    public function showStoreSystemPage(){
        $branches = BranchRepository::getInstance()->getAll();

        $categories = CategoryRepository::getInstance()->getAllCategories();

        $cartArray = $_SESSION['cart'];

        if(count($cartArray) > 0){
            $books_cart = BookRepository::getInstance()->getAllInCart($cartArray);
            $carts = GalleryImageRepository::getInstance()->getImageBooks($books_cart);
        }

        return ['categories' => $categories,'branches' => $branches,
                'book_cart' => $carts];
    }

    public function showBranchManagementPage($searchKeyword){
        $branches = BranchRepository::getInstance()->getAllByManagementPage($searchKeyword);
        return ['branches' => $branches];
    }

    public function showEditBranchPage($branchId){
        $branch = BranchRepository::getInstance()->findById($branchId);
        return ['branch' => $branch];
    }

    public function showDetailOfBranchPage($branchId,$searchKeyword,$page,$limit){
        $number_page = BookRepository::getInstance()->getNumberPageOfDetailBranchManagementPage($branchId,$searchKeyword,$limit);

        $books = BookRepository::getInstance()->getAllByDetailBranchManagementPage($branchId,$searchKeyword,$page,$limit);

        $booksResult = GalleryImageRepository::getInstance()->getImageBooks($books);

        return ['number_page'=> $number_page,'books'=>$booksResult];
    }

    public function editBranchSelectWareHouse($bookId,$branchId){

        $isUpdateBranchSelect = BranchRepository::getInstance()->updateBranchSelect($bookId,$branchId);

        if($isUpdateBranchSelect){
            $_SESSION['message'] = "Chọn nơi xuất kho thành công";
        } else {
            $_SESSION['message'] = "Chọn nơi xuất kho thất bại";
        }

    }

    public function actionStock($bookId,$branchId,$action){
        $isUpdateBranchStock = BranchRepository::getInstance()->updateBranchStock($bookId,$branchId,$action);
        if($isUpdateBranchStock){
            $_SESSION['message'] = "Cập nhật stock thành công";
        } else {
            $_SESSION['message'] = "Cập nhật stock thất bại";
        }
    
    }

    public function addNewBranch($name, $address, $hotline, $image){
        if(!BranchRepository::getInstance()->checkExistence($name)){
            $target_file = '';
            if(isset($image["book-image"]["name"]) && $image["book-image"]["name"] != null){
                $target_dir = "public/assets/img/";
                $target_file = $target_dir . basename($image["book-image"]["name"]);
        
                echo $target_file;
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
                // Kiểm tra file có phải là hình ảnh thật hay không
                $check = getimagesize($image["book-image"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                } else {
                    $_SESSION['message'] = "File is not an image.";
                    $uploadOk = 0;
                }
        
                // Kiểm tra nếu file đã tồn tại
                if (file_exists($target_file)) {
                    // echo "Sorry, file already exists.";
                    // $uploadOk = 0;
                } else {
                    move_uploaded_file($image["book-image"]["tmp_name"], $target_dir);
                }
        
                // Giới hạn kích thước file
                if ($image["image"]["size"] > 500000) {
                    $_SESSION['message'] = "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
        
                // Giới hạn loại file
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                    $_SESSION['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }
        
                // Kiểm tra nếu $uploadOk là 0 do có lỗi
                if ($uploadOk == 0) {
                    $_SESSION['message'] .= "<br>Add Product failed, please try again.";
                    exit();
                // Nếu mọi thứ đều ổn, thử upload file
                } else {
                    if(BranchRepository::getInstance()->addBranch($name, $address, $hotline, $target_file)){
                        $_SESSION['message'] = 'Thêm chi nhánh mới thành công';
                    } else {
                        $_SESSION['message'] = 'Thêm chi nhánh mới thất bại';
                    
                    }
                }
            } else {
                if(BranchRepository::getInstance()->addBranch($name, $address, $hotline, $target_file)){
                    $_SESSION['message'] = 'Thêm chi nhánh mới thành công';
                } else {
                    $_SESSION['message'] = 'Thêm chi nhánh mới thất bại';
                
                }
            }
        } else {
            $_SESSION['message'] = 'Tên chi nhánh đã tồn tại';
        }
    }

    public function editBranch($branchId,$name, $address, $hotline, $image){
        if(!BranchRepository::getInstance()->checkExistenceById($branchId,$name)){
            $target_file = '';
            if(isset($image["book-image"]["name"]) && $image["book-image"]["name"] != null){
                $target_dir = "public/assets/img/";
                $target_file = $target_dir . basename($image["book-image"]["name"]);
        
                echo $target_file;
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
                // Kiểm tra file có phải là hình ảnh thật hay không
                $check = getimagesize($image["book-image"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                } else {
                    $_SESSION['message'] = "File is not an image.";
                    $uploadOk = 0;
                }
        
                // Kiểm tra nếu file đã tồn tại
                if (file_exists($target_file)) {
                    // echo "Sorry, file already exists.";
                    // $uploadOk = 0;
                } else {
                    move_uploaded_file($image["book-image"]["tmp_name"], $target_dir);
                }
        
                // Giới hạn kích thước file
                if ($image["image"]["size"] > 500000) {
                    $_SESSION['message'] = "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
        
                // Giới hạn loại file
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                    $_SESSION['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }
        
                // Kiểm tra nếu $uploadOk là 0 do có lỗi
                if ($uploadOk == 0) {
                    $_SESSION['message'] .= "<br>Add Product failed, please try again.";
                    exit();
                // Nếu mọi thứ đều ổn, thử upload file
                } else {
                    if(BranchRepository::getInstance()->updateBranch($branchId,$name, $address, $hotline, $target_file)){
                        $_SESSION['message'] = 'Cập nhật chi nhánh mới thành công';
                    } else {
                        $_SESSION['message'] = 'Cập nhật chi nhánh mới thất bại';
                    
                    }
                }
            } else {
                if(BranchRepository::getInstance()->updateBranch($branchId,$name, $address, $hotline, $target_file)){
                    $_SESSION['message'] = 'Cập nhật chi nhánh mới thành công';
                } else {
                    $_SESSION['message'] = 'Cập nhật chi nhánh mới thất bại';
                
                }
            }
        } else {
            $_SESSION['message'] = 'Tên chi nhánh đã tồn tại';
        }
    }

    public function deleteBranch($branchId){
        if(BranchRepository::getInstance()->deleteById($branchId)){
            $_SESSION['message'] = 'Xóa chi nhánh thành công';
        } else {
            $_SESSION['message'] = 'Xóa chi nhánh thất bại';
        }
    }
}

