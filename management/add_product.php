<?php
    session_start();
    require_once('../database.php');

    $db = DBConfig::getDB();
    $stmt = $db->prepare('SELECT * FROM categories');
    $stmt->execute();
    $result = $stmt->get_result();
    $categories = $result->fetch_all(MYSQLI_ASSOC);
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
				<h4 class="card-title">Thêm sản phẩm mới</h4>
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
                    <div class="text-center">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT3cD47c9xUZyKlO3j3z9vdBHV0P2BIwfkeWg&s" class="avatar img-circle img-thumbnail" alt="avatar" height="300" width="300">
                        <h6>Upload a different photo...</h6>
                        <input type="file" class="text-center center-block file-upload" name="book-image">
                    </div>

					<div class="form-group">
						<label for="exampleInputName1">Tên sản phẩm</label>
						<input type="text" class="form-control" id="exampleInputName1" placeholder="Product Name" name="name">
					</div>
                    <div class="form-group">
						<label for="exampleInputAuthor1">Tác giả</label>
						<input type="text" class="form-control" id="exampleInputAuthor1" placeholder="Authors" name="authors">
					</div>
                    <div class="form-group">
						<label for="exampleInputDescription1">Mô tả</label>
						<input type="text" class="form-control" id="exampleInputDescription1" placeholder="Description" name="description">
					</div>
					<div class="form-group">
						<label for="exampleInputQuantity">Số lượng</label>
						<input type="number" class="form-control" id="exampleInputQuantity" placeholder="Quantity" name="quantity">
					</div>
					<div class="form-group">
						<label for="exampleInputHot">Hiển thị trang chủ</label>
						<select class="form-control" id="exampleInputHot" name="hotItem">
							<option value="1">Có</option>
							<option value="0">Không</option>
						</select>
					</div>
					<div class="form-group">
						<label for="exampleInputCategory">Thể loại</label>
						<select class="form-control" id="exampleInputCategory" th:field="*{category.id}" name="category">
                            <?php foreach($categories as $category):?>
                                <option value="<?php echo $category['category_id']?>"><?= $category['name_category']?></option>
                            <?php endforeach;?>
						</select>
					</div>
					<div class="form-group">
						<label for="exampleInputPrice">Giá tiền</label>
						<input type="number" class="form-control" id="exampleInputPrice" name="price">
					</div>
					<button type="submit" name="submit" class="btn btn-success mr-2">Save</button>
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
        $image = $_POST['image'];
        $name = $_POST['name'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $hotItem = $_POST['hotItem'];
        $categoryId = $_POST['category'];
        $authors = $_POST['authors'];
        $description = $_POST['description'];

        
        $stmt = $db->prepare('INSERT INTO books (image, title, stock, price, hotItem, category_id, authors, description, created_at) values (?,?,?,?,?,?,?,?,NOW())');
        $stmt->bind_param('ssidiiss', $image, $name, $quantity, $price, $hotItem, $categoryId, $authors, $description);
        $stmt->execute();

        $book_id = $stmt->insert_id;
        // echo $_FILES['book-image'];
        // echo basename($_FILES["book-image"]["name"]);
        $target_dir = "public/assets/img/";
        $target_file = $target_dir . basename($_FILES["book-image"]["name"]);

        echo $target_file;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Kiểm tra file có phải là hình ảnh thật hay không
        $check = getimagesize($_FILES["book-image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Kiểm tra nếu file đã tồn tại
        if (file_exists($target_file)) {
            // echo "Sorry, file already exists.";
            // $uploadOk = 0;
        } else {
            move_uploaded_file($_FILES["book-image"]["tmp_name"], $target_dir);
        }

        // Giới hạn kích thước file
        if ($_FILES["image"]["size"] > 500000) {
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
            echo "Sorry, your file was not uploaded.";
        // Nếu mọi thứ đều ổn, thử upload file
        } else {
                echo "The file ". basename( $_FILES["book-image"]["name"]). " has been uploaded.";

                // Lưu đường dẫn hình ảnh vào cơ sở dữ liệu
                $stmt = $db->prepare("INSERT INTO gallery_image(address,book_id,isShow) values(?,?,1)");
                $stmt->bind_param("si", $target_file, $book_id);
                $stmt->execute();
                if($stmt->affected_rows > 0)
                {
                    $_SESSION['message'] = 'Thêm mới sản phẩm thành công';
                }
                else
                {
                    $_SESSION['message'] = 'Thêm mới sản phẩm thất bại';
                }
                
        }
    }
    

?>