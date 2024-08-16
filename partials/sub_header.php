<style>
        .dropdown:hover>.dropdown-menu {
            display: block;
            }
    </style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="home.php">Book Store</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=_CATEGORY?></a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php foreach($categories as $category):?>
                                <a class="dropdown-item" href="category.php?category_id=<?php echo $category['category_id'];?>&name=<?php echo $category['name_category'];?>"><?php echo $category['name_category'];?></a>
                            <?php endforeach;?>    
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php 
                                if($_SESSION['user_id']) {
                                    echo $_SESSION['fullname'];
                                } else {
                                    echo _USERNAME;
                                }
                            ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php if($_SESSION['user_id']): ?>
                                <a class="dropdown-item" href="history.php"><?= _HISTORY?></a>
                                <a class="dropdown-item" href="profile.php"><?= _PROFILE?></a>
                                <a class="dropdown-item" href="codesale.php"><?= _CODESALE?></a>
                                <a class="dropdown-item" href="store_system.php"><?= _SYSTEM?></a>
                                <?php else:?>
                                <a class="dropdown-item" href="index.php"><?=_LOGIN ?></a>
                                <?php endif; ?>
                                <a class="dropdown-item" href="logout.php"><?=_LOGOUT ?></a>
                        </div>
                    </li>

                    <li class="nav-item dropdown" id="show_cart">
                        <a class="nav-link dropdown-toggle display-count-cart" href="view_cart.php" id="navbarDropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="badge"><?php echo count($_SESSION['cart']); ?></span> Cart <span class="glyphicon glyphicon-shopping-cart"></span> 
                        </a>
                        <?php if(count($_SESSION['cart']) >0 ): ?>
                        <div class="dropdown-menu display-cart"aria-labelledby="navbarDropdown">
                            <?php
                                $stmt = $db->prepare("SELECT * FROM books WHERE book_id IN (".implode(',',$_SESSION['cart']).")");
                                $stmt->execute();
                                $book_cart = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                            ?>
                            <?php foreach($book_cart as $cart):?>
                                <div class="row mt-4">
                                    <div class="col-6">
                                        <?php 
                                            $stmt = $db->prepare('SELECT * FROM gallery_image WHERE book_id =? and isShow = 1');
                                            $stmt->bind_param('i', $cart['book_id']);
                                            $stmt->execute();

                                            $image_cart = $stmt->get_result()->fetch_assoc();
                                        ?>
                                        <img width="70" height="70" src="<?php echo $image_cart['address'];?>">
                                    </div>
                                    <div class="col-6">
                                        <a href=""><?php echo $cart['title'] ?></a>
                                        <?php 
                                            $index = array_search($cart['book_id'], $_SESSION['cart']);
                                            $price = $cart['price'];
                                            if($cart['sale'] != null && $cart['sale'] > 0) {
                                                $price = $price - ($price * $cart['sale'] / 100);
                                            }
                                        ?>
                                        <p><?php echo $_SESSION['qty_array'][$index] ?></p>
                                        <p class="font-weight-bold text-info" style="font-size:10px;"><?php echo number_format($price * $_SESSION['qty_array'][$index],2)?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif;?>
                    </li>
                    <li class="nav-item nav-link">
					<script>
						function changeLang(){
						document.getElementById('form_lang').submit();
						}
					</script>
						<form method='get' action='' id='form_lang'>
                            <input type='hidden' name='order_id' value=<?=$order_id?>>
                            <input type='hidden' name='book_id' value=<?=$book_id?>>
							<?=_SELECTLANGUAGES?>: <select name='lang' class="text-info font-weight-bold" onchange='changeLang();' >
							<option value='en' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en'){ echo "selected"; } ?> >English</option>
							<option value='vi' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'vi'){ echo "selected"; } ?> >Vietnamese</option>
							</select>
						</form>
					</li>
                    
                    <!-- <li class="nav-item">
                        <a class ="nav-link"href="view_cart.php"><span class="badge"><?php echo count($_SESSION['cart']); ?></span> Cart <span class="glyphicon glyphicon-shopping-cart"></span></a>
                    </li> -->
                    
                </ul>
            </div>
        </div>
    </nav>