<?php
    session_start();
    require_once('database.php');

    $conn = DBConfig::getDB();
    
    if(isset($_POST['submit'])) {

        $sql = "SELECT * FROM books WHERE book_id IN (".implode(',',$_SESSION['cart']).")";
        $query = $conn->query($sql);
        $books = $query->fetch_all(MYSQLI_ASSOC);

        if(!checkStockk($books)){
            $_SESSION['message'] = 'Có lỗi khi đặt hàng';
        } else {
            $stmt = $conn->prepare("INSERT INTO order_item (user_id,status) values (?,0)");
            $stmt->bind_param('i', $_SESSION['user_id']);
            $stmt->execute();

            $order_id = $stmt->insert_id;

            $index = 0;
            $total = 0;
            foreach($books as $row)  {
                $qty = $_SESSION['qty_array'][$index];
                $stmt1 = $conn->prepare("INSERT INTO order_detail (book_id, quantity, price, total , order_id) VALUES (?,?,?,?,?)");
                if($row['sale'] != null && $row['sale'] != 0){
                    $price = $row['price'] - ($row['price'] * $row['sale'] /100);
                } else {
                    $price = $row['price'];
                }
                $total_item = $qty * $price;
                $total += $total_item;
                $stmt1->bind_param('iiddi',$row['book_id'],$qty,$price,$total_item, $order_id);
                $stmt1->execute();

                $stmt2 = $conn->prepare("UPDATE books SET stock = stock - ? WHERE book_id =?");
                $stmt2->bind_param('ii', $qty, $row['book_id']);
                $stmt2->execute();

                $index ++;
            }


            $fullname= $_POST['firstname'].' '.$_POST['lastname'];
            $address = $_POST['address'].' '.$_POST['country'] .' '.$_POST['state'];
            $date = strtotime("+7 day");
            if(isset($_POST['code-user']) && $_POST['code-user'] != null) {
                $code_id = $_POST['code-user'];
                $stmt = $conn->prepare("SELECT * FROM codesale WHERE id = ?");
                $stmt->bind_param('i', $code_id);

                $stmt->execute();
                $codesale = $stmt->get_result()->fetch_assoc();

                if($codesale['method'] == 0){
                    $total = $total - ($total * (float)$codesale['value'] / 100);
                } else {
                    $total = $total - (float)$codesale['value'];
                }

                $stmt = $conn->prepare("INSERT INTO user_code(user_id, code_id, status) VALUES (?,?,1");
                $stmt->bind_param('ii', $_SESSION['user_id'], $code_id);
                $stmt->execute();
            }

            $stmt = $conn->prepare("INSERT INTO transport (plannedAt,status) VALUES (DATE_ADD(CURDATE(), INTERVAL 7 DAY),0)");
            $stmt->execute();

            $insert_transport = $stmt->insert_id;

            $stmt2 = $conn->prepare("INSERT INTO transactions (createdAt,shippedAt,address,receiver,order_id,total,codesale,transport_id) values (NOW(),DATE_ADD(CURDATE(), INTERVAL 7 DAY),?,?,?,?,?,?)");
            $stmt2->bind_param('ssidii', $address, $fullname, $order_id, $total,$codesale['id'],$insert_transport);
            $stmt2->execute();

            for($i = 0;$i <=2;$i++){
                $stmt = $conn->prepare("INSERT INTO route (transport_id,point,status,estimateDate) VALUES (?,?,0,DATE_ADD(CURDATE(), INTERVAL 7 DAY))");
                $stmt->bind_param('ii', $insert_transport, $i);
                $stmt->execute();
            }


            unset($_SESSION['cart']);
            unset($_SESSION['qty_array']);

            $_SESSION['message'] = 'Đặt hàng thành công';
            header('Location: home.php');
        }

    }

    function checkStockk($books){
        $cartArray = $_SESSION['cart'];
        $qtyArray = $_SESSION['qty_array'];
        foreach($books as $book){
            $index = array_search($book['book_id'], $cartArray);
            if($book['stock'] < $qtyArray[$index]){
                return false;
            }
            return true;
        }
    }
