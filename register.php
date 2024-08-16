<?php 
    require_once('database.php');
    $db = DBConfig::getDB();
    session_start();

    if(isset($_GET['lang']) && !empty($_GET['lang'])){
        $_SESSION['lang'] = $_GET['lang'];
        if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
         echo "<script type='text/javascript'> location.reload(); </script>";
        }
    }
    if(isset($_SESSION['lang'])){
            include "public/language/".$_SESSION['lang'].".php";
    }else{
            include "public/language/en.php";
    }

    $stmt = $db->prepare('SELECT * FROM categories');
    $stmt->execute();
    $categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


?>

<DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Demo PHP MVC</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <style>
        .dropdown:hover>.dropdown-menu {
            display: block;
            }
    </style>
</head>
  <style>

</style>
<body>
    <div class="app">
      <?php include "partials/sub_header.php"?>
      <div class="container">
          <div class="mt-4">
            <div class="row d-flex justify-content-around">
                  <form class="col g-2 justify-content-center form-create" action="" method="post">
                  <h1 style="text-align: center; font-weight:550;" class ="h3 mb-3 fw-normal"><?=_REGISTER?></h1>
                    <div class="col-md-12">
                      <label for="firstname" class="form-label" action=""><?=_NAME?></label>
                      <input type="text" class="form-control" id="fullname" name="fullname"placeholder="<?=_NAME?>" required>
                    </div>

                    <div class="col-md-12">
                        <label for="date" class="pb-2"><?=_BIRTHDAY?>:</label>
                        <input type="date" class="form-control" id="date" name="birthday" required>
                    </div>

                    <div class="col-md-12">
                        <label for="phone" class="pb-2"><?=_PHONE?>:</label>
                        <input type="text" class="form-control" id="phone" placeholder="<?=_PHONE?>" name="phone" required>
                    </div>

                    <div class="col-md-12">
                        <label for="username" class="form-label"><?=_USERNAME?></label>
                        <input type="username" class="form-control" id="username" name="username" placeholder="<?=_USERNAME?>" required>
                    </div>

                    <div class="col-md-12">
                        <label for="pwd" class="pb-2"><?=_PASSWORD?>:</label>
                        <input type="password" class="form-control" id="pwd" placeholder="<?=_PASSWORD?>" name="pwdSignUp" required>
                    </div>

                    <div class="col-md-12">
                        <label for="pwd" class="pb-2"><?=_CONFIRMPASSWORD?>:</label>
                        <input type="password" class="form-control" id="pwd" placeholder="<?=_CONFIRMPASSWORD?>" name="pwdSignUp2" required>
                    </div>
                    
                    
                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                        <label class="form-check-label" for="invalidCheck2">
                          <?=_AGREETERM?>
                        </label>
                      </div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-success" name="btn" type="submit"><?=_SUBMIT?></button>
                    </div>

                    <p class="my-4"><?=_HAVEACCOUNT2?>? <a style="font-weight:bold" href="index.php"><?=_LOGIN?></a> </p>
                  </form>
            </div>
        </div>
      </div>
    </div>
    
</body>
</html>

<?php 
    require_once 'database.php'; // Truy cập vào file config.php
    // Tạo kết nối đến cơ sở dữ liệu
    $conn = DBConfig::getDB();
    function check_username_existence($conn, $username) {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
          return true;
        } else {
          return false;
        }
      }
      if (isset($_POST['btn'])) {
        $fullname = $_POST['fullname'];
        $birthday = $_POST['birthday'];
        $phone = $_POST['phone'];
        $username = $_POST['username'];
        $password = $_POST['pwdSignUp'];
        $cpassword = $_POST['pwdSignUp2'];

      
        // kiểm tra các giá trị đầu vào
        if (empty($fullname) || empty($birthday) || empty($phone) || empty($password) || empty($username) || empty($cpassword)) {
          echo "Vui lòng điền đầy đủ thông tin.";
          exit();
        } else if (check_username_existence($conn, $username)) {
          echo "Tên người dùng đã tồn tại. Vui lòng chọn tên khác.";
          exit();
        } else if(!empty($_POST["pwdSignUp"]) && ($_POST["pwdSignUp"] == $_POST["pwdSignUp2"])) {
            if (strlen($password) <= '8') {
                $echo = "Your Password Must Contain At Least 8 Characters!";
            }
            elseif(!preg_match("#[0-9]+#",$password)) {
                $echo = "Your Password Must Contain At Least 1 Number!";
            }
            elseif(!preg_match("#[A-Z]+#",$password)) {
                $echo = "Your Password Must Contain At Least 1 Capital Letter!";
            }
            elseif(!preg_match("#[a-z]+#",$password)) {
                $echo = "Your Password Must Contain At Least 1 Lowercase Letter!";
            } else {
                $echo = "Please Check You've Entered Or Confirmed Your Password!";
            }
        } else {
          // thêm dữ liệu vào bảng
          $stm = $conn->prepare("insert into users(username,password,fullname,phonenumber,birthday) values(?,?,?,?,?)");
          $stm->bind_param('sssss',$username, $password, $fullname, $phone, $birthday);
          $stm->execute();
          echo "Đăng ký thành công!";
          header("Location: index.php");
          exit();
          }
      } else {
        // header("Location: register.php");
        exit();
      }

?>