<?php
require_once('controllers/base_controller.php');
require_once('models/Books.php');


class BooksController extends BaseController{
    function __construct(){
        $this->folder = 'books';
    }

    public function index(){
        $books = Book::all();
        $data = array('books' => $books);
        $this->render('index', $data);
    }
}
?>