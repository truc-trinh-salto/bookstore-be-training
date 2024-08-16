<?php
    session_start();
    require_once('../database.php');
    $db = DBConfig::getDB();
    $imports;

    $limit = 6;
    
    if(isset($_GET['search_keyword']) && $_GET['search_keyword'] != null){
        $search_keyword = $_GET['search_keyword'];
        $search = "%$search_keyword%";
        $stmt = $db->prepare('SELECT * from import WHERE title LIKE ? ORDER BY id ASC');
        $stmt->bind_param("s",$search);
    } else {
        $stmt = $db->prepare("SELECT * FROM import ORDER BY id ASC");
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
        $stmt = $db->prepare('SELECT * from import WHERE title LIKE ? ORDER BY id ASC LIMIT?,?');
        $stmt->bind_param("sii",$search,$page_first,$limit);
        
    } else {
        $stmt = $db->prepare("SELECT * FROM import ORDER BY id ASC LIMIT?,?");
        $stmt->bind_param('ii',$page_first,$limit);
    }
    $stmt->execute();
    $imports = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


    $index = $page * $limit - $limit + 1;
    $total = 0;

    if(isset($_SESSION['import_item'])){
        unset($_SESSION['import_item']);
        unset($_SESSION['qty_array_import']);
    }

    $_SESSION['import_item'] = array();
    $_SESSION['qty_array_import'] = array();

    


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
                <!-- <div class="row mt-2">
                        <div class="col-md-12 d-flex justify-content-start">
                            <a href="product.php" class="btn btn-success">Quay lại</a>
                        </div>
                </div> -->
            <div class="row">
                <div class="col-md-6 d-flex justify-content-start">
                            <a href="product.php" class="btn btn-success"><?=_BACK?></a>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <a class="btn btn-info" href="import.php"><?=_ADDIMPORT?></a>
                </div>
            </div>
            
            <div class="d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php if($page - 1 == 0):?>
                                        <li class="page-item disabled"><a class="page-link" href="product.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="product.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                                    <?php endif;?>
                                    <li class="page-item active"><a class="page-link" href="product.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page?>"><?php echo $page ?></a></li>
                                    <?php if($page +1 > $number_page):?>
                                        <li class="page-item disabled"><a class="page-link" href="product.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page +1?>"><?=_NEXT?></a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="product.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page +1?>"><?=_NEXT?></a></li>
                                    <?php endif;?>
                                </ul>
                            </nav>
                    </div>
                <div class="row">
                <div class="col-md-12">
                    <form class="form-inline nav-item" method="GET" action="">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search_keyword">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Tìm kiếm</button>
                    </form>
                </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"><?=_TITLE?></th>
                                <th scope="col"><?=_DATEIMPORT?></th>
                                <th scope="col"><?=_TOTALQUANTITY?></th>
                                <th scope="col"><?=_STATUS?></th>
                                <th scope="col"><?=_ACTION?></th>
                            </tr>
                        </thead>
                            <?php foreach($imports as $import):?>
                                <tr>
                                    <th scope="row"><?= $index ?></th>
                                    <td><?= $import['title'] ?></td>
                                    <td><?= $import['import']?></td>
                                    <td><?php echo number_format($import['quantity'],0)?></td>
                                    <td>
                                        <?php 
                                            if($import['status'] == 0){
                                                echo "<span class='text-danger font-weight-bold'>"._NOTACCEPT."</span>";
                                            } else {
                                                echo "<span class='text-success font-weight-bold'>"._ACCEPT."</span>";
                                            } 
                                        ?>
                                    </td>
                                    <td>
                                        <a href="detail_import.php?import_id=<?php echo $import['id']?>" class="btn btn-info btn-sm"><?=_DETAIL?></a>
                                        <?php if($import['status'] == 0): ?>
                                            <a href="delete_import.php?import_id=<?php echo $import['id']?>" class="btn btn-danger btn-sm"><?=_DELETE?></a>
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
    
</body>
</html>