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
</head>
<body>
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
    <div id="page justify-content-around">
        <div class="container">
        <?php
            session_start(); 
			if(isset($_SESSION['message'])){
				?>
				<div class="alert alert-info text-center">
					<?php echo $_SESSION['message']; ?>
				</div>
				<?php
				unset($_SESSION['message']);
			}
 
			?>
            <form class="row g-2 justify-content-around form-create" action="send_otp.php" method="post">
              <h1 style="text-align: center; font-weight:550;" class ="h3 mb-3 fw-normal">Quên mật khẩu</h1>

                <div class="col-md-12">
                    <label for="username" class="form-label">Tài khoản đăng nhập</label>
                    <input type="username" class="form-control" id="username" name="username" placeholder="Tên đăng nhập" required>
                </div>

                <div class="col-12">
                  <button class="btn btn-success" name="btn" type="submit">Gửi OTP đến email</button>
                </div>

                <p class="my-4">Bạn đã có tài khoản? <a style="font-weight:bold" href="../../index.php">Đăng nhập</a> </p>
              </form>
        </div>
    </div>
    
</body>
</html>
