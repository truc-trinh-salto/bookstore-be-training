<?php
    session_start();
    require_once('../../../database.php');

    if(isset($_GET['lang']) && !empty($_GET['lang'])){
        $_SESSION['lang'] = $_GET['lang'];
        if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
         echo "<script type='text/javascript'> location.reload(); </script>";
        }
    }

    if(isset($_SESSION['lang'])){
        include "../../../public/language/".$_SESSION['lang'].".php";
    }else{
            include "../../../public/language/en.php";
    }

    $db = DBConfig::getDB();

    $branch_id = $_GET['branch_id'];

    $stmt = $db->prepare('SELECT * FROM branch WHERE branch_id =?');
    $stmt->bind_param("i", $branch_id);
    $stmt->execute();

    $branch = $stmt->get_result()->fetch_assoc();



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
        <?php include('../partials/admin_header.php') ?>
        <div class="container">
        <section layout:fragment="content">
	<div class="col-md-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><?=_EDITBRANCH?></h4>
                <?php 
                    if(isset($_SESSION['message'])){
                        ?>
                        <div class="alert alert-info text-center">
                            <?php echo $_SESSION['message']; ?>
                        </div>
                        <?php
                        unset($_SESSION['message']);
                    }
			?>
				<form action="" method="POST" class="forms-sample" enctype="multipart/form-data">
					<!-- <div class="form-group">
						<label for="exampleInputImageUrl"><?=_PHOTO?></label>
						<input type="text" class="form-control" id="exampleInputImageUrl" placeholder="<?=_PHOTO?>" name="image" value="<?php echo $branch['image'] ?>">
					</div> -->
                    <div class="text-center">
                        <img src="<?php echo '../../../'.$branch['image'] ?: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT3cD47c9xUZyKlO3j3z9vdBHV0P2BIwfkeWg&s'?>" class="avatar img-circle img-thumbnail" alt="avatar" height="300" width="300">
                        <h6><?=_PHOTO?></h6>
                        <input type="file" class="text-center center-block file-upload" name="branch-image">
                    </div>

					<div class="form-group">
						<label for="exampleInputName1"><?=_BRANCHNAME?></label>
						<input type="text" class="form-control" id="exampleInputName1" placeholder="<?=_BRANCHNAME?>" name="name" value="<?php echo $branch['title']?>" required>
					</div>
                    <div class="form-group">
						<label for="exampleInputAuthor1"><?=_ADDRESS?></label>
						<input type="text" class="form-control" id="exampleInputAuthor1" placeholder="<?=_ADDRESS?>" name="address"  value="<?php echo $branch['address'] ?>" required>
					</div>
                    <div class="form-group">
						<label for="exampleInputDescription1"><?=_HOTLINE?></label>
						<input type="text" class="form-control" id="exampleInputDescription1" placeholder="<?=_HOTLINE?>" name="hotline"  value="<?php echo $branch['hotline'] ?>" required>
					</div>
					
					<button type="submit" name="submit" class="btn btn-success mr-2"><?=_SAVE?></button>
				</form>
			</div>
		</div>
	</div>

</section>
        </div>
    </div>
    
</body>
</html>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {

    
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.avatar').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
            
        }
    }


    $(".file-upload").on('change', function(){
        readURL(this);
    });
    });

    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<?php
    if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST')
    {
        // $image = $_POST['branch-image'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $hotline = $_POST['hotline'];

        if(!checkExistence($name,$branch_id, $db)){
            if(isset($_FILES["branch-image"]["name"])){
                $target_dir = "public/assets/img/";
                $target_file = $target_dir . basename($_FILES["branch-image"]["name"]);
        
                echo $target_file;
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
                // Kiểm tra file có phải là hình ảnh thật hay không
                $check = getimagesize($_FILES["branch-image"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                } else {
                    $_SESSION['message'] = "File is not an image.";
                    $uploadOk = 0;
                }
        
                // Kiểm tra nếu file đã tồn tại
                if (file_exists($target_file)) {
                    // echo "Sorry, file already exists.";
                    // $uploadOk = 0;
                } else {
                    move_uploaded_file($_FILES["branch-image"]["tmp_name"], $target_dir);
                }
        
                // Giới hạn kích thước file
                if ($_FILES["branch-image"]["size"] > 500000) {
                    $_SESSION['message'] = "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
        
                // Giới hạn loại file
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                    $_SESSION['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }
        
                // Kiểm tra nếu $uploadOk là 0 do có lỗi
                if ($uploadOk == 0) {
                    $_SESSION['message'] .= "<br>Add Product failed, please try again.";
                    header("Location: edit_store.php?branch_id=".$branch_id);
                    exit();
                // Nếu mọi thứ đều ổn, thử upload file
                } else {
                    // echo 'test';
                    // $_SESSION['message'] = $target_file;
                    updateBranch($name, $address, $hotline, $target_file, $branch_id, $db);
                    header("Location: edit_store.php?branch_id=".$branch_id);
                    exit();
                }
            } else {
                // $_SESSION['message'] = 'test';
                updateBranch($name, $address, $hotline, $branch['image'], $branch_id, $db);
                header("Location: edit_store.php?branch_id=".$branch_id);
                exit();
            }
        } else {
            $_SESSION['message'] = 'Tên chi nhánh đã tồn tại';
            header("Location: edit_store.php?branch_id=".$branch_id);
            exit();
        }
        
    }

    function checkExistence($name,$branch_id,$db){
        $stmt = $db->prepare('SELECT * FROM branch WHERE LOWER(title) =? and branch_id != ?');
        $stmt->bind_param('si', strtolower($name),$branch_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    function updateBranch($name, $address, $hotline, $branch_image, $branch_id, $db){
        if($branch_image == '' || $branch_image == null){
            $branch_image = 'public/assets/img/default.png';
        }
        $stmt = $db->prepare('UPDATE branch set title = ?, address =?, hotline =?, image =? WHERE branch_id =?');
        $stmt->bind_param('ssssi', $name, $address, $hotline, $branch_image, $branch_id);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            $_SESSION['message'] = 'Cập nhật chi nhánh mới thành công';
            return true;
        } else {
            $_SESSION['message'] = 'Cập nhật chi nhánh mới thất bại';
            return false;
        }

    }

?>