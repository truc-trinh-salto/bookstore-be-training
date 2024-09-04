<?php 
    // require_once('database.php');
    // $db = DBConfig::getDB();
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

    $username = $_GET['username'];
?>

<DOCTYPE html>
<html>
   <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Demo PHP MVC</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class="app">
        <?php include 'views/user/partials/sub_header.php' ?>
        <div class="container">
        
        <div class="mt-4">
            <?php 
                    session_start();
                    $back_server = $_SERVER['HTTP_REFERER'];
                    if(isset($_SESSION['message'])){
                        ?>
                        <div class="alert alert-info text-center">
                            <?php echo $_SESSION['message']; ?>
                        </div>
                        <?php
                        unset($_SESSION['message']);
                    }
        
            ?>
            <div class="row justify-content-center">
            <form class="row g-2 justify-content-around form-create" action="/user/changePassword" method="post">
                        <h1 style="text-align: center; font-weight:550;" class ="h3 mb-3 fw-normal">RESET Mật khẩu</h1>

                            <div class="col-md-12">
                                <label for="pwd" class="pb-2">Mật khẩu:</label>
                                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" required>
                            </div>

                            <div class="col-md-12">
                                <label for="pwd" class="pb-2">Nhập lại mật khẩu:</label>
                                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd2" required>
                            </div>

                            <input type="hidden" name="username" value="<?= $_GET['username']?>">

                            <div class="col-12">
                            <button class="btn btn-success" name="btn" type="submit">Reset</button>
                            </div>

                            <p class="my-4">Bạn đã có tài khoản? <a style="font-weight:bold" href="/login">Đăng nhập</a> </p>
                        </form>
            </div>
            
            </div>
        </div>
    </div>
  </body>
</html>