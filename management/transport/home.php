<?php
    session_start();
    require_once('../../database.php');

    $db = DBConfig::getDB();
    $from = $_GET['dateFrom'];
    $to = $GET['dateTo'];

    $upper;
    $lower;

    $limit = 6;

    if(isset($_GET['dateFrom']) && isset($_GET['dateTo'])){
        if(empty($_GET['dateFrom']) && empty($_GET['dateTo'])){
            $timestamp = strtotime(date('Y-m-d'));
            $dateFrom = date('Y-m-01 00:00:00', $timestamp);
            $dateTo  = date('Y-m-t 23:59:59', $timestamp);
        } else {
            $dateFrom = $_GET['dateFrom']. ' 00:00:00';
            $dateTo = $_GET['dateTo'] . ' 23:59:59';
            $dateFrom = str_replace('/', '-', $dateFrom);
            $dateTo = str_replace('/', '-', $dateTo);
        }

        $lower= date('Y-m-d H:i:s', strtotime($dateFrom));
        $upper = date('Y-m-d H:i:s', strtotime($dateTo));

        $stmt = $db->prepare('SELECT t.createdAt, t.address, t.receiver, t.order_id, t.total, o.user_id 
        FROM transactions as t 
        LEFT JOIN order_item as o ON t.order_id = o.id 
        WHERE t.createdAt BETWEEN? AND ? 
        ORDER BY t.createdAt ASC');
        $stmt->bind_param('ss', $lower, $upper);
    } else {
        $timestamp = strtotime(date('Y-m-d'));
        $dateFrom = date('Y-m-01 00:00:00', $timestamp);
        $dateTo  = date('Y-m-t 23:59:59', $timestamp);

        $lower= date('Y-m-d H:i:s', strtotime($dateFrom));
        $upper = date('Y-m-d H:i:s', strtotime($dateTo));
        

        $stmt = $db->prepare('SELECT t.createdAt, t.address, t.receiver, t.order_id, t.total, o.user_id 
        FROM transactions as t 
        LEFT JOIN order_item as o ON t.order_id = o.id 
        WHERE t.createdAt BETWEEN? AND ?
        ORDER BY t.createdAt ASC');

        $stmt->bind_param('ss', $lower, $upper);
    }

    $stmt->execute();
    $number_result = $stmt->get_result()->num_rows;
    $number_page = ceil($number_result / $limit);

    if(!isset($_GET['page'])){
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    $page_first = ($page - 1) * $limit;

    

    if(isset($_GET['dateFrom']) && isset($_GET['dateTo'])){

        $stmt = $db->prepare('SELECT t.createdAt, t.address, t.receiver, t.order_id, t.total, o.user_id, tr.status 
        FROM transactions as t 
        LEFT JOIN order_item as o ON t.order_id = o.id 
        LEFT JOIN transport as tr ON t.transport_id = tr.id 
        WHERE t.createdAt BETWEEN? AND ? 
        ORDER BY tr.status, t.createdAt ASC LIMIT?,?');
        $stmt->bind_param('ssii', $lower, $upper, $page_first, $limit);
    } else {
        $stmt = $db->prepare('SELECT t.createdAt, t.address, t.receiver, t.order_id, t.total, o.user_id, tr.status 
        FROM transactions as t 
        LEFT JOIN order_item as o ON t.order_id = o.id 
        LEFT JOIN transport as tr ON t.transport_id = tr.id 
        WHERE t.createdAt BETWEEN? AND ?
        ORDER BY tr.status, t.createdAt ASC LIMIT?,?');
        $stmt->bind_param('ssii',$lower,$upper, $page_first, $limit);
    }

    $stmt->execute();
    
    $transactions= $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

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
    <?php include('../partials/admin_header.php')?>
        <div class="container">
            <div class="mt-4">
                <form class="row" method="GET">
                    <div class="form-group mb-4">
                        <div class="datepicker date input-group">
                            <input type="datetime" placeholder="Choose Date" class="form-control" id="fecha1" name="dateFrom">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="text font-weight-bold">
                        <span>To</span>
                    </div>
                    <div class="form-group mb-4">
                        <div class="datepicker date input-group">
                            <input type="datetime" placeholder="Choose Date" class="form-control" id="fecha2" name="dateTo">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <button class="btn btn-outline-success" type="submit">Enter</button>
                    </div>
                </form>

                <div class="d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php if($page - 1 == 0):?>
                                        <li class="page-item disabled"><a class="page-link" href="home.php?&dateFrom=<?php echo $from ?>&dateTo=<?php echo $to ?>&page=<?php echo $page -1?>">Previous</a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="home.php?&dateFrom=<?php echo $from ?>&dateTo=<?php echo $to ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                                    <?php endif;?>
                                    <li class="page-item active"><a class="page-link" href="home.php?&dateFrom=<?php echo $from ?>&dateTo=<?php echo $to ?>&page=<?php echo $page?>"><?php echo $page ?></a></li>
                                    <?php if($page +1 > $number_page):?>
                                        <li class="page-item disabled"><a class="page-link" href="home.php?&dateFrom=<?php echo $from ?>&dateTo=<?php echo $to ?>&page=<?php echo $page +1?>">Next</a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="home.php?&dateFrom=<?php echo $from ?>&dateTo=<?php echo $to ?>&page=<?php echo $page +1?>">Next</a></li>
                                    <?php endif;?>
                                </ul>
                            </nav>
                    </div>
                <div class="row">
                    <h4 class="text-center">Danh Thu: <?php echo $total ?></h4>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Thời gian check out</th>
                            <th scope="col">Người nhận</th>
                            <th scope="col">Tổng đơn hàng</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Xem chi tiết</th>
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
                                                                ? '<span class="text-warning font-weight-bold">Đang giao</span>' 
                                                                : '<span class="text-success font-weight-bold">Giao thành công</span>' ?>
                                </td>
                                <td><a class="btn btn-primary"href="detail_transaction.php?order_id=<?php echo $transaction['order_id']?>">Chi tiết</a></td>
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