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
		<div class="card">
			<div class="card-body">
				<h4 class="card-title"><?=_ADDCODESALE?></h4>
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
				<form action="/codesale/addCodesale" method="POST" class="forms-sample">

					<div class="form-group">
						<label for="exampleInputName1"><?=_DESCRIPTION?></label>
						<input type="text" class="form-control" id="exampleInputName1" placeholder="<?=_DESCRIPTION?>" name="description" required>
					</div>

                    <div class="form-group">
						<label for="exampleInputDescription1"><?=_CODE?></label>
						<input type="text" class="form-control" id="exampleInputDescription1" placeholder="<?=_CODE?>" name="code" required>
					</div>


                    <div class="form-group">
						<label for="exampleInputAuthor1"><?=_MIN?></label>
						<input type="number" class="form-control" id="exampleInputAuthor1" placeholder="<?=_MIN?>" name="min" min="0" value="0" required>
					</div>

                    <div class="form-group">
						<label for="exampleInputHot"><?=_METHOD?></label>
						<select class="form-control" id="exampleInputHot" name="method" id="method" onchange="handleSelectChange(event)">
							<option value="1" selected><?=_PRICE?></option>
							<option value="0"><?=_PERCENT?></option>
						</select> 
					</div>

                    <div class="form-group">
						<label for="exampleInputDescription1"><?=_VALUE?></label>
						<input type="number" class="form-control" id="value-discount" placeholder="<?=_VALUE?>" name="value" min="0" value="0">
					</div>

                    <div class="form-group" style="display: none;" id="max">
						<label for="exampleInputDescription1"><?=_MAX?></label>
						<input type="number" class="form-control" id="exampleInputDescription1" placeholder="<?=_MAX?>" name="max">
					</div>

                    <div class="form-group">
						<label for="startDate"><?=_STARTAT?></label>
						<input type="datetime-local" class="form-control" id="startDate" placeholder="Quantity" name="startDate">
					</div>

                    <div class="form-group">
						<label for="endDate"><?=_ENDAT?></label>
						<input type="datetime-local" class="form-control" id="endDate" placeholder="Quantity" name="endDate">
					</div>

					<div class="form-group">
						<label for="exampleInputHot"><?=_ACTIVATE?></label>
						<select class="form-control" id="exampleInputHot" name="activate">
							<option value="1"><?=_YES?></option>
							<option value="0"><?=_NO?></option>
						</select>
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

<script>
    function handleSelectChange(event) {

        var selectElement = event.target;
        var value = selectElement.value;
        if(value == 0){
            document.getElementById('max').style.display = 'block';
            $("#value-discount").attr("max",100);
        } else {
            document.getElementById('max').style.display = 'none';
            $("#value-discount").removeAttr("max");
            
        }
    }
</script>

