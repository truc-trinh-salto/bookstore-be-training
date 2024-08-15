<?php
    session_start();
    require_once('../database.php');
    $db = DBConfig::getDB();
    $books;

    $limit = 6;
    
    if(isset($_GET['search_keyword']) && $_GET['search_keyword'] != null){
        $search_keyword = $_GET['search_keyword'];
        $search = "%$search_keyword%";
        $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                    b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category
                                    FROM books as b 
                                    LEFT JOIN categories as c 
                                    ON b.category_id = c.category_id
                                    WHERE b.title LIKE ? OR b.authors LIKE ? OR b.description LIKE ? OR c.name_category LIKE ?
                                    ORDER BY b.book_id ASC');
        $stmt->bind_param("ssss",$search, $search, $search, $search);
    } else {
        $stmt = $db->prepare("SELECT * FROM books");
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


    if(isset($_GET['search_keyword'])) {
        $search_keyword = $_GET['search_keyword'];
        $search = "%$search_keyword%";
        $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                    b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category
                                    FROM books as b 
                                    LEFT JOIN categories as c 
                                    ON b.category_id = c.category_id
                                    WHERE b.title LIKE ? OR b.authors LIKE ? OR b.description LIKE ? OR c.name_category LIKE ?
                                    ORDER BY b.book_id DESC LIMIT ?,?');
        $stmt->bind_param("ssssii",$search, $search, $search, $search,$page_first,$limit);
        
    } else {
        $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                    b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category
                                    FROM books as b 
                                    LEFT JOIN categories as c 
                                    ON b.category_id = c.category_id
                                    ORDER BY b.book_id DESC LIMIT ?,?');
        $stmt->bind_param('ii',$page_first,$limit);
    }
    $stmt->execute();
    $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


    $index = $page * $limit - $limit + 1;
    $total = 0;
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
            <div class="row mt-2">
                <div class="col-md-3 d-flex justify-content-start">
                    <a href="hot_item.php" class="btn btn-info">Bán chạy</a>
                </div>
                <div class="col-md-3 d-flex justify-content-start">
                    <a href="inventory.php" class="btn btn-info">Nhập hàng</a>
                </div>
                <div class="col-md-3 d-flex justify-content-end">
                    <a href="add_product.php" class="btn btn-info">Thêm sản phẩm mới</a>
                </div>
                <div class="col-md-3 d-flex justify-content-end">
                    <a href="category.php" class="btn btn-info">Thể loại</a>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php if($page - 1 == 0):?>
                                        <li class="page-item disabled"><a class="page-link" href="product.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page -1?>">Previous</a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="product.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page -1?>">Previous</a></li>
                                    <?php endif;?>
                                    <li class="page-item active"><a class="page-link" href="product.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page?>"><?php echo $page ?></a></li>
                                    <?php if($page +1 > $number_page):?>
                                        <li class="page-item disabled"><a class="page-link" href="product.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page +1?>">Next</a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="product.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page +1?>">Next</a></li>
                                    <?php endif;?>
                                </ul>
                            </nav>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <form class="form-inline d-flex justify-content-start" method="GET" action="">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search_keyword">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Tìm kiếm</button>
                            </form>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                                <form action="add_update_multi_product.php" method="POST" enctype="multipart/form-data">
                                    <input type="file" class="text-center center-block file-upload" name="fileimport">
                                    <button class="btn btn-outline-success" type="submit" name="submit-import">Thực hiện nhập file</button>
                                </form>
                        </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Tên sách</th>
                                <th scope="col">Tác giả</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Thể loại</th>
                                <th scope="col">Giá Tiền</th>
                                <th scope="col">Hiển thị trang thủ</th>
                                <th scope="col" class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                            <?php foreach($books as $book):?> 
                                <tr>
                                    <th scope="row"><?= $index ?></th>
                                    <td>
                                        <?php 
                                            $stmt = $db->prepare('SELECT * FROM gallery_image WHERE book_id =? and isShow = 1');
                                            $stmt->bind_param('i', $book['book_id']);
                                            $stmt->execute();

                                            $image = $stmt->get_result()->fetch_assoc();
                                        ?>
                                        <img width="100" height="100" src="
                                        <?php 
                                        if($image['address']){
                                            echo '../'.$image['address'];
                                        }else {
                                            echo 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT3cD47c9xUZyKlO3j3z9vdBHV0P2BIwfkeWg&s';
                                        }?>
                                        " alt="<?php $book['book_id']?>">
                                    </td>
                                    <td><?= $book['title'] ?></td>
                                    <td><?= $book['authors']?></td>
                                    <td><?php echo number_format($book['stock'],0)?></td>
                                    <td><?= $book['name_category']?></td>
                                    <td>
                                        <?php if($book['sale']): ?>
                                            <div class="row">
                                                <del class="col-md-12"><?php echo number_format($book['price'],2) ?></del>
                                                <span class="col-md-12 text-danger">-<?php echo $book['sale'] ?>%</span>
                                                <span class="col-md-12 text-success"><?php echo number_format($book['price'] - $book['sale']*$book['price'] / 100,2)?></span>
                                            </div>
                                        <?php else:?>
                                            <span><?php echo number_format($book['price'],2) ?></span>
                                        <?php endif;?>
                                    </td>
                                    <td><?php
                                            if($book['hotItem'] == 1){
                                                echo 'Có';
                                            } else {
                                                echo 'Không';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <a href="edit_product.php?book_id=<?php echo $book['book_id']?>" class="btn btn-primary btn-sm col-md-6">Chỉnh sửa</a>
                                            <a href="delete_product.php?book_id=<?php echo $book['book_id']?>" class="btn btn-danger btn-sm col-md-6">Xoá</a>
                                            <a href="gallery_image.php?book_id=<?php echo $book['book_id']?>" class="btn btn-info btn-sm col-md-12 mt-2">Mục hình ảnh</a>


                                        </div>
                                        <!-- <a href="edit_product.php?book_id=<?php echo $book['book_id']?>" class="btn btn-primary btn-sm col-xs-12">Chỉnh sửa</a>
                                        <a href="delete_product.php?book_id=<?php echo $book['book_id']?>" class="btn btn-danger btn-sm">Xoá</a>
                                        <a href="delete_product.php?book_id=<?php echo $book['book_id']?>" class="btn btn-info btn-sm">Mục hình ảnh</a> -->
                                    </td>
                                    
                                <?php $index ++?>
                                </tr>   
                            <?php endforeach;?>
                        </tbody>
                        </table>
                </>
            </div>
        </div>
    </div>
    
</body>
</html>