<?php
    session_start();

    $book_id = $_GET['book_id'];

    $limit = 6;

    if(!isset($_GET['page'])){
        $page = 1;
    } else {
        $page = $_GET['page'];
    }
    
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
        <?php include('views/management/partials/admin_header.php') ?>
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
                    <form action="/gallery/addGalleryImage" method="POST" enctype="multipart/form-data">
                        <div class="text-center">
                                <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar" height="300" width="300">
                                <h6><?=_UPLOADGALLERY?></h6>
                                <input type="file" class="text-center center-block file-upload" name="profile_image[]" multiple="multiple">
                        </div>
                        <input type="hidden" name="book_id" value="<?php echo $book_id ?>">
                        <div class="form-group">
                            <div class="col-xs-12 d-flex justify-content-center">
                                <br>
                                <button class="btn btn-lg btn-success pull-right" type="submit" name="submit"><i class="glyphicon glyphicon-ok-sign"></i><?=_SAVE?></button>
                            </div>
                        </div>
                    </form>

                    <div class="d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php if($page - 1 == 0):?>
                                        <li class="page-item disabled"><a class="page-link" href="gallery_image?book_id=<?php echo $book_id ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="gallery_image?book_id=<?php echo $book_id ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                                    <?php endif;?>
                                    <li class="page-item active"><a class="page-link" href="gallery_image?book_id=<?php echo $book_id ?>&page=<?php echo $page?>"><?php echo $page ?></a></li>
                                    <?php if($page +1 > $number_page):?>
                                        <li class="page-item disabled"><a class="page-link" href="gallery_image?book_id=<?php echo $book_id ?>&page=<?php echo $page +1?>"><?=_NEXT?></a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="gallery_image?book_id=<?php echo $book_id ?>&page=<?php echo $page +1?>"><?=_NEXT?></a></li>
                                    <?php endif;?>
                                </ul>
                            </nav>
                    </div>
                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"><?=_PHOTO?></th>
                                <th scope="col"><?=_DEFAULT?></th>
                                <th scope="col"><?=_ACTION?></th>
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
                                            <a href="/gallery/defaultGalleryImage?image_id=<?= $image['image_id']?>&book_id=<?= $book_id?>" class="btn btn-success"><?=_CHOOSE?></a>
                                        <?php else: ?>
                                            <a href="/gallery/defaultGalleryImage?image_id=<?= $image['image_id']?>&book_id=<?= $book_id?>" class="btn btn-danger"><?=_CANCEL?></a>
                                        <?php endif; ?>
                                    <td>
                                        <a href="/gallery/deleteGalleryImage?image_id=<?php echo $image['image_id']?>" class="btn btn-danger"><?=_DELETE?></a>
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