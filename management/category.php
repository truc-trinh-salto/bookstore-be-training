<?php
    session_start();
    require_once('../database.php');
    $db = DBConfig::getDB();
    $categories;

    $limit = 6;

    $stmt = $db->prepare('SELECT * FROM categories');
    $stmt->execute();

    $number_result = $stmt->get_result()->num_rows;
    $number_page = ceil($number_result / $limit);

    if(!isset($_GET['page'])){
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    $page_first = ($page - 1) * $limit;




    $stmt = $db->prepare('SELECT * FROM categories LIMIT ?,?');
    $stmt->bind_param("ii", $page_first, $limit);
    $stmt->execute();
    $categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $index = 1;
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
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên thể loại</th>
                                <th scope="col">Số lượng sách</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                            <?php foreach($categories as $category):?> 
                                <tr>
                                    <th scope="row"><?= $index ?></th>
                                    <td><?= $category['name_category']?></td>
                                    <td><?php 
                                            $stmt = $db->prepare('SELECT COUNT(*) as total FROM books WHERE category_id = ?');
                                            $stmt->bind_param("i", $category['category_id']);
                                            $stmt->execute();
                                            
                                            $total = $stmt->get_result()->fetch_assoc();
                                            
                                            echo $total['total'];
                                            ?></td>
                                    
                                    <td>
                                        <a href="edit_category.php?category_id=<?php echo $category['category_id']?>" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                                        <a href="delete_category.php?category_id=<?php echo $category['category_id']?>" class="btn btn-danger btn-sm">Xoá</a>
                                        <a href="product_category.php?category_id=<?php echo $category['category_id']?>" class="btn btn-info btn-sm">Chi tiết</a>
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