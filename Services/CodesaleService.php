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

class CodesaleService {

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
    
    public function showCodesalePage(){
        $codeSales = CodesaleRepository::getInstance()->getAllActive();

        $categories = CategoryRepository::getInstance()->getAllCategories();

        $cartArray = $_SESSION['cart'];

        if(count($cartArray) > 0){
            $books_cart = BookRepository::getInstance()->getAllInCart($cartArray);
            $carts = GalleryImageRepository::getInstance()->getImageBooks($books_cart);
        }

        return ['categories' => $categories,'codesales' => $codeSales,
                'book_cart' => $carts];
    }

    public function showCodesaleManagementPage($searchKeyword){
        $codeSales = CodesaleRepository::getInstance()->getAllCodesales($searchKeyword);

        return ['codesales' => $codeSales];
    }

    public function activateCode($codeId, $action){
        $isActivatedCode = CodesaleRepository::getInstance()->updateActivate($codeId, $action);
        if($isActivatedCode && $action == 1) {
            $_SESSION['message'] = 'KHOÁ THÀNH CÔNG !';
        } else {
            $_SESSION['message'] = 'MỞ KHOÁ THÀNH CÔNG !';
        }
    }

    public function addNewCodesale($description, $min, $max, $startAt, $endAt, $activate, $method, $value, $code){
        if(CodesaleRepository::getInstance()->checkExistence($code)){
            $_SESSION['message'] = 'Mã đã tồn tại';
            exit();
        } else {
            $isAddedCode = CodesaleRepository::getInstance()->addCodesale($description, $min, $max, $startAt, $endAt, $activate, $method, $value, $code);
            if($isAddedCode)
            {
                $_SESSION['message'] = 'Thêm mã mới thành công';
            }
            else
            {
                $_SESSION['message'] = 'Thêm mã mới thất bại';
            }
        }
    }

    public function showEditCodesalePage($codeId){
        $codeSale = CodesaleRepository::getInstance()->findById($codeId);
        return ['codesale' => $codeSale];
    }

    public function editCodesale($codeId,$description, $min, $max, $startAt, $endAt, $activate, $method, $value, $code){
        if(!CodesaleRepository::getInstance()->checkExistenceById($code,$codeId)){
            $isUpdatedCode = CodesaleRepository::getInstance()->updateCodesale($codeId,$description, $min, $max, $startAt, $endAt, $activate, $method, $value, $code);
            if($isUpdatedCode){
                $_SESSION['message'] = 'Cập nhật mã thành công';
            } else {
                $_SESSION['message'] = 'Cập nhật mã thành công';
            }
        } else {
            $_SESSION['message'] = 'Mã đã tồn tại';

        }
    }
}

