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
    $stmt = $db->prepare('SELECT * FROM categories');
    $stmt->execute();
    $result = $stmt->get_result();
    $categories = $result->fetch_all(MYSQLI_ASSOC);

    $code_id = $_GET['code_id'];


    $stmt = $db->prepare('SELECT * FROM codesale WHERE id = ?');
    $stmt->bind_param('i', $code_id);
    $stmt->execute();

    $codesale = $stmt->get_result()->fetch_assoc();


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
				<h4 class="card-title"><?=_EDITCODESALE?></h4>
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
						<label for="exampleInputName1"><?=_DESCRIPTION?></label>
						<input type="text" class="form-control" id="exampleInputName1" placeholder="<?=_DESCRIPTION?>" name="description" value="<?php echo $codesale['description']?>" required>
					</div>

                    <div class="form-group">
						<label for="exampleInputDescription1"><?=_CODE?></label>
						<input type="text" class="form-control" id="exampleInputDescription1" placeholder="<?=_CODE?>" name="code" value="<?php echo $codesale['code']?>" required>
					</div>


                    <div class="form-group">
						<label for="exampleInputAuthor1"><?=_MIN?></label>
						<input type="number" class="form-control" id="exampleInputAuthor1" placeholder="<?=_MIN?>" name="min" value="<?php echo $codesale['min']?>" required>
					</div>

                    <div class="form-group">
						<label for="exampleInputHot"><?=_METHOD?></label>
						<select class="form-control" id="exampleInputHot" name="method" id="method" onchange="handleSelectChange(event)">
							<option value="1" <?php if($codesale['method'] == 1){
                                                        echo 'selected';
                                                    // str_replace('%', '', $codesale['value']);
                                                }?>><?=_PRICE?></option>
							<option value="0" <?php if($codesale['method'] == 0){
                                                        echo 'selected';
                                                    // str_replace('%', '', $codesale['value']);
                                                }?>><?=_PERCENT?></option>
						</select>
					</div>

                    <div class="form-group">
						<label for="exampleInputDescription1"><?=_VALUE?></label>
						<input type="number" class="form-control" id="value-discount" placeholder="Giá trị" name="value" min="0" value="<?php echo $codesale['value'] ?>" <?php if($codesale['method'] == 0){
                            echo "max='100'";
                        }?> required>
					</div>

                    <div class="form-group" style="display: <?php echo $codesale['method'] == 0 ? 'block' : 'none'?>;" id="max">
						<label for="exampleInputDescription1"><?=_MAX?></label>
						<input type="number" class="form-control" id="exampleInputDescription1" placeholder="<?=_MAX?>" name="max" value="<?php echo $codesale['max']?>">
					</div>

                    <div class="form-group">
						<label for="startDate"><?=_STARTAT?></label>
						<input type="datetime-local" class="form-control" id="startDate" placeholder="Quantity" name="startDate" value="<?php echo date('Y-m-d H:i:s',strtotime($codesale["startAt"])) ?>">
					</div>

                    <div class="form-group">
						<label for="endDate"><?=_ENDAT?></label>
						<input type="datetime-local" class="form-control" id="endDate" placeholder="Quantity" name="endDate" value="<?php echo date('Y-m-d H:i:s',strtotime($codesale["endAt"])) ?>">
					</div>

					<div class="form-group">
						<label for="exampleInputHot"><?=_ACTIVATE?></label>
						<select class="form-control" id="exampleInputHot" name="activate" value="<?php echo $codesale['deactivate']?>">
							<option value="1" <?php if($codesale['deactivate'] == 1) echo 'selected'?>><?=_YES?></option>
							<option value="0" <?php if($codesale['deactivate'] == 0) echo 'selected'?>><?=_NO?></option>
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

<?php
    if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $description = $_POST['description'];
        $min = $_POST['min'];
        $max = $_POST['max'];
        $startAt = $_POST['startDate'];
        $endAt = $_POST['endDate'];
        $activate = $_POST['activate'];
        $method = $_POST['method'];
        $value = $_POST['value'];
        $code = $_POST['code'];
        echo $activate;
        if($method == 0){
           if($value > 100){
                $value = 100;
           }
        }
        if(checkExistence($code,$codesale['id'],$db)){
            $_SESSION['message'] = "Code của mã này đã tồn tại";
            header("refresh: 0");
        } else {
            $stmt = $db->prepare('UPDATE codesale SET code = ?, startAt = ?, endAt = ?, value = ?, min = ?, max = ?, description = ?, deactivate = ?, method=? where id = ?');
            $stmt->bind_param('sssiiisiii', $code, $startAt, $endAt, $value, $min, $max, $description, $activate,$method, $code_id);
            $stmt->execute();

            if($stmt->affected_rows > 0)
            {
                $_SESSION['message'] = 'Cập nhật mã thành công';
                header("refresh: 0");
            }
            else
            {
                $_SESSION['message'] = 'Cập nhật mã thất bại';
                header("refresh: 0");
            }
        }
        
    }

    function checkExistence($name,$code,$db){
        $stmt = $db->prepare('SELECT * FROM codesale WHERE code =? and id != ?');
        $stmt->bind_param('si', $name,$code);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

?>