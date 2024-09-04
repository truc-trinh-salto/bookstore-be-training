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

    $order_id = $_GET['order_id'];
    
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
        <?php include('views/management/partials/admin_header.php')?>
        <div class="container">
            <div class="col-md-12">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active"data-toggle="tab" href="#home">Chi tiết đơn hàng</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#messages">Trạng thái giao hàng</a></li>
                <!-- <li><a data-toggle="tab" href="#settings">Đổi mật khẩu</a></li>  -->
              </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="home">
                    <div class="mt-4">
                        <div class="row">
                            <h3 class="text-center">Mã đơn hàng : <?php echo $_GET['order_id'] ?></h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col"><?=_BOOKNAME?> </th>
                                        <th scope="col"><?=_AUTHORS?> </th>
                                        <th scope="col"><?=_QUANTITY?> </th>
                                        <th scope="col"><?=_PRICE?> </th>
                                        <th scope="col"><?=_TOTALPRICEBOOK?> </th>
                                    </tr>
                                </thead>
                                    <?php foreach($order_details as $order_detail):?> 
                                        <tr>
                                            <th scope="row"><?= $index ?></th>
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
                                            <td colspan="5" class="text-left font-weight-bold"><?=_SUBTOTAL?>: </td>
                                            <td colspan="1" class="font-weight-bold"><?php echo number_format($total,2)?></td>
                                        </tr>

                                        <tr>
                                            <td colspan="5" class="text-left font-weight-bold"><?=_DISCOUNT?>: </td>
                                            <td colspan="1" class="font-weight-bold text-danger"><?php echo number_format($total - $transaction['total'],2)?></td>
                                        </tr>

                                        <tr>
                                            <td colspan="5" class="text-left font-weight-bold"><?=_TOTAL?>: </td>
                                            <td colspan="1" class="font-weight-bold text-success"><?php echo number_format($transaction['total'],2)?></td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
        
              
                </div><!--/tab-pane-->
                                

                <div class="tab-pane" id="messages">          
                    <div class="mt-4">
                    <div class="row">
                        <h3 class="text-center">Mã đơn hàng : <?php echo $_GET['order_id'] ?></h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Mô tả</th>
                                    <th scope="col">Ngày hoàn thành</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                                <?php $isShow = true; ?>
                                <?php foreach($routes as $route):?> 
                                    <form action="/route/updateRoute" method="POST">
                                        <tr>
                                            <th scope="row"><?= $index ?></th>
                                            <?php if($route['point'] == 0):?>
                                                <td>Xuất kho</td>
                                            <?php elseif($route['point'] == 1):?>
                                                <td>Đang giao</td>
                                            <?php else: ?>
                                                <td>Đã giao thành công</td>
                                            <?php endif;?>


                                            <td><?= $route['estimateDate']?></td>
                                            <?php if($route['status'] == 0):?>
                                                <td class="text-danger font-weight-bold">Chưa xong</td>
                                            <?php else: ?>
                                                <td class="text-success font-weight-bold">Hoàn thành</td>
                                            <?php endif;?>

                                            <input type="hidden" name="route_id" value="<?php echo $route['id']?>">
                                            <input type="hidden" name="transport_id" value="<?php echo $transaction['transport_id']?>">
                                            <input type="hidden" name="point" value="<?php echo $route['point']?>">
                                            
                                            
                                            <td>
                                                <?php if($route['status'] == 0 && $isShow == true):?>
                                                    <?php $isShow = false;?>
                                                    <button type="submit" name="submit" class="btn btn-success">Xong</button>
                                                <?php endif; ?>
                                            </td>

                                        <?php $index ++?>
                                        </tr>   
                                    </form>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
             
            </div><!--/tab-content-->

        </div><!--/col-9-->
            
    </div>
    
</body>
</html>