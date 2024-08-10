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
    <form method="POST" action="">
        <div class="form-group">
            <label for="username">Tài Khoản</label>
            <input type="username" class="form-control" id="username" name="username" required>
        </div>

        <input type="hidden" name="back" value="<?php echo $back_server ?>">
        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Login</button>
        <p class="my-4">Bạn chưa có tài khoản? <a style="font-weight:bold" href="register.php">Đăng ký tài khoản</a>
        </form>
    </div>
    
    </div>
  </body>
</html>

<?php 
require_once('database.php');
if(isset($_POST['submit'])){
    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        
        $db = DBConfig::getDB();
        $stmt = $db->prepare('SELECT * FROM users WHERE username = ? and password = ?');
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        // print_r($user['username']);
        if($user['deactivate'] == 1){
            echo 'This account is locked';
            return false;
        } else if($user){
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['image'] = $user['image'];
            $back_tmp = $_POST['back'];
            // echo $_SESSION['fullname'];
            if (isset($_SERVER["HTTP_REFERER"]) && str_contains('index.php',$_SERVER["HTTP_REFERER"])) {
                header("Location: " . $back_tmp);
            } else {
                header("Location: home.php");
            }

        } else {
            echo 'Username or Password is incorrect';
            return false;
        }
    } else {
        echo 'Username and Password required';
        return false;
    }
}
?>