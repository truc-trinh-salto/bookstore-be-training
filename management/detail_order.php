<?php
    session_start();
    require_once('../database.php');

    $db = DBConfig::getDB();

    if(isset($_GET['order_id'])){
        $stmt = $db->prepare('SELECT o.book_id, o.quantity, o.price, o.total, o.order_id, b.title, b.authors
                                FROM order_detail as o
                                LEFT JOIN books as b ON o.book_id = b.book_id
                                WHERE o.order_id = ?
                                ORDER BY o.order_id ASC');

        $stmt->bind_param("i", $_GET['order_id']);
        $stmt->execute();
        $order_details = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    $index = 1;
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
        <?php include('../partials/admin_header.php')?>
        <div class="container">
            <div class="mt-4">
                <div class="row">
                    <h3 class="text-center">Mã đơn hàng : <?php echo $_GET['order_id'] ?></h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" colspan="2">#</th>
                                <th scope="col">Tên sách</th>
                                <th scope="col">Tác giả</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Giá Tiền</th>
                                <th scope="col">Tổng tiền của sản phẩm</th>
                            </tr>
                        </thead>
                            <?php foreach($order_details as $order_detail):?> 
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
                                    <td><?= $order_detail['title'] ?></td>
                                    <td><?= $order_detail['authors']?></td>
                                    <td><?= $order_detail['quantity']?></td>
                                    <td><?php echo number_format($order_detail['price'],2)?></td>
                                    <? $total+= $order_detail['total'] ?>
                                    <td><?php echo number_format($order_detail['total'],2)?></td>

                                <?php $index ++?>
                                </tr>   
                            <?php endforeach;?>
                                <tr>
                                    <td colspan="6" class="text-left font-weight-bold">Tổng tiền đơn hàng: </td>
                                    <td colspan="1" class="font-weight-bold"><?php echo number_format($total,2)?></td>
                                </tr>
                        </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>