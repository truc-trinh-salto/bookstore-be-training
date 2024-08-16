<?php
        session_start();
        require_once('../database.php');
        $db = DBConfig::getDB();
        $books;
        $date = $_GET['date_select'];
        if($date != null){
            $timestamp = strtotime($date);
        } else {
            $timestamp = strtotime(date('Y-m-d'));
        }
        $dateFrom = date('Y-m-01 00:00:00', $timestamp);
        $dateTo  = date('Y-m-t 23:59:59', $timestamp);



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
                                        ORDER BY b.book_id DESC');
            $stmt->bind_param("ssss",$search, $search, $search, $search);
        } else {
            $stmt = $db->prepare('SELECT * FROM books');
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


        if(isset($_GET['search_keyword']) && $_GET['search_keyword'] != null) {
            $search_keyword = $_GET['search_keyword'];
            $search = "%$search_keyword%";
            $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category, 
                                        tt.total, s.after_stock
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

                                        LEFT JOIN (SELECT ii.book_id, ii.after_stock as after_stock
                                                    FROM import_item as ii
                                                    LEFT JOIN import as i
                                                    ON i.id = ii.import_id
                                                    WHERE YEAR(i.import) = YEAR(?) and MONTH(i.import) = MONTH(?)) as s
                                        ON s.book_id = b.book_id

                                        WHERE b.title LIKE ? OR b.authors LIKE ? OR b.description LIKE ? OR c.name_category LIKE ?
                                        ORDER BY total DESC LIMIT ?,?');
            $stmt->bind_param("ssssssssii",$dateFrom,$dateTo,$dateFrom,$dateFrom,$search, $search, $search, $search, $page_first,$limit);
            
        } else {
            $stmt = $db->prepare('SELECT b.title,b.image, b.book_id, b.description, b.category_id, b.price, 
                                        b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category, 
                                        tt.total, s.after_stock
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

                                        LEFT JOIN (SELECT ii.book_id, ii.after_stock as after_stock
                                                    FROM import_item as ii
                                                    LEFT JOIN import as i
                                                    ON i.id = ii.import_id
                                                    WHERE YEAR(i.import) = YEAR(?) and MONTH(i.import) = MONTH(?)) as s
                                        ON s.book_id = b.book_id
                                        ORDER BY total DESC LIMIT ?,?');
            $stmt->bind_param('ssssii',$dateFrom,$dateTo,$dateFrom,$dateFrom,$page_first,$limit);
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
                <div class="row justify-content-center">
                    <form class="form-inline nav-item col-md-6" method="GET" action="">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search_keyword" value="<?php echo $search_keyword?>">
                            <input class="form-control mr-sm-2" type="month" placeholder="Search" aria-label="Search" name="date_select" value="<?php echo $date?>">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Tìm kiếm</button>
                    </form>
                    <form class="form-inline nav-item col-md-6 justify-content-center" method="GET" action="export.php">
                            <input class="form-control mr-sm-2" type="hidden" name="date_select" value="<?php echo $date?>">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Xuất file</button>
                    </form>
                </div>
                <div class="d-flex justify-content-center">
                            <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php if($page - 1 == 0):?>
                                            <li class="page-item disabled"><a class="page-link" href="hot_item.php?search_keyword=<?php echo $search_keyword ?>&date_select=<?php echo $date ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                                        <?php else:?>
                                            <li class="page-item"><a class="page-link" href="hot_item.php?search_keyword=<?php echo $search_keyword ?>&date_select=<?php echo $date ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                                        <?php endif;?>
                                        <li class="page-item active"><a class="page-link" href="hot_item.php?search_keyword=<?php echo $search_keyword ?>&date_select=<?php echo $date ?>&page=<?php echo $page?>"><?php echo $page ?></a></li>
                                        <?php if($page +1 > $number_page):?>
                                            <li class="page-item disabled"><a class="page-link" href="hot_item.php?search_keyword=<?php echo $search_keyword ?>&date_select=<?php echo $date ?>&page=<?php echo $page +1?>">Next</a></li>
                                        <?php else:?>
                                            <li class="page-item"><a class="page-link" href="hot_item.php?search_keyword=<?php echo $search_keyword ?>&date_select=<?php echo $date ?>&page=<?php echo $page +1?>">Next</a></li>
                                        <?php endif;?>
                                    </ul>
                                </nav>
                        </div>
                    <div class="row">
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
                                    <th scope="col">Số lượng đã bán</th>
                                    <th scope="col">Số lượng lúc đầu</th>
                                    <th scope="col">Số lượng còn lại</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                                <?php foreach($books as $book):?> 
                                    <tr>
                                        <th scope="row"><?= $index ?></th>
                                        <td>
                                            <img width="100" height="100" src="
                                            <?php 
                                            if($book['image']){
                                                echo $book['image'];
                                            }else {
                                                echo 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT3cD47c9xUZyKlO3j3z9vdBHV0P2BIwfkeWg&s';
                                            }?>
                                            " alt="<?php $book['book_id']?>">
                                        </td>
                                        <td><?= $book['title'] ?></td>
                                        <td><?= $book['authors']?></td>
                                        <td><?php echo number_format($book['stock'],0)?></td>
                                        <td><?= $book['name_category']?></td>
                                        <td><?php if($book['sale']): ?>
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
                                            <p class="text-danger font-weight-bold">
                                                <?php echo $book['total']?: 0 ?>
                                            </p>
                                        </td>
                                        <td class="text-info font-weight-bold"><?php echo $book['stock']?></td>
                                        <td class="text-success font-weight-bold"><?php echo $book['after_stock']?></td>
                                        <td>
                                            <a href="edit_product.php?book_id=<?php echo $book['book_id']?>" class="btn btn-primary btn-sm">Chỉnh sửa</a>
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
        
    </body>
    </html>