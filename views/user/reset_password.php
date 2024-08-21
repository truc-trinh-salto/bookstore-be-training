<DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/icon.png" type="image/x-icon">
    <title>RESET Mật khẩu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
</head>
<body>
<style>

</style>
        <div class="app">
            <div class="container">
                <div id="page" class="mt-4">
                    <div class="row d-flex justify-content-center">
                        <form class="row g-2 justify-content-around form-create" action="../../service/user/change_password.php" method="post">
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

                            <p class="my-4">Bạn đã có tài khoản? <a style="font-weight:bold" href="../../index.php">Đăng nhập</a> </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    
</body>
</html>

<?php 
?>