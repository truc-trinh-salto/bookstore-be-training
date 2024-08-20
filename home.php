<?php
    require_once('database.php');
    $db = DBConfig::getDB();
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
            $_SESSION['lang'] = 'en';
            include "public/language/en.php";
    }

    $category_last;


    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
        $_SESSION['qty_array'] = array();
    }

    $stmt = $db->prepare('SELECT c.category_id, c.name_category,b.total_books  FROM categories as c
                                LEFT JOIN (SELECT COUNT(*) as total_books,category_id FROM books GROUP BY category_id) as b
                                ON b.category_id = c.category_id  
                                WHERE b.total_books > 0 
                                limit 1');
    $stmt->execute();
    $categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmt = $db->prepare('SELECT * FROM categories');
    $stmt->execute();
    $categories_nav = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html>
   <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Demo PHP MVC</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <style>
        .dropdown:hover>.dropdown-menu {
            display: block;
            }
    </style>
</head>
<body>
    <div class="app">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="home.php">Book Store</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <form class="form-inline nav-item" method="GET" action="filter.php">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search_keyword">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?= _SEARCH ?></button>
            </form>
            <form action="filter.php" class="form-inline nav-item" method="GET">
                    <div class="form-group mr-sm-2">
                        <label for="minprice" class="navbar-brand"><?= _FROM ?></label>
                        <select class="form-control" id="minprice" name="minprice">
                            <option value="">---N/A---</option>
                            <option value="0">0</option>
                            <option value="50000">50.000</option>
                            <option value="200000">200.000</option>
                            <option value="300000">300.000</option>
                        </select>
                    </div>

                    <div class="form-group mr-sm-2">
                        <label for="maxprice" class="navbar-brand"><?= _TO ?></label>
                        <select class="form-control" id="maxprice" name="maxprice">
                            <option value="">---N/A---</option>
                            <option value="500000">50.000</option>
                            <option value="200000">200.000</option>
                            <option value="300000">500.000</option>
                            <option value="500000">1.000.000</option>  
                        </select>
                    </div>
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?= _FILTER?></button>
            </form>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= _CATEGORY ?></a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php foreach($categories_nav as $category):?>
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
                    <!-- <li class="nav-item">
                        <a class ="nav-link"href="view_cart.php"><span class="badge"><?php echo count($_SESSION['cart']); ?></span> Cart <span class="glyphicon glyphicon-shopping-cart"></span></a>
                    </li> -->
                    
                </ul>
            </div>
        </div>
    </nav>
        <div class="container">
            <script>
                function changeLang(){
                document.getElementById('form_lang').submit();
                }
            </script>
            <div class="d-flex justify-content-end">
                <form method='get' action='' id='form_lang' >
                    <?=_SELECTLANGUAGES?>: <select name='lang' onchange='changeLang();' >
                    <option value='en' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en'){ echo "selected"; } ?> >English</option>
                    <option value='vi' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'vi'){ echo "selected"; } ?> >Vietnamese</option>
                    </select>
                </form>
            </div>
            <div class="mt-4" id="categoryList">
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

            <div class="books-show" style="height: 900px;">
            <?php foreach($categories as $category): ?>
                <?php 
                    $stmt = $db->prepare('SELECT count(*) as total FROM books WHERE category_id =?');
                    $stmt->bind_param('i', $category['category_id']);
                    $stmt->execute();

                    $total =$stmt->get_result()->fetch_assoc();
                    $category_last= $category['category_id'];
                    ?>
                <div style="height:50px; width:50px;"></div>
                <h3><?php echo $category['name_category'] ?> (<?php echo $total['total'] ?>)</h3>

                <div class="row mt-4">
                    <?php 
                        $stmt = $db->prepare('SELECT * FROM books WHERE category_id =? LIMIT 8');
                        $stmt->bind_param('i', $category['category_id']);
                        $stmt->execute();

                        $books=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                    ?>
                    <?php foreach($books as $book):?> 
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-course-item">
                                <a href="">
                                    <?php 
                                        $stmt = $db->prepare('SELECT * FROM gallery_image WHERE book_id =? and isShow = 1');
                                        $stmt->bind_param('i', $book['book_id']);
                                        $stmt->execute();

                                        $image = $stmt->get_result()->fetch_assoc();
                                    ?>
                                    <img class="card-img-top" width="150" height="200" src="<?php echo $image['address']?:'https://tse4.mm.bing.net/th?id=OIP.ZiwfBrifIO4lV_Q-gIC7VQHaKx&pid=Api&P=0&h=180' ?>" alt="">
                                </a>
                                
                                <div class="card-body">
                                    <a href="detail_product.php?book_id=<?php echo $book['book_id'] ?>">
                                        <h5 class="card-title"><?= $book['title']?></h5>
                                    </a>
                                    <p class="card-text" ><?=_AUTHORS?>: <?= $book['authors']?></p>
                                        <?php if($book['sale'] && $book['sale'] != 0 && $book['sale'] != null): ?>
                                            <p class="text-success font-weight-bold"><del class="text-danger"><?php echo number_format($book['price'],2) ?></del> <?php echo number_format($book['price'] - $book['sale']*$book['price'] / 100,2)?></p>
                                        <?php else:?>
                                            <p class="font-weight-bold"><?php echo number_format($book['price'],2) ?></p>
                                        <?php endif;?>

                                    <input type="hidden" name="book_id" value="<?= $book['book_id']?>">
                                    
                                    <?php if($book['sale'] != 0 && $book['sale'] != null): ?>
                                        <input type="hidden" name="price" value="<?php echo $book['price'] - $book['sale']*$book['price'] / 100?>">
                                    <?php else:?>
                                        <input type="hidden" name="price" value="<?php echo $book['price']?>">
                                    <?php endif;?>
                                    

                                    <button type="submit" class ="btn btn-primary shadow-0 me-1 btn-add-to-cart" data-book-id="<?php echo $book['book_id']; ?>" name="add-to-cart" >
                                    <?=_ADDTOCART?>
                                    </button>
                                    
                                </div>
                        </div>
                    </div>

                    <?php endforeach;?>
                </div>
                <?php endforeach; ?>
                <div class="load-more" lastID="<?php echo $category_last ?>" style="display: none;">
                        <span>Loading...</span>
                </div>
            </div>
                
            </div>
        </div>
    </div>
    
</body>
</html>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
    // $(document).ready(function() {
    //     let isLoading = false;
    //     $(window).scroll(function() {
    //         if(isLoading) return;
    //         const lastID = $('.load-more').attr('lastID');
    //         const distance = $(document).height() - $(window).height();
    //         // alert(distance - $(window).scrollTop());
    //         if(((distance - $(window).scrollTop()) < 1) && lastID != 0) {
    //             // alert('Loading more...');
    //             isLoading = true;
    //             $.ajax({
    //                 url: 'getData.php',
    //                 type: 'POST',
    //                 data: {id: lastID},
    //                 beforeSend: function() {
    //                     $('.load-more').show();
    //                 },
    //                 success: function(html) {
    //                     $('.load-more').remove();
    //                     $('#categoryList').append(html);
    //                     isLoading = false;
    //                 },
    //                 error: function(error) {
    //                     console.error(error);
    //                     $('.load-more').hide();
    //                     isLoading = false;
    //                 }
    //             })
    //         }
    //     });
    // });


    // document.addEventListener('DOMContentLoaded', function () {

    //     const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');
    //     addToCartButtons.forEach(button => {
    //         button.addEventListener('click', function (event) {
    //             event.preventDefault();
    //             const productId = this.dataset.bookId;
    //             const quantity = 1;
    //             alert(productId);
                
    //             $.ajax({
    //                 url: 'add_to_cart.php',
    //                 method: 'POST',
    //                 data: {book_id: productId, quantity: quantity},
    //                 success: function (response) {
    //                     // const cartCount = JSON.parse(response).count;
    //                     // document.querySelector('.badge').textContent = cartCount;
    //                     // alert(JSON.parse(response).message);
    //                     $('.display-cart').remove();
    //                     $('.display-count-cart').remove();
    //                     alert(response);
    //                     $('#show_cart').append(response);
    //                 },
    //                 error: function (error) {
    //                     console.error(error);
    //                 }
    //             });
    //         });
    //     });
    // });

    if($(window).height() >= $(document).height()){
        const lastID = $('.load-more').attr('lastID');
        $.ajax({
                url: 'getData.php',
                type: 'POST',
                data: {id: lastID},
                beforeSend: function() {
                    $('.load-more').show();
                },
                success: function(html) {
                    $('.load-more').remove();
                    $('#categoryList').append(html);
                    isLoading = false;
                },
                error: function(error) {
                    console.error(error);
                    $('.load-more').hide();
                    isLoading = false;
                }
            });
    }


    document.addEventListener('DOMContentLoaded', function () {


    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('btn-add-to-cart')) {
            event.preventDefault();
            const productId = event.target.dataset.bookId;
            const quantity = 1;

            $.ajax({
                url: 'add_to_cart.php',
                method: 'POST',
                data: {book_id: productId, quantity: quantity},
                success: function (response) {
                    // const cartCount = JSON.parse(response).count;
                        // document.querySelector('.badge').textContent = cartCount;
                        // alert(JSON.parse(response).message);
                        $('.display-cart').remove();
                        $('.display-count-cart').remove();
                        alert(response);
                        $('#show_cart').append(response);
                },
                error: function (error) {
                    console.error(error);
                }
            });
        }
    });

    let isLoading = false;
    $(window).scroll(function() {
        
        if (isLoading) return;
        const lastID = $('.load-more').attr('lastID');
        const distance = $(document).height() - $(window).height();
        if (((distance - $(window).scrollTop()) < 1) && lastID != 0) {
            // alert($('.books-show').scrollTop());
            isLoading = true;
            $.ajax({
                url: 'getData.php',
                type: 'POST',
                data: {id: lastID},
                beforeSend: function() {
                    $('.load-more').show();
                },
                success: function(html) {
                    $('.load-more').remove();
                    $('#categoryList').append(html);
                    isLoading = false;
                },
                error: function(error) {
                    console.error(error);
                    $('.load-more').hide();
                    isLoading = false;
                }
            });
        }
    });

    



});
</script>
<?php

?>
