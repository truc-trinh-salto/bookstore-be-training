<?php
    require_once('database.php');
	session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Simple Shopping Cart using Session in PHP</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="home.php">Book Store</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php 
                                if($_SESSION['user_id']) {
                                    echo $_SESSION['fullname'];
                                } else {
                                    echo 'Tài khoản';
                                }
                            ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php if($_SESSION['user_id']): ?>
                            <a class="dropdown-item" href="history.php">Lịch sử mua hàng</a>
                            <a class="dropdown-item" href="profile.php">Thông tin cá nhân</a>
							<a class="dropdown-item" href="logout.php">Đăng xuất</a>
                            <?php else:?>
                            <a class="dropdown-item" href="index.php">Đăng nhập</a>
                            <?php endif; ?>
                            <a class="dropdown-item" href="register.php">Đăng ký</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class ="nav-link"href="view_cart.php"><span class="badge"><?php echo count($_SESSION['cart']); ?></span> Cart <span class="glyphicon glyphicon-shopping-cart"></span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
	<h1 class="page-header text-center">Cart Details</h1>

	<div class="row mt-4 d-flex">
		<div class="col-sm-8 col-sm-offset-2">
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
			<form method="POST" action="save_cart.php">
			<table class="table table-bordered table-striped">
				<thead>
					<th></th>
					<th>Name</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Subtotal</th>
				</thead>
				<tbody>
					<?php
						//initialize total
						$total = 0;
						if(!empty($_SESSION['cart'])){
						//connection
						$conn = DBConfig::getDB();
						//create array of initail qty which is 1
 						
 						// if(!isset($_SESSION['qty_array'])){
 						// 	$_SESSION['qty_array'] = array_fill(0, count($_SESSION['cart']), 1);
 						// }
						$sql = "SELECT * FROM books WHERE book_id IN (".implode(',',$_SESSION['cart']).")";
						$query = $conn->query($sql);
							while($row = $query->fetch_assoc()){
								$index = array_search($row['book_id'], $_SESSION['cart']);
								?>
								<tr>
									<td>
										<a href="delete_cart.php?book_id=<?php echo $row['id']; ?>&index=<?php echo $index; ?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a>
									</td>
									<td><?php echo $row['title']; ?></td>
									<td>
										<?php if($row['sale'] && $row['sale'] != null && $row['sale'] != 0): ?>
                                            <div class="row">
                                                <del class="col-md-12"><?php echo number_format($row['price'],2) ?></del>
                                                <span class="col-md-12 text-danger">-<?php echo $row['sale'] ?>%</span>
                                                <span class="col-md-12 text-success"><?php echo number_format($row['price'] - $row['sale']*$row['price'] / 100,2)?></span>
                                            </div>
                                        <?php else:?>
                                            <span><?php echo number_format($row['price'],2) ?></span>
                                        <?php endif;?>
									</td>
									<input type="hidden" name="indexes[]" value="<?php echo $index; ?>">
									<td><input type="text" class="form-control" value="<?php echo $_SESSION['qty_array'][$index]; ?>" name="qty_<?php echo $index; ?>"></td>
									<td>
										<?php if($row['sale'] && $row['sale'] != null && $row['sale'] != 0): ?>
											<?php echo number_format($_SESSION['qty_array'][$index]*($row['price'] - $row['sale']*$row['price'] / 100), 2); ?>
                                        <?php else:?>
                                            <?php echo number_format($_SESSION['qty_array'][$index]*$row['price'], 2); ?>
                                        <?php endif;?>
									</td>
									<?php if($row['sale'] && $row['sale'] != null && $row['sale'] != 0){
												$total += $_SESSION['qty_array'][$index]*($row['price'] - $row['sale']*$row['price'] / 100);
											} else {
												$total += $_SESSION['qty_array'][$index]*$row['price'];
											} 
									?>
								</tr>
								<?php
								
							}
						}
						else{
							?>
							<tr>
								<td colspan="4" class="text-center">No Item in Cart</td>
                                </tr>
							<?php
						}
 
					?>
					<tr>
						<td colspan="4" align="right"><b>Total</b></td>
						<td><b><?php echo number_format($total, 2); ?></b></td>
					</tr>
				</tbody>
			</table>
			<a href="home.php" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
			<button type="submit" class="btn btn-success" name="save">Save Changes</button>
			<a href="clear_cart.php" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Clear Cart</a>
			<a href="<?php echo $_SESSION['user_id'] ? 'check_out.php' : 'index.php' ?>" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> Checkout</a>
			</form>
		</div>
	</div>
</div>
</body>
</html>