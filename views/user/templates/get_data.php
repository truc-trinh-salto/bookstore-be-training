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
            $_SESSION['lang'] = 'en';
            include "public/language/en.php";
    }
    $category_last;
?>
<?php if($number > 0):?>
    <div class="books-show">
            <?php foreach($categories as $category): ?>
                <?php 
                    // $stmt = $db->prepare('SELECT count(*) as total FROM books WHERE category_id =?');
                    // $stmt->bind_param('i', $category['category_id']);
                    // $stmt->execute();

                    // $total =$stmt->get_result()->fetch_assoc();
                    $category_last= $category['category_id'];
                    ?>
                <div style="height:50px; width:50px;"></div>
                <h3><?php echo $category['name_category'] ?> (0)</h3>

                <div class="row mt-4">
                    <?php foreach($category['books'] as $book):?> 
                    <!-- <?php var_dump($book)?> -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-course-item">
                                <a href="">

                                    <img class="card-img-top" width="150" height="200" src="<?php echo $book['address']? '../'.$book['address']:'https://tse4.mm.bing.net/th?id=OIP.ZiwfBrifIO4lV_Q-gIC7VQHaKx&pid=Api&P=0&h=180' ?>" alt="">
                                </a>
                                
                                <div class="card-body">
                                    <a href="detail_product.php?book_id=<?php echo $book['book_id'] ?>">
                                        <h5 class="card-title"><?= $book['title']?></h5>
                                    </a>

                                    <p class="card-text" ><?=_AUTHORS?>: <?= $book['authors']?></p>
                                        <?php if($book['sale'] && $book['sale'] != 0 && $book['sale'] != null): ?>
                                            <p class="text-success font-weight-bold"><del class="text-danger"><?php echo number_format($book['price'],2) ?></del> <?php echo number_format($book['price'] - $book['sale']*$book['price'] / 100,2)?></p>
                                        <?php else:?>
                                            <p class="font-weight-bold"><?php echo number_format($book['price'],2) ?></p>
                                        <?php endif;?>

                                    <input type="hidden" name="book_id" value="<?= $book['book_id']?>">
                                    
                                    <?php if($book['sale'] != 0 && $book['sale'] != null): ?>
                                        <input type="hidden" name="price" value="<?php echo $book['price'] - $book['sale']*$book['price'] / 100?>">
                                    <?php else:?>
                                        <input type="hidden" name="price" value="<?php echo $book['price']?>">
                                    <?php endif;?>
                                    

                                    <button type="submit" class ="btn btn-primary shadow-0 me-1 btn-add-to-cart" data-book-id="<?php echo $book['book_id']; ?>" name="add-to-cart" >
                                    <?=_ADDTOCART?>
                                    </button>
                                    
                                </div>
                        </div>
                    </div>

                    <?php endforeach;?>
                </div>
                <?php endforeach; ?>
            </div>
        <?php if($number_rows > $limit): ?>
            <div class="load-more" lastID="<?php echo $category_last; ?>" style="display: none;">
                            <span>Loading...</span>
            </div>
        <?php else:?>
            <div class="load-more" lastID=0 style="display: block;">
                            <span>End...</span>
            </div>
        <?php endif;?>


<?php else: ?>
    <div class="load-more" lastID=0 style="display: block;">
                        <span>End...</span>
    </div>
<?php endif;?>