<?php
    session_start();
    require_once('../database.php');

    $db = DBConfig::getDB();
    $stmt = $db->prepare('SELECT * FROM categories');
    $stmt->execute();
    $result = $stmt->get_result();
    $categories = $result->fetch_all(MYSQLI_ASSOC);

    $code_id = $_GET['code_id'];


    $stmt = $db->prepare('SELECT * FROM codesale WHERE id = ?');
    $stmt->bind_param('i', $code_id);
    $stmt->execute();

    $code = $stmt->get_result()->fetch_assoc();


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
				<h4 class="card-title">Thêm mã giảm giá mới</h4>
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
						<label for="exampleInputName1">Mô tả</label>
						<input type="text" class="form-control" id="exampleInputName1" placeholder="Mô tả" name="description" value="<?php echo $code['description']?>">
					</div>

                    <div class="form-group">
						<label for="exampleInputDescription1">Mã</label>
						<input type="text" class="form-control" id="exampleInputDescription1" placeholder="Giá trị" name="code" value="<?php echo $code['code']?>">
					</div>


                    <div class="form-group">
						<label for="exampleInputAuthor1">Đơn giá tối thiểu</label>
						<input type="number" class="form-control" id="exampleInputAuthor1" placeholder="Tối thiểu" name="min" value="<?php echo $code['min']?>">
					</div>

                    <div class="form-group">
						<label for="exampleInputHot">Hình thức giảm giá</label>
						<select class="form-control" id="exampleInputHot" name="method" id="method" onchange="handleSelectChange(event)">
							<option value="1" <?php if(!str_contains($code['value'], '%')){
                                                        echo 'selected';
                                                    // str_replace('%', '', $codesale['value']);
                                                }?>>Giá tiền</option>
							<option value="0" <?php if(str_contains($code['value'], '%')){
                                                        echo 'selected';
                                                    // str_replace('%', '', $codesale['value']);
                                                }?>>Phần trăm</option>
						</select>
					</div>

                    <div class="form-group">
						<label for="exampleInputDescription1">Giá trị</label>
						<input type="number" class="form-control" id="exampleInputDescription1" placeholder="Giá trị" name="value" value="<?php if(str_contains($code['value'], '%')){
                                                                                                                                                $value_tmp = $code['value'];
                                                                                                                                                str_replace('%', '', $value_temp);
                                                                                                                                                echo $value_tmp;
                                                                                                                                            } else {
                                                                                                                                                echo $code['value'];
                                                                                                                                            }
                                                                                                                                                ?>">
					</div>

                    <div class="form-group" style="display: none;" id="max">
						<label for="exampleInputDescription1">Số tiền giảm tối đa</label>
						<input type="number" class="form-control" id="exampleInputDescription1" placeholder="Giảm tối đa" name="max" value="<?php echo $code['max']?>">
					</div>

                    <div class="form-group">
						<label for="startDate">Hết hiệu lực</label>
						<input type="datetime-local" class="form-control" id="startDate" placeholder="Quantity" name="startDate" value="<?php echo date('Y-m-d H:i:s',strtotime($code["startAt"])) ?>">
					</div>

                    <div class="form-group">
						<label for="endDate">Hết hiệu lực</label>
						<input type="datetime-local" class="form-control" id="endDate" placeholder="Quantity" name="endDate" value="<?php echo date('Y-m-d H:i:s',strtotime($code["endAt"])) ?>">
					</div>

					<div class="form-group">
						<label for="exampleInputHot">Kích hoạt</label>
						<select class="form-control" id="exampleInputHot" name="activate" value="<?php echo $code['deactivate']?>">
							<option value="1" <?php if($code['deactivate'] == 1) echo 'selected'?>>Có</option>
							<option value="0" <?php if($code['deactivate'] == 0) echo 'selected'?>>Không</option>
						</select>
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

<script>
    function handleSelectChange(event) {

        var selectElement = event.target;
        var value = selectElement.value;
        if(value == 0){
            document.getElementById('max').style.display = 'block';
        } else {
            document.getElementById('max').style.display = 'none';
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
            $value = $value. '%';
        }
        

        $stmt = $db->prepare('UPDATE codesale SET code = ?, startAt = ?, endAt = ?, value = ?, min = ?, max = ?, description = ?, deactivate = ? where id = ?');
        $stmt->bind_param('sssiiisii', $code, $startAt, $endAt, $value, $min, $max, $description, $activate, $code_id);
        $stmt->execute();

        if($stmt->affected_rows > 0)
        {
            $_SESSION['message'] = 'Cập nhật mã thành công';
            header("refresh: 0");
        }
        else
        {
            $_SESSION['message'] = 'Cập nhậ mã thất bại';
            header("refresh: 0");
        }
    }

?>