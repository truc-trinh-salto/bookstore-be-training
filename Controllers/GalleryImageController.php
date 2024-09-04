<?php
namespace MVC\Controllers;
// require '../vendor/autoload.php';
use MVC\Controller;

use MVC\Services\GalleryImageService;


session_start();

class GalleryImageController extends Controller {
    public function galleryImage(){
        
        $bookId = $_GET['book_id'];
        $page = $_GET['page'] ?: 1;
        $limit = 6;

        $data = GalleryImageService::getInstance()->showGalleryImageOfBookPage($bookId,$page,$limit);

        
        $this->render('management/gallery_image',$data);
    }

    public function defaultGalleryImage(){
        $bookId = $_GET['book_id'];
        $imageId = $_GET['image_id'];

        echo $bookId;

        GalleryImageService::getInstance()->defaultGalleryImageOfBook($bookId,$imageId);

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    public function addGalleryImage(){
        $bookId = $_POST['book_id'];
        $image = $_FILES;

        GalleryImageService::getInstance()->addGalleryImageOfBook($bookId,$image);

        header('Location: '.$_SERVER['HTTP_REFERER']);

    }

    public function deleteGalleryImage(){
        $imageId = $_GET['image_id'];

        GalleryImageService::getInstance()->deleteGalleryImageOfBook($imageId);


        header('Location: '.$_SERVER['HTTP_REFERER']);

    }
}


