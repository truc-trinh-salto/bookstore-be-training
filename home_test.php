<?php
    require_once('database.php');
    $db = DBConfig::getDB();
    session_start();

    $last_category;



    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
        $_SESSION['qty_array'] = array();
    }

    $stmt = $db->prepare('SELECT * FROM categories limit 1');
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
            <form action="filter.php" class="form-inline nav-item" method="GET">
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
                                    echo 'Tài khoản';
                                }
                            ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php if($_SESSION['user_id']): ?>
                            <a class="dropdown-item" href="history.php">Lịch sử mua hàng</a>
                            <a class="dropdown-item" href="profile.php">Thông tin cá nhân</a>
                            <a class="dropdown-item" href="codesale.php">Mã khuyến mãi</a>
                            <a class="dropdown-item" href="store_system.php">Hệ thống</a>
                            <?php else:?>
                            <a class="dropdown-item" href="index.php">Đăng nhập</a>
                            <?php endif; ?>
                            <a class="dropdown-item" href="logout.php">Đăng xuất</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class ="nav-link"href="view_cart.php"><span class="badge"><?php echo count($_SESSION['cart']); ?></span> Cart <span class="glyphicon glyphicon-shopping-cart"></span></a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>
        <div class="container">
            <div class="mt-4" id="categoryList">
                <?php 
                if(isset($_SESSION['message'])){
                    ?>
                    <div class="alert alert-info text-center">
                        <?php echo $_SESSION['message']; ?>
                    </div>
                    <?php
                    unset($_SESSION['message']);
                }?>
                <?php foreach($categories as $category): ?>
                <?php 
                    $stmt = $db->prepare('SELECT count(*) as total FROM books WHERE category_id =?');
                    $stmt->bind_param('i', $category['category_id']);
                    $stmt->execute();

                    $total =$stmt->get_result()->fetch_assoc();
                    $last_category = $category['category_id'];
                    ?>
                <div style="height:50px; width:50px;"></div>
                <h3><?php echo $category['name_category'] ?> (<?php echo $total['total'] ?>)</h3>

                <div class="row mt-4">
                    <?php 
                        $stmt = $db->prepare('SELECT * FROM books WHERE category_id =?');
                        $stmt->bind_param('i', $category['category_id']);
                        $stmt->execute();

                        $books=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                    ?>
                    <?php foreach($books as $book):?> 
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-course-item">
                                <a href="">
                                    <img class="card-img-top" width="150" height="200" src="<?php echo $book['image']?:'https://tse4.mm.bing.net/th?id=OIP.ZiwfBrifIO4lV_Q-gIC7VQHaKx&pid=Api&P=0&h=180' ?>" alt="">
                                </a>
                                
                                <div class="card-body">
                                    <a href="detail_product.php?book_id=<?php echo $book['book_id'] ?>">
                                        <h5 class="card-title"><?= $book['title']?></h5>
                                    </a>
                                    <p class="card-text" >Tác giả: <?= $book['authors']?></p>
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
                                        Thêm vào giỏ hàng
                                    </button>
                                    
                                </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
                <?php endforeach; ?>
                <div class="load-more" lastID="<?php echo $last_category ?>" style="display: none;">
                        <span>Loading...</span>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript">

    $(document).ready(function(){
        let isLoading = false;
            $(window).on("scroll", function(e){
                if(isLoading) return;
                var lastID = $('.load-more').attr('lastID');
                var distance = $(document).height() - $(window).height();
                if((distance - $(window).scrollTop() < 1) && (lastID != 0)){
                    isLoading = true;
                    alert(document.documentElement.clientHeight - window.innerHeight);
                    alert($(window).height() - $(document).height());
                    $.ajax({
                        type:'POST',
                        url:'getData.php',
                        data:'id='+lastID,
                        beforeSend:function(){
                            $('.load-more').show();
                        },
                        success:function(html){
                            $('.load-more').remove();
                            // setTimeout(function(){
                            //     $('#categoryList').append(html);
                            // }, 1000);
                            $('#categoryList').append(html);
                            // $('#categoryList').append(html);
                            isLoading = false;
                        }
                    });
                }
            });
        });


    document.addEventListener('DOMContentLoaded', function () {
        const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const productId = this.dataset.bookId;
                $.ajax({
                    url: 'add_to_cart.php',
                    method: 'POST',
                    data: {book_id: productId,},
                    success: function (response) {
                        const cartCount = JSON.parse(response).count;
                        document.querySelector('.badge').textContent = cartCount;
                        // alert(JSON.parse(response).message);
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
