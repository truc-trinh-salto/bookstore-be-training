<?php
namespace MVC\Controllers;
// require '../vendor/autoload.php';
use MVC\Controller;


use MVC\Services\UserService;
use MVC\Services\BookService;




session_start();

class UserController extends Controller {
    public function login(){

        $username = $_POST['username'];
        $password = $_POST['password'];
        $backTmp = $_POST['back'];

        if(UserService::getInstance()->login($username, $password)){
            if (isset($_SERVER["HTTP_REFERER"]) && str_contains('index.php',$_SERVER["HTTP_REFERER"])) {
                header("Location: " . $backTmp);
            } else {
                header("Location: /");
            }
        } else {
            $data = BookService::getInstance()->showHeader();
            $this->render('/login',$data);
        }
    }

    public function logout(){
        session_start(); 
        session_destroy();

        header('Location: /');
        exit();
    }

    public function profile(){
        $userId = $_SESSION['user_id'];
        
        $data = UserService::getInstance()->showProfilePage($userId);

        $this->render('user/profile',$data);
    }

    public function editProfile(){
        if(isset($_POST['submit'])){
            $userId = $_SESSION['user_id'];
    
            $fullName = $_POST['fullname'];
            $phoneNumber = $_POST['phone'];
            $birthDay = $_POST['birthday'];
            $email = $_POST['email'];
    
            UserService::getInstance()->editInformationOfUser($fullName,$phoneNumber,$birthDay,$email,$userId);

            header("Location: /profile");
        }
        header("Location: /profile");

    }

    public function changePassword(){
        // CHANGE PASSWORD IN PROFILE
        if(isset($_POST['submit']) && isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
            $oldPassword = $_POST['old_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];
            $userName = $_SESSION['username'];
    
            UserService::getInstance()->changePasswordForProfile($oldPassword,$newPassword,$confirmPassword,$userName);
    
            header("Location: /profile");
        }
        
        //CHANGE PASSWORD IN RESET PASSWORD
        if(isset($_POST['btn']) && isset($_POST['pwd']) && isset($_POST['pwd2'])) {
            $username = $_POST['username'];
            $newPassword = $_POST['pwd'];
            $confirmPassword = $_POST['pwd2'];
    
            if(!UserService::getInstance()->changePasswordForReset($username, $newPassword, $confirmPassword)){
                header("Location: reset_password?username=".$username);
            } else {
                header("Location: /login");
            }
        }
    }

    public function uploadImage(){
        $userId = $_SESSION['user_id'];
        
        $file = $_FILES;

        UserService::getInstance()->uploadProfileImage($file,$userId);

        
        header("Location: /profile");
    }

    public function userManagement(){
        $searchKeyword = $_GET['search_keyword'];

        $page = $_GET['page'] ?: 1;

        $limit = 6;
        

        $data = UserService::getInstance()->showUserManagementPage($searchKeyword,$page, $limit);

        $this->render('management/users',$data);
    }

    public function activateUser(){
        $action = 0;
        $userId = $_GET['user_id'];
        if($_GET['action'] == 'lock') {
            $action = 1;
        } 

        UserService::getInstance()->activateUser($userId, $action);

        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    
    public function sendEmailForResetPassword(){
        $userName = $_POST['username'];
        UserService::getInstance()->sendEmailForResetPassword($userName);
        
    }

    public function forgotPassword(){
        $data = BookService::getInstance()->showHeader();
        $this->render('user/forgot_password',$data);
    }

    public function resetPassword(){
        $data = BookService::getInstance()->showHeader();
        $this->render('user/reset_password',$data);
    }

    public function registerPage(){
        $data = BookService::getInstance()->showHeader();
        $this->render('register',$data);
    }

    public function register(){
        $fullname = $_POST['fullname'];
        $birthday = $_POST['birthday'];
        $phone = $_POST['phone'];
        $username = $_POST['username'];
        $password = $_POST['pwdSignUp'];
        $cpassword = $_POST['pwdSignUp2'];

        if(UserService::getInstance()->register($fullname, $birthday, $phone, $username, $password, $cpassword)){
            header("Location: /login");
        } else {
            $data = BookService::getInstance()->showHeader();
            header("Location: ".$_SERVER['HTTP_REFERER']);

        }
    }

}


