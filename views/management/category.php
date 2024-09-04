<?php
    session_start();

    $limit = 6;

    if(!isset($_GET['page'])){
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

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
        <?php include('views/management/partials/admin_header.php') ?>
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
                        <div class="col-md-6 d-flex justify-content-start">
                            <a href="product" class="btn btn-success"><?=_BACK?></a>
                        </div>

                        <div class="col-md-6 d-flex justify-content-end">
                            <a href="add/add_category.php" class="btn btn-info"><?=_ADDCATEGORY?></a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php if($page - 1 == 0):?>
                                        <li class="page-item disabled"><a class="page-link" href="category?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="category?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                                    <?php endif;?>
                                    <li class="page-item active"><a class="page-link" href="category?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page?>"><?php echo $page ?></a></li>
                                    <?php if($page +1 > $number_page):?>
                                        <li class="page-item disabled"><a class="page-link" href="category?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page +1?>"><?=_NEXT?></a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="category?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page +1?>"><?=_NEXT?></a></li>
                                    <?php endif;?>
                                </ul>
                            </nav>
                    </div>
                <div class="row">
                        <div class="col-md-6">
                            <form class="form-inline d-flex justify-content-start" method="GET" action="">
                                <input class="form-control mr-sm-2" type="search" placeholder="<?=_SEARCH?>" aria-label="Search" name="search_keyword">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?=_SEARCH?></button>
                            </form>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                                <form action="/category/addCategoryByFile" method="POST" enctype="multipart/form-data">
                                    <input type="file" class="text-center center-block file-upload" name="fileimport">
                                    <button class="btn btn-outline-success" type="submit" name="submit-import"><?=_MAKEIMPORT?></button>
                                </form>
                        </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"><?=_CATEGORYNAME?></th>
                                <th scope="col"><?=_QUANTITYBOOKS?></th>
                                <th scope="col"><?=_ACTION?></th>
                            </tr>
                        </thead>
                            <?php foreach($categories as $category):?> 
                                <tr>
                                    <th scope="row"><?= $index ?></th>
                                    <td><?= $category['name_category']?></td>
                                    <td><?= $category['total']?></td>
                                    
                                    <td>
                                        <a href="pageEditCategory?category_id=<?php echo $category['category_id']?>" class="btn btn-primary btn-sm"><?=_EDIT?></a>
                                        <a href="/category/deleteCategory?category_id=<?php echo $category['category_id']?>" class="btn btn-danger btn-sm"><?=_DELETE?></a>
                                        <a href="detailCategory?category_id=<?php echo $category['category_id']?>" class="btn btn-info btn-sm"><?=_DETAIL?></a>
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