<?php
    session_start();
    require_once('../database.php');

    $db = DBConfig::getDB();
    // $stmt = $db->prepare('SELECT * FROM categories');
    // $stmt->execute();
    // $result = $stmt->get_result();
    // $categories = $result->fetch_all(MYSQLI_ASSOC);
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
				<h4 class="card-title"><?=_ADDBRANCH?></h4>
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
						<input type="text" class="form-control" id="exampleInputImageUrl" placeholder="<?=_PHOTO?>" name="image">
					</div>
					<div class="form-group">
						<label for="exampleInputName1"><?=_BRANCHNAME?></label>
						<input type="text" class="form-control" id="exampleInputName1" placeholder="<?=_BRANCHNAME?>" name="name" required>
					</div>
                    <div class="form-group">
						<label for="exampleInputAuthor1"><?=_ADDRESS?></label>
						<input type="text" class="form-control" id="exampleInputAuthor1" placeholder="<?=_ADDRESS?>" name="address" required>
					</div>
                    <div class="form-group">
						<label for="exampleInputDescription1"><?=_HOTLINE?></label>
						<input type="text" class="form-control" id="exampleInputDescription1" placeholder="<?=_HOTLINE?>" name="hotline" required>
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
        echo $image;
        echo $name;
        echo $address;
        echo $hotline;
        // echo $quantity;
        // echo $price;
        // echo $hotItem;
        // echo $categoryId;
        // echo $authors;
        // echo $description;
        

        $stmt = $db->prepare('INSERT INTO branch (title, address, hotline, image) values (?,?,?,?)');
        $stmt->bind_param('ssss', $name, $address, $hotline, $image);
        $stmt->execute();
        $branch_id = $stmt->insert_id;

        echo 'Thêm mới thành công';

        if($stmt->affected_rows > 0)
        {
            $stmt = $db->prepare('SELECT * FROM books');
            $stmt->execute();
            $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            foreach($books as $book){
                $stmt = $db->prepare('INSERT INTO branchstockitem (book_id, branch_id,status,branch_select) values (?,?,1,0)');
                $stmt->bind_param('ii', $book['book_id'], $branch_id);
                $stmt->execute();
            }
            $_SESSION['message'] = 'Thêm chi nhánh mới thành công';
            header("refresh: 0;");
        }
        else
        {
            $_SESSION['message'] = 'Thêm chi nhánh mới thất bại';
            header("refresh: 0;");
        }
    }

?>