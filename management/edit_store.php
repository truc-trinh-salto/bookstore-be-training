<?php
    session_start();
    require_once('../database.php');

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
				<form action="" method="POST" class="forms-sample">
					<div class="form-group">
						<label for="exampleInputImageUrl"><?=_PHOTO?></label>
						<input type="text" class="form-control" id="exampleInputImageUrl" placeholder="<?=_PHOTO?>" name="image" value="<?php echo $branch['image'] ?>">
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

<?php
    if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $image = $_POST['image'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $hotline = $_POST['hotline'];
        // $hotItem = $_POST['hotItem'];
        // $categoryId = $_POST['category'];
        // $authors = $_POST['authors'];
        // $description = $_POST['description'];
        // echo $image;
        // echo $name;
        // echo $address;
        // echo $hotline;
        // echo $quantity;
        // echo $price;
        // echo $hotItem;
        // echo $categoryId;
        // echo $authors;
        // echo $description;
        

        $stmt = $db->prepare('UPDATE branch set title = ?, address =?, hotline =?, image =? WHERE branch_id =?');
        $stmt->bind_param('ssssi', $name, $address, $hotline, $image, $branch_id);
        $stmt->execute();
        // echo 'Thêm mới thành công';

        if($stmt->affected_rows > 0)
        {
            $_SESSION['message'] = 'Cập nhật chi nhánh mới thành công';
            header("refresh: 0;");
        }
        else
        {
            $_SESSION['message'] = 'Cập nhật chi nhánh mới thất bại';
            header("refresh: 0;");
        }
    }

?>