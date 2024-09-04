<?php
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
        include "public/language/en.php";
    }

    $page = $_GET['page'] ?: 1;

    $limit = 6;

    $user_id = $_GET['user_id'];

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
                <div class="d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php if($page - 1 == 0):?>
                                        <li class="page-item disabled"><a class="page-link" href="transactionUser?user_id=<?php echo $user_id ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="transactionUser?user_id=<?php echo $user_id ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                                    <?php endif;?>
                                    <li class="page-item active"><a class="page-link" href="transactionUser?user_id=<?php echo $user_id ?>&page=<?php echo $page?>"><?php echo $page ?></a></li>
                                    <?php if($page +1 > $number_page):?>
                                        <li class="page-item disabled"><a class="page-link" href="transactionUser?user_id=<?php echo $user_id ?>&page=<?php echo $page +1?>"><?=_NEXT?></a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="transactionUser?user_id=<?php echo $user_id ?>&page=<?php echo $page +1?>"><?=_NEXT?></a></li>
                                    <?php endif;?>
                                </ul>
                            </nav>
                    </div>

                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col"><?=_TIMECHECKOUT?></th>
                            <th scope="col"><?=_RECEIVER?></th>
                            <th scope="col"><?=_TOTAL?></th>
                            <th scope="col"><?=_STATUS?></th>
                            <th scope="col"><?=_DETAIL?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($transactions as $transaction):?> 
                                <tr>
                                <th scope="row"><?= $index ?></th>
                                <td><?= $transaction['createdAt'] ?></td>
                                <td><?= $transaction['receiver']?></td>
                                <td><?= $transaction['total']?></td>
                                <td><?php echo $transaction['status'] != 1 
                                                                ? '<span class="text-warning font-weight-bold">'._PENDING.'</span>' 
                                                                : '<span class="text-success font-weight-bold">'._SUCCESS.'</span>' ?>
                                </td>
                                <td><a class="btn btn-info"href="detailTransaction?order_id=<?php echo $transaction['order_id']?>"><?=_DETAIL?></a></td>
                                <?php $index ++?>
                            </tr>
                            <?php endforeach;?>
                        </table>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>