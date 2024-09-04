<?php
    session_start();

    $from = $_GET['dateFrom'];
    $to = $_GET['dateTo'];


    $limit = 6;


    if(!isset($_GET['page'])){
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    $page_first = ($page - 1) * $limit;


    $index = 1;

    $total = 0;

    // var_dump($transactions);
    foreach ($transactions as $transaction) {
        $total += $transaction['total'];
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
</head>
<body>
    <div class="app">
    <?php include('views/management/partials/admin_header.php')?>
        <div class="container">
            <div class="mt-4">
                <form class="row" method="GET">
                    <div class="form-group mb-4">
                        <div class="datepicker date input-group">
                            <input type="datetime" placeholder="<?=_STARTREVENUE?>" class="form-control" id="fecha1" name="dateFrom" value="<?php echo $from ?>">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="text font-weight-bold">
                        <span><?=_TO?></span>
                    </div>
                    <div class="form-group mb-4">
                        <div class="datepicker date input-group">
                            <input type="datetime" placeholder="<?=_ENDREVENUE?>" class="form-control" id="fecha2" name="dateTo" value="<?php echo $to ?>">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <button class="btn btn-outline-success" type="submit"><?=_FILTER?></button>
                    </div>
                </form>

                <div class="d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php if($page - 1 == 0):?>
                                        <li class="page-item disabled"><a class="page-link" href="revenue?&dateFrom=<?php echo $from ?>&dateTo=<?php echo $to ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="revenue?&dateFrom=<?php echo $from ?>&dateTo=<?php echo $to ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                                    <?php endif;?>
                                    <li class="page-item active"><a class="page-link" href="revenue?&dateFrom=<?php echo $from ?>&dateTo=<?php echo $to ?>&page=<?php echo $page?>"><?php echo $page ?></a></li>
                                    <?php if($page +1 > $number_page):?>
                                        <li class="page-item disabled"><a class="page-link" href="revenue?&dateFrom=<?php echo $from ?>&dateTo=<?php echo $to ?>&page=<?php echo $page +1?>"><?=_NEXT?></a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="revenue?&dateFrom=<?php echo $from ?>&dateTo=<?php echo $to ?>&page=<?php echo $page +1?>"><?=_NEXT?></a></li>
                                    <?php endif;?>
                                </ul>
                            </nav>
                    </div>
                <div class="row">
                    <h4 class="text-center"><?=_REVENUE?>: <?php echo number_format($total,2) ?></h4>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col"><?=_TIMECHECKOUT?></th>
                            <th scope="col"><?=_RECEIVER?></th>
                            <th scope="col"><?=_TOTAL?></th>
                            <th scope="col"><?=_DETAIL?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($transactions as $transaction):?> 
                                <tr>
                                <th scope="row"><?= $index ?></th>
                                <td><?= $transaction['createdAt'] ?></td>
                                <td><?= $transaction['receiver']?></td>
                                <td><?=  number_format($transaction['total'],2)?></td>
                                <td><a class="btn btn-primary"href="detailTransaction?order_id=<?php echo $transaction['order_id']?>"><?=_DETAIL?></a></td>
                                <?php $index ++?>
                            </tr>
                            <?php endforeach;?>
                        </table>
                </div>
            </div>
        </div>
    </div>
    
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $(function () {
        $('.datepicker').datepicker({
            language: "es",
            autoclose: true,
            format: "dd/mm/yyyy"
        });
        });
</script>
</html>

<?php 

?>