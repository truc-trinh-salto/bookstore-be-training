<?php
namespace MVC\Controllers;
// require '../vendor/autoload.php';
use MVC\Controller;



use MVC\Services\CommentService;



session_start();

class CommentController extends Controller {
    public function comment(){
        if(!$_SESSION['user_id'] && isset($_POST['comment'])){
            header('Location: /login');
            exit();
        } else if(isset($_POST['comment']) && isset($_POST['text_comment']) &&!empty($_POST['text_comment'])){
            $book_id = $_POST['book_id'];
            $user_id = $_SESSION['user_id'];
            $text_comment = $_POST['text_comment'];

            CommentService::getInstance()->addNewCommentInBook($book_id, $user_id, $text_comment);

            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }

    public function replyComment(){
        if(!$_SESSION['user_id']){
            header('Location: /login');
            exit();
        } else if(isset($_POST['comment']) && isset($_POST['text_comment']) &&!empty($_POST['text_comment'])){
            $book_id = $_POST['book_id'];
            $user_id = $_SESSION['user_id'];
            $text_comment = $_POST['text_comment'];
            $parent_id = $_POST['comment_id'];
            
            CommentService::getInstance()->addNewReplyInBook($book_id, $user_id, $text_comment,$parent_id);
    
            header('Location: '.$_SERVER['HTTP_REFERER']);

        }
    }
}


