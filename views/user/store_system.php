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
                    <?php foreach($branches as $branch):?> 
                    <div class="col-sm-6 col-lg-6">
                        <div class="card card-course-item">
                                <a href="">
                                    <img class="card-img-top" width="150" height="200" src="<?php echo $branch['image'] ?: 'data:image/png;base64,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' ?>" alt="">
                                </a>
                                
                                <div class="card-body">
                                    <a href="">
                                        <h5 class="card-title"><?= $branch['title']?></h5>
                                    </a>
                                    <p class="card-text" ><?=_ADDRESS?>: <?= $branch['address']?></p>
                                    <p class="card-text" ><?=_HOTLINE?>: <?= $branch['hotline']?></p>
                                    <!-- <form action="" method="POST"> -->
                                    <form action="" method="POST">
                                        <input type="hidden" name="address" value="<?= $branch['address']?>">
                                        <input type="hidden" name="lon" value="<?= $branch['address']?>">
                                        <button type="submit" name="submit" class ="btn btn-primary shadow-0 me-1 btn-add-to-cart" data-book-id="<?php echo $book['book_id']; ?>">
                                        <?=_VIEWLOCATION?>
                                        </button>
                                    </form>
                                    
                                </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                    
                    <?php
                        if(isset($_POST['submit'])){
                            $lat = '10.712190';
                            $lon = '106.737068';
                            $address = $_POST['address']
                            ?>
                            <div class="col-sm-12 col-lg-12">
                                <iframe width="100%" height ="500"src="https://maps.google.com/maps?q=<?php echo $address;?>&output=embed"></iframe>
                            </div>
    
                    <?php 
                        } 
                    ?>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>

<?php

?>
