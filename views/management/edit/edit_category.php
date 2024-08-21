<?php
    session_start();
    require_once('../../../database.php');
    $db = DBConfig::getDB();

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

    $category;
    if(isset($_GET['category_id'])){
        $category_id = $_GET['category_id'];
        $stmt = $db->prepare('SELECT * FROM categories WHERE category_id = ?');
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $category = $stmt->get_result()->fetch_assoc();
    }

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
				<h4 class="card-title"><?=_EDITCATEGORY?></h4>
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
						<label for="exampleInputName1"><?=_CATEGORYNAME?></label>
						<input type="text" class="form-control" id="exampleInputName1" placeholder="Product Name" name="name" value="<?php echo $category['name_category'] ?>" required>
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
        if(!checkExistence($_POST['name'], $db)){
            $name = $_POST['name'];

            $stmt = $db->prepare('UPDATE categories set name_category =? WHERE category_id=?');
            $stmt->bind_param('ss', $name, $category_id);
            $stmt->execute();

            if($stmt->affected_rows > 0)
            {
                $_SESSION['message'] = 'Cập nhật thành công';
            }
            else
            {
                $_SESSION['message'] = 'Cập nhật thất bại';
            }
        } else {
            $_SESSION['message'] = 'Tên thể loại đã tồn tại';
        }
        header("refresh: 0");
    }

    function checkExistence($name, $db){
        $stmt = $db->prepare('SELECT * FROM categories WHERE LOWER(name_category) =?');
        $stmt->bind_param('s', strtolower($name));
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

?>