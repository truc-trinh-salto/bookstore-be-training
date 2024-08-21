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

    $books_hot;
    $comments;

    $book_id = $_GET['book_id'];
    $stmt = $db->prepare('SELECT b.title, b.book_id, b.description, b.category_id, b.price, 
                                    b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category
                                    FROM books as b 
                                    LEFT JOIN categories as c 
                                    ON b.category_id = c.category_id
                                    WHERE b.book_id = ?
                                    ORDER BY b.book_id ASC');
    $stmt->bind_param('i', $book_id);
    $stmt->execute();

    $book = $stmt->get_result()->fetch_assoc();

    $stmt = $db->prepare('SELECT * FROM books
                                    WHERE category_id = ? and book_id != ? 
                                    ORDER BY RAND() LIMIT 5');
    $stmt->bind_param('ii', $book['category_id'],$book_id);
    $stmt->execute();

    $books_same_type = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $timestamp = strtotime(date('Y-m-d'));
    $dateFrom = date('Y-m-01 00:00:00', $timestamp);
    $dateTo  = date('Y-m-t 23:59:59', $timestamp);

    $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category, 
                                        tt.total
                                        FROM books as b 
                                        LEFT JOIN categories as c 
                                        ON b.category_id = c.category_id
                                        LEFT JOIN (SELECT SUM(od.quantity)as total, od.book_id
                                                    FROM order_detail as od 
                                                    LEFT JOIN order_item as oi
                                                    ON od.order_id = oi.id
                                                    LEFT JOIN transactions as t
                                                    on t.order_id = oi.id 
                                                    WHERE t.createdAt >= ? and t.createdAt <= ?
                                                    GROUP BY od.book_id) as tt
                                        ON tt.book_id = b.book_id
                                        WHERE b.book_id != ?
                                        ORDER BY total DESC LIMIT 5');
    $stmt->bind_param('ssi',$dateFrom, $dateTo, $book_id);
    $stmt->execute();

    $books_hot = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
        $_SESSION['qty_array'] = array();
    }

    $stmt = $db->prepare('SELECT * FROM categories');
    $stmt->execute();
    $categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmt = $db->prepare('SELECT c.comment_id, c.text, c.user_id, c.book_id, c.createdAt, c.parent_id, u.fullname, u.image 
                                    FROM comments as c 
                                    LEFT JOIN users as u 
                                    ON c.user_id = u.id
                                    WHERE c.book_id =? and parent_id IS NULL 
                                    ORDER BY createdAt DESC');
    $stmt->bind_param('i', $book_id);
    $stmt->execute();

    $result_count_cmt = $stmt->get_result();
    $count_cmt = $result_count_cmt->num_rows;
    $comments= $result_count_cmt->fetch_all(MYSQLI_ASSOC);

    $stmt = $db->prepare('SELECT * FROM rate WHERE book_id =?');
    $stmt->bind_param('i', $book_id);
    $stmt->execute();

    $result_count_rate = $stmt->get_result();
    $count_rate = $result_count_rate->num_rows;
    $rating = $result_count_rate->fetch_all(MYSQLI_ASSOC);


    $stmt = $db->prepare('SELECT * FROM rate WHERE book_id =? and user_id =?');
    $stmt->bind_param('ii', $book_id, $_SESSION['user_id']);
    $stmt->execute();

    $rate_of_user = $stmt->get_result()->fetch_assoc();
    $avg_rate = 0;

    if($count_rate > 0){
        foreach ($rating as $rate) {
            $avg_rate = $avg_rate + $rate['value'];
        }
        $avg_rate = (float)$avg_rate / (float)$count_rate;
    }

    $branchs;
        
    $stmt = $db->prepare('SELECT br.branch_id, br.title, br.address, br.hotline, br.image, brst.status FROM branch as br
                            LEFT JOIN branchstockitem as brst
                            ON br.branch_id = brst.branch_id
                            WHERE brst.book_id = ?');
    $stmt->bind_param('i', $book_id);
    $stmt->execute();
    $branchs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


    $index = 1;
    $total = 0;
    

?>

<!DOCTYPE html>
<html>
   <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Demo PHP MVC</title>
    <link rel="stylesheet" href="/vendor/open-iconic-master/font/css/open-iconic-bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
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
                                <a class="dropdown-item" href="../../index.php"><?=_LOGIN ?></a>
                                <?php endif; ?>
                                <a class="dropdown-item" href="../../logout.php"><?=_LOGOUT ?></a>
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
                                        <img width="70" height="70" src="<?php echo '../../'.$image_cart['address'];?>">
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
                            <input type='hidden' name='book_id' value=<?=$book_id?>>
							<?=_SELECTLANGUAGES?>: <select name='lang' onchange='changeLang();' >
							<option value='en' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en'){ echo "selected"; } ?> >English</option>
							<option value='vi' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'vi'){ echo "selected"; } ?> >Vietnamese</option>
							</select>
						</form>
					</li>
                    
                </ul>
            </div>
        </div>
    </nav>
        <div class="container">
            <div class="mt-4">
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
                <div class="row">
                    <div class="column_left col-md-3 col-xs-12">
                        <div class="sidewit">
                        <h3><span class="text-left"><?=_HOTITEM?></span></h3>
                        <ul class="side_prd_list list-group" style="list-style: none;">
                            <?php foreach($books_hot as $book_hoot):?>
                                    <li class="col-xs-12 item">
                                        <?php 
                                            $stmt = $db->prepare('SELECT * FROM gallery_image WHERE book_id =? and isShow = 1');
                                            $stmt->bind_param('i', $book_hoot['book_id']);
                                            $stmt->execute();

                                            $image_hot = $stmt->get_result()->fetch_assoc();
                                        ?>
                                        <a href="detail_product.php?book_id=<?php echo $book_hot['book_id'] ?>">
                                            <img width="70" height="70" src="<?php 
                                            if($image_hot['address']){
                                                echo '../../'.$image_hot['address'];
                                            }else {
                                                echo 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT3cD47c9xUZyKlO3j3z9vdBHV0P2BIwfkeWg&s';
                                            }?>
                                            " alt="<?php $book_hoot['book_id']?>">
                                        </a>
                                        <a href="detail_product.php?book_id=<?echo $book_hoot['book_id'] ?>">
                                            <?php echo $book_hoot['title']?>
                                        </a>
                                        <span></span>
                                        <div class="price" class="text-right">
                                            <?php if($book_hoot['sale'] && $book_hoot['sale'] != 0 && $book_hoot['sale'] != null): ?>
                                                <p class="text-success font-weight-bold"><del class="text-danger"><?php echo number_format($book_hoot['price'],2) ?></del> <?php echo number_format($book_hoot['price'] - $book_hoot['sale']*$book_hoot['price'] / 100,2)?></p>
                                            <?php else:?>
                                                <p class="font-weight-bold"><?php echo number_format($book_hoot['price'],2) ?></p>
                                            <?php endif;?>
                                        </div>
                                    </li>
                            <?php endforeach;?>
                        </ul>
                        </div>
                    </div>
                    <div class="column_right col-md-9 col-xs-12 row">
                        <div class="row col-md-7">
                            <ul class="side_prd_list d-flex flex-wrap justify-content-center col-md-12" style="list-style: none;">
                                <?php 
                                    $stmt = $db->prepare("SELECT * FROM gallery_image WHERE book_id=?");
                                    $stmt->bind_param("i", $book_id);
                                    $stmt->execute();
                                    $images = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                                ?>
                                <?php foreach($images as $image):?>
                                    <li class="col-md-3 col-6">
                                        <a href="" class="select-image">
                                            <img width="50" height="50" src="<?php echo '../../'.$image['address']?>" alt="<?php echo $image['image_id']?>">
                                        </a>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                            <a href="" class="col-md-12">
                                        <?php 
                                            $stmt = $db->prepare('SELECT * FROM gallery_image WHERE book_id =? and isShow = 1');
                                            $stmt->bind_param('i', $book['book_id']);
                                            $stmt->execute();

                                            $image_current = $stmt->get_result()->fetch_assoc();
                                        ?>
                                <img class="card-img-top" id="display-image" width="500" height="500" src="<?php echo $image_current['address']?'../../'.$image_current['address']:'https://tse4.mm.bing.net/th?id=OIP.ZiwfBrifIO4lV_Q-gIC7VQHaKx&pid=Api&P=0&h=180'?>" alt="">
                            </a>
                        </div>

                        <div class="card-course-item col-md-5" >
                                <div class="card-body">

                                    <a href="">
                                        <h5 class="card-title text-center"><?= $book['title']?> - <?php echo $book['authors'] ?></h5>
                                    </a>
                                    <p><?=_CATEGORY ?>: <?php echo $book['name_category']?></p>
                                    <p><?=_DESCRIPTION ?>: <?php echo $book['description'] ?></p>
                                    <input type="hidden" name="book_id" value="<?= $book['book_id']?>">
                                    <input type="hidden" name="price" value="<?= $book['price']?>">
                                    <?php if($book['sale'] && $book['sale'] != 0 && $book['sale'] != null): ?>
                                            <p class="text-success font-weight-bold"><del class="text-danger"><?php echo number_format($book['price'],2) ?></del> <?php echo number_format($book['price'] - $book['sale']*$book['price'] / 100,2)?></p>
                                    <?php else:?>
                                            <p class="font-weight-bold"><?php echo number_format($book['price'],2) ?></p>
                                    <?php endif;?>

                                    <div data-mdb-input-init class="form-outline">
                                        <label class="form-label" for="typeNumber"><?=_QUANTITY ?> :</label>
                                        <input type="number" id="typeNumber" class="form-control" min="1" value="1" name="quantity"/>
                                    </div>
                                    <button type="submit" class ="btn btn-primary shadow-0 me-1 btn-add-to-cart" data-book-id="<?php echo $book['book_id']; ?>" name="add-to-cart" >
                                        <?=_ADDTOCART ?>
                                    </button>
                                </div>
                        </div>
                            <div class="productdesc col-md-12 productdesc">
                                <div class="column" >
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"><?=_COMMENT ?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"><?=_RATING?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"><?=_SAMEITEM ?></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#tabs-4" role="tab"><?=_STATUS ?></a>
                                        </li>
                                    </ul><!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                            <form action="" method="POST">
                                                <div class="card-footer py-3 border-0">
                                                    <div class="d-flex flex-start w-100">
                                                        <img class="rounded-circle shadow-1-strong me-3" src="<?php echo '../../'.$_SESSION['image'] ?: 'http://ssl.gstatic.com/accounts/ui/avatar_2x.png'; ?>" alt="avatar" width="40" height="40">
                                                        <div data-mdb-input-init="" class="form-outline w-100" data-mdb-input-initialized="true">
                                                        <textarea class="form-control" id="textAreaExample" rows="4" name="text_comment"></textarea>
                                                        
                                                        <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 60px;"></div><div class="form-notch-trailing"></div></div></div>
                                                    </div>
                                                    <div class="float-end mt-2 pt-1">
                                                        <button type="comment" data-mdb-button-init="" data-mdb-ripple-init="" class="btn btn-primary btn-sm" data-mdb-button-initialized="true" name="comment"><?=_SAVE ?></button>
                                                    </div>
                                                </div>
                                            </form>
                                            <?php foreach($comments as $comment):?>
                                            <div class="comment-widgets mt-4">

                                                    <div class="d-flex flex-start comment-widgets mt-4">
                                                        <img class="rounded-circle shadow-1-strong me-3"
                                                            src="<?php echo $comment['image'] ?'../../'.$comment['image']: 'http://ssl.gstatic.com/accounts/ui/avatar_2x.png'; ?>" alt="avatar" width="50"
                                                            height="50" />
                                                        <div class="flex-grow-1 flex-shrink-1">
                                                            <div>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <h6 class="mb-1 font-medium">
                                                                <?php echo $comment['fullname'] ?> <span class="small">- <?php echo $comment['createdAt'] ?></span>
                                                                </h6>
                                                                <div class="comment-footer"> 
                                                                    <button type="button" data-reply-id="<?php echo $comment['comment_id'] ?>" class="btn btn-cyan btn-info btn-sm btn-reply"><?=_REPLY ?></button> 
                                                                    <!-- <button type="button" class="btn btn-success btn-sm">Publish</button> 
                                                                    <button type="button" class="btn btn-danger btn-sm">Delete</button> -->
                                                                </div>
                                                            </div>
                                                            <p class="small mb-0 font-medium">
                                                                <?php echo $comment['text']?>
                                                            </p>
                                                            </div>


                                                            <div class="flex-start mt-4" id="replyComment-<?php echo $comment['comment_id'] ?>" style="display: none;">
                                                                    <a class="me-3" href="#">
                                                                        <img class="rounded-circle shadow-1-strong"
                                                                        src="<?php $comment['image'] ?'../../'.$comment['image']: 'http://ssl.gstatic.com/accounts/ui/avatar_2x.png'; ?>" alt="avatar"
                                                                        width="50" height="50" />
                                                                    </a>
                                                                    <div class="flex-grow-1 flex-shrink-1">
                                                                        <form action="../../service/user/reply_comment.php" method="POST">
                                                                            <div class="card-footer py-3 border-0">
                                                                                <div class="d-flex flex-start w-100">
                                                                                    <input type="hidden" name="comment_id" value="<?= $comment['comment_id']?>">
                                                                                    <input type="hidden" name="book_id" value="<?= $book_id?>">
                                                                                    <div data-mdb-input-init="" class="form-outline w-100" data-mdb-input-initialized="true">
                                                                                    <textarea class="form-control" id="textAreaExample" rows="4" name="text_comment"></textarea>
                                                                                    <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 60px;"></div><div class="form-notch-trailing"></div></div></div>
                                                                                </div>
                                                                                <div class="float-end mt-2 pt-1">
                                                                                    <button type="comment" data-mdb-button-init="" data-mdb-ripple-init="" class="btn btn-primary btn-sm" data-mdb-button-initialized="true" name="comment"><?=_SAVE ?></button>
                                                                                    <button type="comment" data-mdb-button-init="" data-mdb-ripple-init="" class="btn btn-primary btn-sm btn-cancel" data-mdb-button-initialized="true" name="comment"><?=_CANCEL ?></button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                            </div>
                                                                

                                                        <?php
                                                            $stmt = $db->prepare('SELECT c.comment_id, c.text, c.user_id, c.book_id, c.createdAt, c.parent_id, u.fullname, u.image 
                                                                FROM comments as c 
                                                                LEFT JOIN users as u 
                                                                ON c.user_id = u.id
                                                                WHERE c.book_id =? and parent_id = ? 
                                                                ORDER BY createdAt DESC');
                                                            $stmt->bind_param('ii', $book_id, $comment['comment_id'],);
                                                            $stmt->execute();
                                                            $replies = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                                                        ?>
                                                        <?php foreach($replies as $reply):?>
                                                        <div class="d-flex flex-start mt-4">
                                                            <a class="me-3" href="#">
                                                            <img class="rounded-circle shadow-1-strong"
                                                                src="<?php echo $reply['image'] ?'../../'.$reply['image']: 'http://ssl.gstatic.com/accounts/ui/avatar_2x.png'; ?>" alt="avatar"
                                                                width="50" height="50" />
                                                            </a>
                                                            <div class="flex-grow-1 flex-shrink-1">
                                                                <div>
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <p class="mb-1">
                                                                        <?php echo $reply['fullname'] ?> <span class="small">- <?php echo $reply['createdAt'] ?></span>
                                                                        </p>
                                                                    </div>
                                                                    <p class="small mb-0">
                                                                        <?php echo $reply['text'] ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php endforeach;?>


                                                        </div>
                                                        </div>
                                            </div>
                                            <?php endforeach;?>
                                        </div>

                                        
                                        <div class="tab-pane" id="tabs-2" role="tabpanel">                               
                                            <div class="d-flex justify-content-center">
                                            
                                        
                                                <div class="content text-center">

                                                    <div class="ratings">
                                                        <span class="product-rating"><?php echo $avg_rate ?></span><span>/5</span>
                                                        <div class="container">
                                                            <form action="../../service/user/rating.php" method="POST">
                                                                <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                                                                    <input type="hidden" name="book_id_rate" value="<?= $_GET['book_id']?>">
                                                                    <?php for ($i = 5; $i >= 1; $i--): ?>
                                                                        <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" <?php if ($rate_of_user['value'] == $i) echo 'checked'; ?> />
                                                                        <label for="star<?= $i ?>" title="<?= $i ?> star"></label>
                                                                    <?php endfor; ?>
                                                                </div>
                                                                <div class="rating-text">
                                                                    <span><?php echo $count_rate ?> <?=_RATING ?> & <?php echo $count_cmt ?> <?=_COMMENT ?></span>
                                                                </div>
                                                                <button stlye="margin-top: 10px;" class="btn btn-lg btn-success" type="submit" name="submit"><i class="glyphicon glyphicon-ok-sign"></i><?=_SAVE ?></button>
                                                            </form>
                                            
                                                        </div>

                                                    </div>
                                                    
                                                </div>
                                        
                                            </div>

                                        </div>


                                        <div class="tab-pane" id="tabs-3" role="tabpanel">
                                            <div class="row mt-4">
                                            <?php foreach($books_same_type as $book_same_type):?>
                                                <?php if($book_same_type['category_id'] == $book['category_id']) {?>

                                                    <div class="col-md-2 col-lg-2">
                                                        <div class="card card-course-item">
                                                                    <?php 
                                                                        $stmt = $db->prepare('SELECT * FROM gallery_image WHERE book_id =? and isShow = 1');
                                                                        $stmt->bind_param('i', $book_same_type['book_id']);
                                                                        $stmt->execute();

                                                                        $image_same = $stmt->get_result()->fetch_assoc();
                                                                    ?>
                                                                <a href="">
                                                                    <img class="card-img-top" width="50" height="100" src="<?php echo $image_same['address']?'../../'.$image_same['address']:'https://tse4.mm.bing.net/th?id=OIP.ZiwfBrifIO4lV_Q-gIC7VQHaKx&pid=Api&P=0&h=180' ?>" alt="">
                                                                </a>
                                                                
                                                                <div class="card-body">
                                                                    <a href="detail_product.php?book_id=<?php echo $book_same_type['book_id'] ?>">
                                                                        <span class="card-title"><?= $book_same_type['title']?></span>
                                                                    </a>
                                                                    <p class="card-text" style="font-size:10px;" ><?=_AUTHORS ?>: <?= $book_same_type['authors']?></p>
                                                                        <?php if($book_same_type['sale'] && $book_same_type['sale'] != 0 && $book_same_type['sale'] != null): ?>
                                                                            <p class="text-success font-weight-bold"style="font-size:10px;" ><del class="text-danger"><?php echo number_format($book_same_type['price'],2) ?></del> <?php echo number_format($book_same_type['price'] - $book_same_type['sale']*$book_same_type['price'] / 100,2)?></p>
                                                                        <?php else:?>
                                                                            <p class="font-weight-bold" style="font-size:10px;"><?php echo number_format($book_same_type['price'],2) ?></p>
                                                                        <?php endif;?>

                                                                    <input type="hidden" name="book_id" value="<?= $book_same_type['book_id']?>">
                                                                    
                                                                    <?php if($book_same_type['sale'] != 0 && $book_same_type['sale'] != null): ?>
                                                                        <input type="hidden" name="price" value="<?php echo $book_same_type['price'] - $book_same_type['sale']*$book_same_type['price'] / 100?>">
                                                                    <?php else:?>
                                                                        <input type="hidden" name="price" value="<?php echo $book_same_type['price']?>">
                                                                    <?php endif;?>
                                                                    
                                                                </div>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                            <?php endforeach;?>
                                            <!-- </ul> -->
                                            </div>
                                        </div>



                                        <div class="tab-pane" id="tabs-4" role="tabpanel">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col"><?=_BRANCHNAME ?></th>
                                                        <th scope="col"><?=_BRANCHADDRESS ?></th>
                                                        <th scope="col"><?=_HOTLINE ?></th>
                                                        <th scope="col"><?=_DETAIL ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($branchs as $branch):?> 
                                                        <tr>
                                                            <th scope="row"><?= $index ?></th>
                                                            <td><?= $branch['title'] ?></td>
                                                            <td><?= $branch['address'] ?></td>
                                                            <td><?= $branch['hotline'] ?></td>
                                                            <td>
                                                                <?php if($branch['status'] == 1): ?>
                                                                    <p class="btn btn-success btn-sm"><?=_INSTOCK ?></p>
                                                                <?php else: ?>
                                                                    <p class="btn btn-danger btn-sm"><?=_OUTSTOCK ?></p>
                                                                <?php endif; ?>
                                                            </td>
                                                            
                                                            <?php $index ++?>
                                                        </tr>   
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
                                        </div>



                                    </div>
                                </div>
                            </div>
                    </div>
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
                const quantity = document.querySelector(`input[name="quantity"]`).value;
                
                $.ajax({
                    url: '../../service/cart/add_to_cart.php',
                    method: 'POST',
                    data: {book_id: productId, quantity: quantity},
                    success: function (response) {
                        $('.display-cart').remove();
                        $('.display-count-cart').remove();
                        $('#show_cart').append(response);
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });
        });

        
    });


    const changeImage = document.querySelectorAll('.select-image');
    changeImage.forEach(image => {
                image.addEventListener('click', function (event) {
                    event.preventDefault();
                    const imageAddress = this.querySelector('img').src;
                    var image = new Image();
                    image.onload = function () {
                        document.getElementById('display-image').setAttribute('src', image.src);
                    };
                    image.src = imageAddress;
                      
                });
        });


    
    const replyComment = document.querySelectorAll('.btn-cyan');

    replyComment.forEach(comment => {
        comment.addEventListener('click', function () {
            event.preventDefault();
            var replyId = this.dataset.replyId;
            var editForm = document.getElementById('replyComment-' + replyId);
            editForm.style.display = "block";
        });
    });

    const cancelReply = document.querySelectorAll('.btn-cancel');

    cancelReply.forEach(comment => {
        comment.addEventListener('click', function () {
            event.preventDefault();
            var replyId = this.dataset.replyId;
            var editForm = document.getElementById('replyComment-' + replyId);
            editForm.style.display = "none";
        });
    });
    </script>
<?php
    if(!$_SESSION['user_id'] && isset($_POST['comment'])){
            header('Location: ../../index.php');
            exit();
    } else if(isset($_POST['comment']) && isset($_POST['text_comment']) &&!empty($_POST['text_comment'])){
        $book_id = $_GET['book_id'];
        $user_id = $_SESSION['user_id'];
        $text_comment = $_POST['text_comment'];

        $stmt = $db->prepare('INSERT INTO comments (book_id, user_id, text, createdAt) VALUES (?,?,?,NOW())');
        $stmt->bind_param('iis', $book_id, $user_id, $text_comment);
        $stmt->execute();

        if($stmt->affected_rows > 0)
        {
            header('Location: detail_product.php?book_id='. $book_id);
            $_SESSION['message'] = 'Comment added successfully';
        } else {
            echo 'Error adding comment';
            $_SESSION['message'] = 'Comment added unsuccessfully';
        }
    }
?>
