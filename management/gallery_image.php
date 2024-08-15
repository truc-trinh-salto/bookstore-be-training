<?php
    session_start();
    require_once('../database.php');
    $db = DBConfig::getDB();
    $images;

    $book_id = $_GET['book_id'];

    $limit = 6;

    $stmt = $db->prepare('SELECT * FROM gallery_image where book_id = ?');
    $stmt->bind_param('i', $book_id);
    $stmt->execute();

    $number_result = $stmt->get_result()->num_rows;
    $number_page = ceil($number_result / $limit);

    if(!isset($_GET['page'])){
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    $page_first = ($page - 1) * $limit;




    $stmt = $db->prepare('SELECT * FROM gallery_image where book_id = ? LIMIT ?,?');
    $stmt->bind_param("iii",$book_id, $page_first, $limit);
    $stmt->execute();
    $images = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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
                    <form action="add_gallery.php" method="POST" enctype="multipart/form-data">
                        <div class="text-center">
                                <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar" height="300" width="300">
                                <h6>Add more photo for book...</h6>
                                <input type="file" class="text-center center-block file-upload" name="profile_image[]" multiple="multiple">
                        </div>
                        <input type="hidden" name="book_id" value="<?php echo $book_id ?>">
                        <div class="form-group">
                            <div class="col-xs-12 d-flex justify-content-center">
                                <br>
                                <button class="btn btn-lg btn-success pull-right" type="submit" name="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                            </div>
                        </div>
                    </form>

                    <div class="d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php if($page - 1 == 0):?>
                                        <li class="page-item disabled"><a class="page-link" href="product.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page -1?>">Previous</a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="product.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page -1?>">Previous</a></li>
                                    <?php endif;?>
                                    <li class="page-item active"><a class="page-link" href="product.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page?>"><?php echo $page ?></a></li>
                                    <?php if($page +1 > $number_page):?>
                                        <li class="page-item disabled"><a class="page-link" href="product.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page +1?>">Next</a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="product.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page +1?>">Next</a></li>
                                    <?php endif;?>
                                </ul>
                            </nav>
                    </div>
                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Mặc định</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                            <?php foreach($images as $image):?> 
                                <tr>
                                    <th scope="row"><?= $index ?></th>
                                    <td>
                                        <img src="../<?php echo $image['address']  ?>" alt="<?php $image['image_id'] ?>" width="100" height="100">
                                    </td>
                                    <td>
                                        <?php if($image['isShow'] == 0): ?>
                                            <a href="default_gallery.php?image_id=<?= $image['image_id']?>&book_id=<?= $book_id?>" class="btn btn-success">Chọn</a>
                                        <?php else: ?>
                                            <a href="default_gallery.php?image_id=<?= $image['image_id']?>&book_id=<?= $book_id?>" class="btn btn-danger">Huỷ</a>
                                        <?php endif; ?>
                                    <td>
                                        <a href="delete_gallery.php?image_id=<?php echo $image['image_id']?>" class="btn btn-danger">Xoá</a>
                                    </td>
                    

                                <?php $index ++?>
                                </tr>   
                            <?php endforeach;?>
                        </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {

    
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.avatar').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
            
        }
    }


    $(".file-upload").on('change', function(){
        readURL(this);
    });
    });

    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>