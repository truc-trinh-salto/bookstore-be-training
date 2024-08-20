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
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><?=_ADDPRODUCT?></h4>
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
                        <h6><?=_UPLOADGALLERY?></h6>
                        <input type="file" class="text-center center-block file-upload" name="book-image">
                    </div>

					<div class="form-group">
						<label for="exampleInputName1"><?=_BOOKNAME?><span class="text-danger">(*)</span></label>
						<input type="text" class="form-control" id="exampleInputName1" placeholder="<?=_BOOKNAME?>" name="name" required>
					</div>
                    <div class="form-group">
						<label for="exampleInputAuthor1"><?=_AUTHORS?><span class="text-danger">(*)</span></label>
						<input type="text" class="form-control" id="exampleInputAuthor1" placeholder="<?=_AUTHORS?>" name="authors" required>
					</div>
                    <div class="form-group">
						<label for="exampleInputDescription1"><?=_DESCRIPTION?></label>
						<input type="text" class="form-control" id="exampleInputDescription1" placeholder="<?=_DESCRIPTION?>" name="description">
					</div>
					<div class="form-group">
						<label for="exampleInputQuantity"><?=_QUANTITY?></label>
						<input type="number" class="form-control" id="exampleInputQuantity" placeholder="<?=_QUANTITY?>" name="quantity" min="0" value=0>
					</div>
					<div class="form-group">
						<label for="exampleInputHot"><?=_SHOWHOME?></label>
						<select class="form-control" id="exampleInputHot" name="hotItem">
							<option value="1"><?=_YES?></option>
							<option value="0"><?=_NO?></option>
						</select>
					</div>
					<div class="form-group">
						<label for="exampleInputCategory"><?=_CATEGORY?><span class="text-danger">(*)</span></label>
						<select class="form-control" id="exampleInputCategory" th:field="*{category.id}" name="category" required>
                            <?php foreach($categories as $category):?>
                                <option value="<?php echo $category['category_id']?>"><?= $category['name_category']?></option>
                            <?php endforeach;?>
						</select>
					</div>
					<div class="form-group">
						<label for="exampleInputPrice"><?=_PRICE?><span class="text-danger">(*)</span></label>
						<input type="number" class="form-control" id="exampleInputPrice" name="price" required min="1000" value="1000">
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
        $isValid = true;
        $image = $_POST['image'];
        $name = $_POST['name'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $hotItem = $_POST['hotItem'];
        $categoryId = $_POST['category'];
        $authors = $_POST['authors'];
        $description = $_POST['description'];

        if(checkExistenceBook($name, $db)){
            $_SESSION['message'] = "PRODUCT'S NAME : ".$name." EXISTED";
            $isValid = false;
        } else if($quantity && $quantity < 0){
            $_SESSION['message'] .= "</br>QUANTITY CANNOT BE NEGATIVE";
            $isValid = false;
        } else if($price && $price < 1000){
            $_SESSION['message'] .= "</br>PRICE CANNOT BE NEGATIVE";
            $isValid = false;
        }

        if($isValid){
            if(isset($_FILES["book-image"]["name"])){
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
                    $_SESSION['message'] = "File is not an image.";
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
                    header("Location: add_product.php");
                    exit();
                // Nếu mọi thứ đều ổn, thử upload file
                } else {
                        echo "The file ". basename( $_FILES["book-image"]["name"]). " has been uploaded.";
                
                        $book_id = addBook($image, $name, $quantity, $price, $hotItem, $categoryId, $authors, $description,$db);
        
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
            } else {
                $book_id = addBook($image, $name, $quantity, $price, $hotItem, $categoryId, $authors, $description,$db);
                if($book_id){
                    $_SESSION['message'] = 'Thêm mới sản phẩm thành công';
                } else {
                    $_SESSION['message'] = 'Thêm mới sản phẩm thất bại';
                }
            }
            
        } else {
            header('Location: add_product.php');
            exit();
        }




    }


    function checkExistenceBook($name, $db){
        $stmt = $db->prepare("SELECT * FROM books WHERE title =?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() > 0;
    }

    function addBook($image, $name, $quantity, $price, $hotItem, $categoryId, $authors, $description,$db){
        $stmt = $db->prepare('INSERT INTO books (image, title, stock, price, hotItem, category_id, authors, description, created_at) values (?,?,?,?,?,?,?,?,NOW())');
        $stmt->bind_param('ssidiiss', $image, $name, $quantity, $price, $hotItem, $categoryId, $authors, $description);
        $stmt->execute();

        $book_id = $stmt->insert_id;

        $stmt = $db->prepare('SELECT * FROM branch');
        $stmt->execute();
        $branches = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach($branches as $branch){
            $stmt = $db->prepare('INSERT INTO branchstockitem (book_id, branch_id, status,branch_select) values (?,?,1,0)');
            $stmt->bind_param('ii', $book_id, $branch['branch_id']);
            $stmt->execute();
        }
        return $book_id;
    }
    

?>