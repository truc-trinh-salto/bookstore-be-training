<?php
    require_once('../../database.php');
    $db = DBConfig::getDB();
    session_start();

    if(isset($_GET['lang']) && !empty($_GET['lang'])){
        $_SESSION['lang'] = $_GET['lang'];
        if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
         echo "<script type='text/javascript'> location.reload(); </script>";
        }
       }
       if(isset($_SESSION['lang'])){
            include "../../public/language/".$_SESSION['lang'].".php";
       }else{
            include "../../public/language/en.php";
       }

    $category_id = $_GET['category_id'];
    $name= $_GET['name'];

    $stmt = $db->prepare('SELECT * FROM categories where category_id = ?');
    $stmt->bind_param('i',$category_id);
    $stmt->execute();

    $current_cate = $stmt->get_result()->fetch_assoc();

    $books;

    $limit = 6;

    if(isset($_GET['minprice']) && isset($_GET['maxprice'])) {
        $minprice = $_GET['minprice'];
        $maxprice = $_GET['maxprice'];
        if ($minprice == null && $maxprice == null) {
            $stmt = $db->prepare('SELECT * FROM books where category_id = ?');
            $stmt->bind_param("i", $category_id);
        } else if($minprice == null) {
            $stmt = $db->prepare('SELECT * FROM books WHERE category_id = ? AND price <=?');
            $stmt->bind_param('id', $category_id,$maxprice);
        } else if ($maxprice == null) {
            $stmt = $db->prepare('SELECT * FROM books WHERE category_id = ? AND price >=?');
            $stmt->bind_param('id', $category_id, $minprice);
        } else {
            $stmt = $db->prepare('SELECT * FROM books WHERE category_id = ? AND price >=? AND price <=?');
            $stmt->bind_param('idd',$category_id, $minprice, $maxprice); 
        }
    } else {
        $stmt = $db->prepare('SELECT * FROM books where category_id = ?');
        $stmt->bind_param("i", $category_id);
    }

    $stmt->execute();

    $number_result  = $stmt->get_result()->num_rows;

    $number_page = ceil($number_result/ $limit);
    
    if(!isset($_GET['page'])){
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    $page_first = ($page - 1) * $limit;

    // $stmt = $db->prepare("SELECT * FROM books WHERE category_id =? LIMIT ?,?");
    // $stmt->bind_param("iii", $category_id, $page_first, $limit);
    // $stmt->execute();

    if(isset($_GET['minprice']) && isset($_GET['maxprice'])) {
        $minprice = $_GET['minprice'];
        $maxprice = $_GET['maxprice'];
        if ($minprice == null && $maxprice == null) {
            $stmt = $db->prepare('SELECT * FROM books where category_id = ? LIMIT ?,?');
            $stmt->bind_param("iii", $category_id, $page_first, $limit);
        } else if($minprice == null) {
            $stmt = $db->prepare('SELECT * FROM books WHERE category_id = ? AND price <=? LIMIT ?,?');
            $stmt->bind_param('idii', $category_id,$maxprice,$page_first, $limit);
        } else if ($maxprice == null) {
            $stmt = $db->prepare('SELECT * FROM books WHERE category_id = ? AND price >=? LIMIT ?,?');
            $stmt->bind_param('idii', $category_id, $minprice,$page_first, $limit);
        } else {
            $stmt = $db->prepare('SELECT * FROM books WHERE category_id = ? AND price >=? AND price <=? LIMIT ?,?');
            $stmt->bind_param('iddii',$category_id, $minprice, $maxprice,$page_first, $limit); 
        }
    } else {
        $stmt = $db->prepare('SELECT * FROM books where category_id = ? LIMIT ?,?');
        $stmt->bind_param("iii", $category_id, $page_first, $limit);
    }

    $stmt->execute();
    $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
        $_SESSION['qty_array'] = array();
    }

    $stmt = $db->prepare('SELECT * FROM categories');
    $stmt->execute();
    $categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

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
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?= _SEARCH?></button>
            </form>
            <form action="" class="form-inline nav-item" method="GET">
                <input type="hidden" name="category_id" value="<?= $category_id?>">
                <input type="hidden" name="name" value="<?= $name?>">
                    <div class="form-group mr-sm-2">
                        <label for="minprice" class="navbar-brand"><?= _FROM?></label>
                        <select class="form-control" id="minprice" name="minprice">
                            <option value="">---N/A---</option>
                            <option value="0">0</option>
                            <option value="50000">50.000</option>
                            <option value="200000">200.000</option>
                            <option value="300000">300.000</option>
                        </select>
                    </div>

                    <div class="form-group mr-sm-2">
                        <label for="maxprice" class="navbar-brand"><?= _TO?></label>
                        <select class="form-control" id="maxprice" name="maxprice">
                            <option value="">---N/A---</option>
                            <option value="50000">50.000</option>
                            <option value="100000">100.000</option>
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
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= _CATEGORY?></a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php foreach($categories as $category):?>
                                <a class="dropdown-item" href="category.php?category_id=<?php echo $category['category_id'];?>"><?php echo $category['name_category'];?></a>
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
                            <a class="dropdown-item" href="../../index.php"><?=_LOGIN ?></a>
                            <?php endif; ?>
                            <a class="dropdown-item" href="../../logout.php"><?=_LOGOUT ?></a>
                        </a>
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
                                        <img width="70" height="70" src="<?php echo '../../'. $image_cart['address'];?>">
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
                <form method='GET' action='' id='form_lang' >
                    <input type="hidden" name="category_id" value="<?= $category_id?>">
                    <input type="hidden" name="name" value="<?= $name?>">
                    <?=_SELECTLANGUAGES?>: <select name='lang' onchange='changeLang();' >
                    <option value='en' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en'){ echo "selected"; } ?> >English</option>
                    <option value='vi' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'vi'){ echo "selected"; } ?> >Vietnamese</option>
                    </select>
                </form>
            </div>
            <h3 class="text-center"><?= _CATEGORY?>: <?php echo $current_cate['name_category'] ?></h3>
            <div class="d-flex justify-content-center">
            <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php if($page - 1 == 0):?>
                            <li class="page-item disabled"><a class="page-link" href="category.php?category_id=<?php echo $category_id?>&minprice=<?php echo $minprice?>&maxprice=<?php echo $maxprice ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                        <?php else:?>
                            <li class="page-item"><a class="page-link" href="category.php?category_id=<?php echo $category_id?>&minprice=<?php echo $minprice?>&maxprice=<?php echo $maxprice ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                        <?php endif;?>
                        <li class="page-item active"><a class="page-link" href="category.php?category_id=<?php echo $category_id?>&minprice=<?php echo $minprice?>&maxprice=<?php echo $maxprice ?>&page=<?php echo $page?>"><?php echo $page ?></a></li>
                        <?php if($page +1 > $number_page):?>
                            <li class="page-item disabled"><a class="page-link" href="category.php?category_id=<?php echo $category_id?>&minprice=<?php echo $minprice?>&maxprice=<?php echo $maxprice ?>&page=<?php echo $page +1?>"><?=_NEXT?></a></li>
                        <?php else:?>
                            <li class="page-item"><a class="page-link" href="category.php?category_id=<?php echo $category_id?>&minprice=<?php echo $minprice?>&maxprice=<?php echo $maxprice ?>&page=<?php echo $page +1?>"><?=_NEXT?></a></li>
                        <?php endif;?>
                    </ul>
                </nav>
            </div>
            <div class="mt-4">
                <div class="row">
                    <?php if(empty($books)) {
                        echo '<h3>Không có sản phẩm nào trong thể loại này.</h3>';
                    } else { ?>
                    <?php foreach($books as $book):?> 
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-course-item">
                                    <?php 
                                        $stmt = $db->prepare('SELECT * FROM gallery_image WHERE book_id =? and isShow = 1');
                                        $stmt->bind_param('i', $book['book_id']);
                                        $stmt->execute();

                                        $image = $stmt->get_result()->fetch_assoc();
                                    ?>
                                <a href="detail_product.php?book_id=<?php echo $book['book_id']?>">
                                    <img class="card-img-top" width="150" height="200" src="<?php echo $image['address']?'../../'.$image['address']: 'https://tse4.mm.bing.net/th?id=OIP.ZiwfBrifIO4lV_Q-gIC7VQHaKx&pid=Api&P=0&h=180' ?>" alt="">
                                </a>
                                
                                <div class="card-body">
                                    <a href="detail_product.php?book_id=<?php echo $book['book_id']?>">
                                        <h5 class="card-title"><?= $book['title']?></h5>
                                    </a>
                                    <p class="card-text" ><?=_AUTHORS?>: <?= $book['authors']?></p>
                                    <?php if($book['sale'] && $book['sale'] != 0 && $book['sale'] != null): ?>
                                            <p class="text-success font-weight-bold"><del class="text-danger"><?php echo number_format($book['price'],2) ?></del> <?php echo number_format($book['price'] - $book['sale']*$book['price'] / 100,2)?></p>
                                        <?php else:?>
                                            <p class="font-weight-bold"><?php echo number_format($book['price'],2) ?></p>
                                        <?php endif;?>
                                    <!-- <form action="" method="POST"> -->
                                    <input type="hidden" name="book_id" value="<?= $book['book_id']?>">
                                    <input type="hidden" name="price" value="<?= $book['price']?>">
                                    <button type="submit" class ="btn btn-primary shadow-0 me-1 btn-add-to-cart" data-book-id="<?php echo $book['book_id']; ?>" name="add-to-cart" >
                                        <?=_ADDTOCART?>
                                    </button>
                                </div>
                        </div>
                    </div>
                    <?php endforeach;}?>
                </div>
                <!-- <?php 
                     for($page = 1; $page<= $number_page; $page++) {  
                        echo '<a href = "category.php?category_id='.$category_id.'&page=' . $page . '">' . $page . ' </a>';  
                        }  
                    ?> -->
            </div>
        </div>
    </div>
    
</body>
</html>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const productId = this.dataset.bookId;
                const quantity = 1;
                
                $.ajax({
                    url: '../../service/cart/add-to-cart.php',
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
            });
        });

    });
</script>
<?php

?>
