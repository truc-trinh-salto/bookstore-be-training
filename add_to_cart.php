<?php

    require_once('database.php');
    $db = DBConfig::getDB();
    session_start();

    $book_id = $_POST['book_id'];

    $stmt = $db->prepare("SELECT * FROM books WHERE book_id = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $book = $stmt->get_result()->fetch_assoc();

    $cartArray = $_SESSION['cart'];
    $qtyArray = $_SESSION['qty_array'];

    $quantity = 1;
    if($_POST['quantity'] == '' || $_POST['quantity'] <= 0){
        $quantity = 1;
    } else {
        $quantity = $_POST['quantity'];
    }

    if(!in_array($book_id, $cartArray)) {
        if($book['stock'] < $quantity){
            $message = 'Sản phẩm đã hết hàng!';
        } else{
            array_push($_SESSION['cart'], $_POST['book_id']);
            array_push($_SESSION['qty_array'], $quantity);
            $message = 'Product added to cart!';
        }
        $content = '<a class="nav-link dropdown-toggle display-count-cart" href="view_cart.php" id="navbarDropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="badge">'. count($_SESSION['cart']).'</span> Cart <span class="glyphicon glyphicon-shopping-cart"></span> 
                        </a>';
        $content .= '<div class="dropdown-menu display-cart" aria-labelledby="navbarDropdown">';
        $stmt = $db->prepare("SELECT * FROM books WHERE book_id IN (" . implode(',', $_SESSION['cart']) . ")");
        $stmt->execute();
        $book_cart = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($book_cart as $cart) {
            $index = array_search($cart['book_id'], $_SESSION['cart']);
            $price = $cart['price'];
            if ($cart['sale'] != null && $cart['sale'] > 0) {
                $price -= ($price * $cart['sale'] / 100);
            }
            $stmt = $db->prepare('SELECT * FROM gallery_image WHERE book_id =? and isShow = 1');
            $stmt->bind_param('i', $cart['book_id']);
            $stmt->execute();
            $image_cart = $stmt->get_result()->fetch_assoc();
          

            $content .= '<div class="row mt-4">
                            <div class="col-6">
                                <img width="70" height="70" src="' . $image_cart['address'] . '">
                            </div>
                            <div class="col-6">
                                <a href="">' . $cart['title'] . '</a>
                                <p>' . $_SESSION['qty_array'][$index] . '</p>
                                <p class="font-weight-bold text-info" style="font-size:10px;">' . number_format($price * $_SESSION['qty_array'][$index], 2) . '</p>
                            </div>
                        </div>';
        }

        $content .= '</div>';
        echo  $content;
    } else {
        $index = array_search($book_id,$cartArray);
        $newQty = $qtyArray[$index] + $quantity;
        $message;
        if($book['stock'] < $newQty ){
            $message = 'Sản phẩm đã vượt quá số lượng cho phép!';
        } else {
            $_SESSION['qty_array'][$index] = $newQty;

            $message= 'Product already in the cart!'; 
        }
        $content = '<a class="nav-link dropdown-toggle" href="view_cart.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="badge">'. count($_SESSION['cart']).'</span> Cart <span class="glyphicon glyphicon-shopping-cart"></span> 
                        </a>';
        $content .= '<div class="dropdown-menu display-cart" aria-labelledby="navbarDropdown">';
        $stmt = $db->prepare("SELECT * FROM books WHERE book_id IN (" . implode(',', $_SESSION['cart']) . ")");
        $stmt->execute();
        $book_cart = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($book_cart as $cart) {
            $index = array_search($cart['book_id'], $_SESSION['cart']);
            $price = $cart['price'];
            if ($cart['sale'] != null && $cart['sale'] > 0) {
                $price -= ($price * $cart['sale'] / 100);
            }
            $stmt = $db->prepare('SELECT * FROM gallery_image WHERE book_id =? and isShow = 1');
            $stmt->bind_param('i', $cart['book_id']);
            $stmt->execute();
            $image_cart = $stmt->get_result()->fetch_assoc();

            $content .= '<div class="row mt-4">
                            <div class="col-6">
                                <img width="70" height="70" src="' . $image_cart['address'] . '">
                            </div>
                            <div class="col-6">
                                <a href="">' . $cart['title'] . '</a>
                                <p>' . $_SESSION['qty_array'][$index] . '</p>
                                <p class="font-weight-bold text-info" style="font-size:10px;">' . number_format($price * $_SESSION['qty_array'][$index], 2) . '</p>
                            </div>
                        </div>';
        }

        $content .= '</div>';
        echo  $content;
    }

?>