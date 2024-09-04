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
use MVC\Repository\UserRepository;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

class UserService {

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
    
    public function login($username,$password){
        if($username && $password){
            $user = UserRepository::getInstance()->findByUsernameAndPassword($username, $password);

            if($user['deactivate'] == 1){
                $_SESSION['message'] = 'This account is locked';
                return false;
            } else if($user){
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['image'] = $user['image'];

                return true;
            } else {
                $_SESSION['message'] = 'Username or Password is incorrect';
                return false;
            }
        } else {
            $_SESSION['message'] = 'Username and Password required';
            return false;

        }
    }
    
    public function showProfilePage($userId){
        
        //GET CURRENT USER
        $user = UserRepository::getInstance()->findById($userId);
        
        //GET CART ITEMS FOR USER
        $cartArray = $_SESSION['cart'];
        if(!count($cartArray) == 0){
            $books_cart = BookRepository::getInstance()->getAllInCart($cartArray);
            $carts = GalleryImageRepository::getInstance()->getImageBooks($books_cart);       
        }

        // GET ALL CATEGORIES
        $categories = CategoryRepository::getInstance()->getAllCategories();
        
        return ['user' => $user,'book_cart' => $carts,
                'categories' => $categories];
    }

    public function editInformationOfUser($fullName,$phoneNumber,$birthDay,$email,$userId){
        $isUpdateUser = UserRepository::getInstance()->updateUser($fullName,$phoneNumber,$birthDay,$email,$userId);
            
        if($isUpdateUser){
            $_SESSION['message'] = "Profile updated successfully!";
        } else {
            $_SESSION['message'] = "Failed to update profile!";
        }
    }

    public function changePasswordForProfile($oldPassword,$newPassword,$confirmPassword,$userName){
        $user = UserRepository::getInstance()->findByUsernameAndPassword($userName,$oldPassword);
        if($user == null) {
            $_SESSION['message'] = 'Invalid old password';
            exit();
        }

        if($newPassword!= $confirmPassword) {
            $_SESSION['message'] = 'Passwords do not match';
            exit();
        }

        $isUpdatePassword = UserRepository::getInstance()->updatePassword($newPassword,$userName);

        if($isUpdatePassword){
            $_SESSION['message'] = 'Password changed successfully!';
        } else {
            $_SESSION['message'] = 'Failed to change password!';
        }
    }

    public function changePasswordForReset($username,$newPassword,$confirmPassword){
            if($newPassword!= $confirmPassword) {
                $_SESSION['message'] = 'Passwords do not match';
                return false;
            } else {
                $isUpdatePassword = UserRepository::getInstance()->updatePassword($newPassword,$username);
    
                if($isUpdatePassword){
                    $_SESSION['message'] = 'Password changed successfully!';
                } else {
                    $_SESSION['message'] = 'Failed to change password!';
                }

                return true;
            }
    }

    public function uploadProfileImage($file,$userId){
            $target_dir = "public/assets/img/";
            $target_file = $target_dir . basename($file["profile_image"]["name"]);
        
            echo $target_file;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
            // Kiểm tra file có phải là hình ảnh thật hay không
            $check = getimagesize($file["profile_image"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        
            // Kiểm tra nếu file đã tồn tại
            if (file_exists($target_file)) {
                
            } else {
                move_uploaded_file($file["profile_image"]["tmp_name"], $target_dir);
            }
        
            // Giới hạn kích thước file
            if ($file["profile_image"]["size"] > 500000) {
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
                $_SESSION['message'] = "Profile image has been updated failed.";
                // header("Location: /profile");
                // exit();
            } else {
                echo "The file ". basename( $file["profile_image"]["name"]). " has been uploaded.";
                echo $target_file;
                // Lưu đường dẫn hình ảnh vào cơ sở dữ liệu
                $isUploadImage = UserRepository::getInstance()->updateImage($target_file,$userId);
                if($isUploadImage){
                    $_SESSION['message'] = "Profile image has been updated successfully.";
                } else {
                    $_SESSION['message'] = "Profile image has been updated failed.";
                }

                // header("Location: /profile");
            }
    }

    public function showUserManagementPage($searchKeyword,$page,$limit){
        $number_page = UserRepository::getInstance()->getNumberPageOfUserManagementPage($searchKeyword,$limit);

        $users = UserRepository::getInstance()->getAllByUserManagementPagnination($searchKeyword,$page,$limit);

        return ['number_page' => $number_page, 'users' => $users];
    }

    public function activateUser($userId, $action){
        $isActivatedUser = UserRepository::getInstance()->updateActivate($userId, $action);
        if($isActivatedUser && $action == 1) {
            $_SESSION['message'] = 'KHOÁ THÀNH CÔNG !';
        } else {
            $_SESSION['message'] = 'MỞ KHOÁ THÀNH CÔNG !';
        }
    }

    public function sendEmailForResetPassword($userName){
        $user = UserRepository::getInstance()->findByUsername($userName);
        if($user){
            if($this->sendEmailForReset($user['email'], $userName)){
                return true;
            } else {
                return false;
            }
        } else {
            header("Location: ".$_SERVER['HTTP_REFERER']);
            return false;
        }
    }

    function sendEmailForReset($email, $username) {
        $mail = new PHPMailer();
        try{
            echo 'test';
            $password = file_get_contents('../../secret.txt');
            echo $password;
            $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'trungtruc201563@gmail.com';
            $mail->Password = $password;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    
    
            $mail->setFrom('trungtruc201563@gmail.com', 'Admin');
            $mail->addAddress($email, 'Customer');
    
            $mail->isHTML(true);                                  
            $mail->Subject = 'Here is the subject';
            $five_minutes_later = date("Y-m-d H:i:s");
            $url = 'http://localhost:8080/views/user/reset_password.php?username='. urlencode($username). '&time='.$five_minutes_later;
            $mail->Body    = 'This is the link for reset your password <br>'.$url.'  </br>';
    
            $mail->send();
            
            $_SESSION['message'] = "Link for reset password has been sent to your email. Please check your inbox.";
            return true;
    
        } catch (Exception $e){
            $_SESSION['message'] = "Link for reset password has not been sent. Please check your double check your username";
            return false;

        }
    }

    public function register($fullname, $birthday, $phone, $username, $password, $cpassword){
        if (empty($fullname) || empty($birthday) || empty($phone) || empty($password) || empty($username) || empty($cpassword)) {
            $_SESSION['message'] = "Vui lòng điền đầy đủ thông tin.";
            return false;
          } else if (UserRepository::getInstance()->findByUsername($username)) {
            $_SESSION['message'] = "Tên người dùng đã tồn tại. Vui lòng chọn tên khác.";
            return false;
          } else if(!empty($_POST["pwdSignUp"]) && ($_POST["pwdSignUp"] == $_POST["pwdSignUp2"])) {
              if (strlen($password) <= '8') {
                  $_SESSION['message'] = "Your Password Must Contain At Least 8 Characters!";
              }
              elseif(!preg_match("#[0-9]+#",$password)) {
                  $_SESSION['message'] = "Your Password Must Contain At Least 1 Number!";
              }
              elseif(!preg_match("#[A-Z]+#",$password)) {
                  $_SESSION['message'] = "Your Password Must Contain At Least 1 Capital Letter!";
              }
              elseif(!preg_match("#[a-z]+#",$password)) {
                  $_SESSION['message'] = "Your Password Must Contain At Least 1 Lowercase Letter!";
              } else {
                  $_SESSION['message'] = "Please Check You've Entered Or Confirmed Your Password!";
              }
              return false;
          } else {
            // thêm dữ liệu vào bảng
            if(UserRepository::getInstance()->addNewUser($username,$password,$fullname,$phone,$birthday)){
                $_SESSION['message'] = "Đăng ký thành công!";
                return true;
            }
            $_SESSION['message'] = "Đăng ký thất bại";
            return false;
          }
    }
        
}

