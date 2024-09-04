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

class GalleryImageService {

    private static $instance;
    private function __construct(){
    }
    private function __clone(){}

    public static function getInstance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname;
        }
        return self::$instance;
    }
    
    public function showGalleryImageOfBookPage($bookId,$page,$limit){

        $number_page = GalleryImageRepository::getInstance()->getNumberPageOfGalleryPage($bookId,$limit);
        $images = GalleryImageRepository::getInstance()->getAllByGalleryPagination($bookId,$page,$limit);
        
        return ['number_page' => $number_page, 'images' => $images];
    }

    public function defaultGalleryImageOfBook($bookId,$imageId){
        $isUpdateGallery = GalleryImageRepository::getInstance()->updateDefaultGalleryByBookId($bookId,$imageId);
        if($isUpdateGallery){
            $_SESSION['message'] = "Cập nhật mặc định thành công";
        } else {
            $_SESSION['message'] = "Cập nhật mặc định thất bại";
        }
    }

    public function addGalleryImageOfBook($bookId,$image){
        $target_dir = "public/assets/img/";
        $index = 0;
        for($i = 0;$i < count($image['profile_image']['name']); $i++) {
            $target_file = $target_dir . basename($image["profile_image"]["name"][$i]);

            echo $target_file;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Kiểm tra file có phải là hình ảnh thật hay không
            $check = getimagesize($image["profile_image"]["tmp_name"][$i]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }

            // Kiểm tra nếu file đã tồn tại
            if (file_exists($target_file)) {
                // echo "Sorry, file already exists.";
                // $uploadOk = 0;
            } else {
                move_uploaded_file($image["profile_image"]["tmp_name"][$i], $target_dir);
            }

            // Giới hạn kích thước file
            if ($image["profile_image"]["size"][$i] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Giới hạn loại file
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Kiểm tra nếu $uploadOk là 0 do có lỗi
            if ($uploadOk == 0) {
                $_SESSION['message'] .= ($index > 0?"<br>" : ""). "Thêm hình ảnh ".basename($image["profile_image"]["name"][$i])." thất bại";
            } else {
                    echo "The file ". basename( $image["profile_image"]["name"][$i]). " has been uploaded.";

                    GalleryImageRepository::getInstance()->addNewGalleryByBookId($bookId,$target_file);

                    $_SESSION['message'] .= ($index > 0?"<br>" : ""). "Thêm hình ảnh ".basename($image["profile_image"]["name"][$i])." Thành công";
            }
            $index++;
        }
    }

    public function deleteGalleryImageOfBook($imageId){

        $isDeleteGallery = GalleryImageRepository::getInstance()->deleteById($imageId);
        if($isDeleteGallery){
            $_SESSION['message'] = 'Xoá hình ảnh thành công';
        } else {
            $_SESSION['message'] = 'Xoá hình ảnh thất bại';
        }
    }
}

