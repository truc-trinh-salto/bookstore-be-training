<?php
    session_start();
    require_once('database.php');
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

    $db = DBConfig::getDB();

    if(isset($_GET['order_id'])){
        $order_id = $_GET['order_id'];
        $stmt = $db->prepare('SELECT o.book_id, o.quantity, o.price, o.total, o.order_id, b.title, b.authors
                                FROM order_detail as o
                                LEFT JOIN books as b ON o.book_id = b.book_id
                                WHERE o.order_id = ?
                                ORDER BY o.order_id ASC');

        $stmt->bind_param("i", $_GET['order_id']);
        $stmt->execute();
        $order_details = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    $stmt = $db->prepare('SELECT * FROM transactions WHERE order_id = ?');
    $stmt->bind_param("i", $_GET['order_id']);
    $stmt->execute();

    $transaction = $stmt->get_result()->fetch_assoc();

    if($transaction['codesale']){
        $stmt = $db->prepare('SELECT * FROM codesale WHERE id = ?');
        $stmt->bind_param("i", $transaction['codesale']);
        $stmt->execute();

        $codesale = $stmt->get_result()->fetch_assoc();
    }

    $stmt = $db->prepare('SELECT * FROM route where transport_id = ?');
    $stmt->bind_param('i',$transaction['transport_id']);
    $stmt->execute();

    $routes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmt = $db->prepare('SELECT * FROM categories');
    $stmt->execute();
    $categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


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
    
    <script
      src="https://kit.fontawesome.com/0f876a0d49.js"
      crossorigin="anonymous"
    ></script>
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    />
    <link rel="stylesheet" type="text/css" href="main.css" />
    <link
      href="https://fonts.googleapis.com/css?family=Poppins"
      rel="stylesheet"
      type="text/css"
    />
</head>
<body>
    <div class="app">
        <?php include "partials/sub_header.php"?>
        <div class="container">
            <div class="mt-4">
                <div class="row">
                    <h3 class="text-center"><?=_ORDERID?> : <?php echo $_GET['order_id'] ?></h3>
                    
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
                                    <td colspan="5" class="text-left font-weight-bold"><?=_TOTALORDER?> : </td>
                                    <td colspan="1" class="font-weight-bold"><?php echo number_format($total,2)?></td>
                                </tr>

                                <tr>
                                    <td colspan="5" class="text-left font-weight-bold"><?=_DISCOUNT?> : </td>
                                    <td colspan="1" class="font-weight-bold text-danger"><?php echo number_format($total - $transaction['total'],2)?></td>
                                </tr>

                                <tr>
                                    <td colspan="5" class="text-left font-weight-bold"><?=_TOTAL?> : </td>
                                    <td colspan="1" class="font-weight-bold text-success"><?php echo number_format($transaction['total'],2)?></td>
                                </tr>
                        </tbody>
                    </table>
                    <div class="card border-0 col-md-12">
                        <div class="card-body">
                        <!-- Rounded Square Marker Starts -->
                        <ul
                            class="progressbar rb-rounded-square d-flex justify-content-center"
                        >
                        <li class="box <?php if($routes[0]['status'] == 1) echo 'active' ?>"><?=_PACKAGE?> </li>
                            <li class="truck-fast <?php if($routes[1]['status'] == 1) echo 'active' ?>"><?=_DELIVERING?> </li>
                            <li class="success <?php if($routes[2]['status'] == 1) echo 'active' ?>"><?=_SUCCESS?> </li>
                        </ul>
                        <!-- Rounded Square Marker Ends -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>