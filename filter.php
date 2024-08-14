<?php
    require_once('database.php');
    // error_reporting(1);
    $db = DBConfig::getDB();

    session_start();
    $books;

    $keyword = $_GET['search_keyword'];
    $search = "%$keyword%";


    if(isset($_GET['minprice']) && isset($_GET['maxprice'])) {
        $minprice = $_GET['minprice'];
        $maxprice = $_GET['maxprice'];
        if ($minprice == null && $maxprice == null) {
            $stmt = $db->prepare('SELECT * FROM books WHERE title LIKE ? OR authors LIKE ? OR description LIKE ?');
            $stmt->bind_param("sss", $search, $search, $search);
        } else if($minprice == null) {
            $stmt = $db->prepare('SELECT * FROM books 
                                    WHERE (title LIKE ? OR authors LIKE ? OR description LIKE ?)
                                    AND price <= ?');
            $stmt->bind_param('sssd', $search, $search, $search,$maxprice);
        } else if ($maxprice == null) {
            $stmt = $db->prepare('SELECT * FROM books WHERE (title LIKE ? OR authors LIKE ? OR description LIKE ?) AND price >=?');
            $stmt->bind_param('sssd', $search, $search, $search, $minprice);
        } else {
            $stmt = $db->prepare('SELECT * FROM books
                                    WHERE (title LIKE ? OR authors LIKE ? OR description LIKE ?)
                                    AND price >=? AND price <=?');
            $stmt->bind_param('sssdd', $search, $search, $search,$minprice, $maxprice); 
        }
    } else {
        $stmt = $db->prepare("SELECT * FROM books where title LIKE ? OR authors LIKE ? OR description LIKE ? ");
        $stmt->bind_param("sss", $search, $search , $search);
    }

    $limit = 6;

    $stmt->execute();

    $number_result  = $stmt->get_result()->num_rows;

    $number_page = ceil($number_result/ $limit);
    
    if(!isset($_GET['page'])){
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    $page_first = ($page - 1) * $limit;

    if(isset($_GET['minprice']) && isset($_GET['maxprice'])) {
        $minprice = $_GET['minprice'];
        $maxprice = $_GET['maxprice'];
        if ($minprice == null && $maxprice == null) {
            $stmt = $db->prepare('SELECT * FROM books WHERE title LIKE ? OR authors LIKE ? OR description LIKE ? LIMIT ?,?');
            $stmt->bind_param("sssii", $search, $search, $search, $page_first, $limit);
        } else if($minprice == null) {
            $stmt = $db->prepare('SELECT * FROM books 
                                    WHERE (title LIKE ? OR authors LIKE ? OR description LIKE ?)
                                    AND price <= ? LIMIT ?,?');
            $stmt->bind_param('sssdii', $search, $search, $search,$maxprice, $page_first, $limit);
        } else if ($maxprice == null) {
            $stmt = $db->prepare('SELECT * FROM books WHERE (title LIKE ? OR authors LIKE ? OR description LIKE ?) AND price >=? LIMIT ?,?');
            $stmt->bind_param('sssdii', $search, $search, $search, $minprice, $page_first, $limit);
        } else {
            $stmt = $db->prepare('SELECT * FROM books
                                    WHERE (title LIKE ? OR authors LIKE ? OR description LIKE ?)
                                    AND price >=? AND price <=? LIMIT ?,?');
            $stmt->bind_param('sssddii', $search, $search, $search,$minprice, $maxprice, $page_first, $limit);  
        }
    } else {
        $stmt = $db->prepare("SELECT * FROM books where title LIKE ? OR authors LIKE ? OR description LIKE ? LIMIT ?,?");
        $stmt->bind_param("sssii", $search, $search , $search, $page_first, $limit);
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
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Tìm kiếm</button>
            </form>
            <form action="" class="form-inline nav-item" method="GET" action="">
                    <input type="hidden" name="search_keyword" value="<?= $keyword?>">
                    <div class="form-group mr-sm-2">
                        <label for="minprice" class="navbar-brand">Từ</label>
                        <select class="form-control" id="minprice" name="minprice">
                            <option value="">---N/A---</option>
                            <option value="0">0</option>
                            <option value="50000">50.000</option>
                            <option value="200000">200.000</option>
                            <option value="300000">300.000</option>
                        </select>
                    </div>

                    <div class="form-group mr-sm-2">
                        <label for="maxprice" class="navbar-brand">Đến</label>
                        <select class="form-control" id="maxprice" name="maxprice">
                            <option value="">---N/A---</option>
                            <option value="500000">50.000</option>
                            <option value="200000">200.000</option>
                            <option value="300000">500.000</option>
                            <option value="500000">1.000.000</option>  
                        </select>
                    </div>
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filter</button>
            </form>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Thể loại</a>
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
                                    echo 'Tài khoản';
                                }
                            ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php if($_SESSION['user_id']): ?>
                            <a class="dropdown-item" href="history.php">Lịch sử mua hàng</a>
                            <a class="dropdown-item" href="profile.php">Thông tin cá nhân</a>
                            <?php else:?>
                            <a class="dropdown-item" href="index.php">Đăng nhập</a>
                            <?php endif; ?>
                            <a class="dropdown-item" href="logout.php">Đăng xuất
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
                    
                </ul>
            </div>
        </div>
    </nav>
        <div class="container">
            <h3 class="text-center">Tìm kiếm với từ khoá: <?php echo $_GET['search_keyword'] ?></h3>
            <div class="mt-4">
            <div class="d-flex justify-content-center">
            <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php if($page - 1 == 0):?>
                            <li class="page-item disabled"><a class="page-link" href="filter.php?search_keyword=<?php echo $keyword?>&minprice=<?php echo $minprice?>&maxprice=<?php echo $maxprice?>&page=<?php echo $page -1?>">Previous</a></li>
                        <?php else:?>
                            <li class="page-item"><a class="page-link" href="filter.php?search_keyword=<?php echo $keyword?>&minprice=<?php echo $minprice?>&maxprice=<?php echo $maxprice?>&page=<?php echo $page -1?>">Previous</a></li>
                        <?php endif;?>
                        <li class="page-item active"><a class="page-link" href="filter.php?search_keyword=<?php echo $keyword?>&minprice=<?php echo $minprice?>&maxprice=<?php echo $maxprice?>&page=<?php echo $page?>"><?php echo $page ?></a></li>
                        <?php if($page +1 > $number_page):?>
                            <li class="page-item disabled"><a class="page-link" href="filter.php?search_keyword=<?php echo $keyword?>&minprice=<?php echo $minprice?>&maxprice=<?php echo $maxprice?>&page=<?php echo $page +1?>">Next</a></li>
                        <?php else:?>
                            <li class="page-item"><a class="page-link" href="filter.php?search_keyword=<?php echo $keyword?>&minprice=<?php echo $minprice?>&maxprice=<?php echo $maxprice?>&page=<?php echo $page +1?>">Next</a></li>
                        <?php endif;?>
                    </ul>
                </nav>
            </div>
                <div class="row">
                    <?php if(empty($books)) {
                        echo '<h3>Không có sản phẩm nào có từ khoá này.</h3>';
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
                                <a href="detail_product.php?book_id<?php echo $book['book_id']?>">
                                    <img class="card-img-top" width="150" height="200" src="<?php echo $image['address']?: 'https://tse4.mm.bing.net/th?id=OIP.ZiwfBrifIO4lV_Q-gIC7VQHaKx&pid=Api&P=0&h=180'?>" alt="">
                                </a>
                                
                                <div class="card-body">
                                    <a href="detail_product.php?book_id<?php echo $book['book_id']?>">
                                        <h5 class="card-title"><?= $book['title']?></h5>
                                    </a>
                                    <p class="card-text" >Tác giả: <?= $book['authors']?></p>
                                        <?php if($book['sale'] && $book['sale'] != 0 && $book['sale'] != null): ?>
                                            <p class="text-success font-weight-bold"><del class="text-danger"><?php echo number_format($book['price'],2) ?></del> <?php echo number_format($book['price'] - $book['sale']*$book['price'] / 100,2)?></p>
                                        <?php else:?>
                                            <p class="font-weight-bold"><?php echo number_format($book['price'],2) ?></p>
                                        <?php endif;?>
  
                                    <input type="hidden" name="book_id" value="<?= $book['book_id']?>">
                                    <input type="hidden" name="price" value="<?= $book['price']?>">
                                    <button type="submit" class ="btn btn-primary shadow-0 me-1 btn-add-to-cart" data-book-id="<?php echo $book['book_id']; ?>" name="add-to-cart" >
                                        Thêm vào giỏ hàng
                                    </button>
                                </div>
                        </div>
                    </div>
                    <?php endforeach;}?>
                </div>
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
            });
        });

    });
</script>
<?php

?> 
