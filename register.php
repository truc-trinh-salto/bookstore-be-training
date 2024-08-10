<DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/icon.png" type="image/x-icon">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <style>
    *{
        margin:0;
        padding: 0;
    }

    #page {
        width: 100%;
        height: 100vh;
        background-image: url('1_1.png');
        background-size: 100%;
        background-repeat: no-repeat;
    }

    @media screen and (max-width: 768px){
        #page {
            background-size: auto;
        }
    }

    html, body {
        height: 100%;
    }

    body {
    display: flex;
    align-items: center;
    padding-top: 40px;
    padding-bottom: 40px;
    }

    .form-create {
        width: 100%;
        max-width: 500px;
        padding: 15px;
        margin: auto;
        background-color: #edf5fb;
        background-image: url('1_dk.png');
        background-size:cover;
        opacity: 0.9;
        margin-top: 10vh;
        }

</style>
  </head>
<body>
    <div class="mt-4">
        <div class="row justify-content-around">
              <form class="row g-2 justify-content-center form-create" action="" method="post">
              <h1 style="text-align: center; font-weight:550;" class ="h3 mb-3 fw-normal">ĐĂNG KÍ</h1>
                <div class="col-md-12">
                  <label for="firstname" class="form-label" action="">Họ tên</label>
                  <input type="text" class="form-control" id="fullname" name="fullname"placeholder="Nhập họ tên" required>
                </div>

                <div class="col-md-12">
                    <label for="date" class="pb-2">Ngày tháng năm sinh:</label>
                    <input type="date" class="form-control" id="date" name="birthday" required>
                </div>

                <div class="col-md-12">
                    <label for="phone" class="pb-2">Số điện thoại:</label>
                    <input type="text" class="form-control" id="phone" placeholder="012345678" name="phone" required>
                </div>

                <div class="col-md-12">
                    <label for="username" class="form-label">Tài khoản đăng nhập</label>
                    <input type="username" class="form-control" id="username" name="username" placeholder="Tên đăng nhập" required>
                </div>

                <div class="col-md-12">
                    <label for="pwd" class="pb-2">Mật khẩu:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwdSignUp" required>
                </div>
                
                
                <div class="col-12">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                    <label class="form-check-label" for="invalidCheck2">
                      Đồng ý với điều khoản sử dụng
                    </label>
                  </div>
                </div>

                <div class="col-12">
                  <button class="btn btn-success" name="btn" type="submit">Đăng ký</button>
                </div>

                <p class="my-4">Bạn đã có tài khoản? <a style="font-weight:bold" href="index.php">Đăng nhập</a> </p>
              </form>
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
      
        // kiểm tra các giá trị đầu vào
        if (empty($fullname) || empty($birthday) || empty($phone) || empty($password) || empty($username)) {
          echo "Vui lòng điền đầy đủ thông tin.";
          exit();
        } else if (check_username_existence($conn, $username)) {
          echo "Tên người dùng đã tồn tại. Vui lòng chọn tên khác.";
          exit();
        } else {
          // thêm dữ liệu vào bảng
        $stm = $conn->prepare("insert into users(username,password,fullname,phonenumber,birthday) values(?,?,?,?,?)");
        $stm->bind_param('sssss',$username, $password, $fullname, $phone,$birthday);
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