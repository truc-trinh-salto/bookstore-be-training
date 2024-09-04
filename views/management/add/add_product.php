<?php
    session_start();

    if(isset($_GET['lang']) && !empty($_GET['lang'])){
        $_SESSION['lang'] = $_GET['lang'];
        if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
         echo "<script type='text/javascript'> location.reload(); </script>";
        }
    }
    if(isset($_SESSION['lang'])){
            include "public/language/".$_SESSION['lang'].".php";
    }else{
            include "public/language/en.php";
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
        <?php include('views/management/partials/admin_header.php') ?>
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
				<form action="/product/addProduct" method="POST" class="forms-sample" enctype="multipart/form-data">
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

