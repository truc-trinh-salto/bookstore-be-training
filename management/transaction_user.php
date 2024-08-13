<?php
    session_start();
    require_once('../database.php');

    $db = DBConfig::getDB();

    $stmt = $db->prepare('SELECT t.createdAt, t.address, t.receiver, t.order_id, t.total, o.user_id, tr.status 
                            FROM transactions as t 
                            LEFT JOIN order_item as o ON t.order_id = o.id 
                            LEFT JOIN transport as tr ON t.transport_id = tr.id 
                            WHERE o.user_id = ? ORDER BY t.createdAt DESC');
    $stmt->bind_param("i", $_GET['user_id']);
    $stmt->execute();
    
    $transactions= $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    
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
                <div class="row">
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
                                <td><a href="detail_transaction.php?order_id=<?php echo $transaction['order_id']?>">Chi tiết</a></td>
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