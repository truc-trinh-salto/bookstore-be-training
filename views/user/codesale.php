<?php
    require_once('../../database.php');
    $db = DBConfig::getDB();
    session_start();
    if(isset($_GET['lang']) && !empty($_GET['lang'])){
        $_SESSION['lang'] = $_GET['lang'];
        if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
         echo "<script type='text/javascript'> location.reload(); </script>";
        }
       }
       if(isset($_SESSION['lang'])){
            include "../../public/language/".$_SESSION['lang'].".php";
       }else{
            include "../../public/language/en.php";
       }
    
    $stmt = $db->prepare('SELECT * FROM codesale where deactivate = 1');
    $stmt->execute();
    $codesales = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmt = $db->prepare('SELECT * FROM categories');
    $stmt->execute();
    $categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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
        <?php include('partials/sub_header.php')?>
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
                <div class="row">
                    <?php foreach($codesales as $codesale):?> 
                    <div class="col-sm-4 col-lg-4">
                        <div class="card card-course-item">
                                <a href="">
                                    <img class="card-img-top" width="150" height="200" src="data:image/jpeg;base64,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" alt="">
                                </a>
                                
                                <div class="card-body">
                                    <a href="">
                                        <h5 class="card-title"><?= $codesale['description']?></h5>
                                    </a>
                                    <p class="card-text" ><?=_STARTAT?>: <?= $codesale['startAt']?></p>
                                    <p class="card-text" ><?=_ENDAT?>: <?= $codesale['endAt']?></p>
                                    <form action="" method="POST">
                                        <input type="hidden" name="address" value="<?= $branch['address']?>">
                                        <input type="hidden" name="lon" value="<?= $branch['address']?>">
                                        <button type="submit" name="submit" class ="btn btn-primary shadow-0 me-1 btn-add-to-cart">
                                            <?php echo $codesale['code']?>
                                        </button>
                                    </form>
                                    
                                </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                    
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const productId = this.dataset.bookId;
                $.ajax({
                    url: 'add_to_cart.php',
                    method: 'POST',
                    data: {book_id: productId,},
                    success: function (response) {
                        const cartCount = JSON.parse(response).count;
                        document.querySelector('.badge').textContent = cartCount;
                        // alert(JSON.parse(response).message);
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });
        });

        // Hàm để thêm sản phẩm vào giỏ hàng
        
    });
</script> -->
<?php

?>
