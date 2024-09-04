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

    $book_id = $_GET['book_id'];

    $selected_image;

    foreach($images as $item) {
        if($item['isShow'] == 1){
            $selected_image = $item;
        }
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
        <?php include('views/management/partials/admin_header.php') ?>
        <div class="container">
        <section layout:fragment="content">
    <div class="row">
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?=_EDITPRODUCT?></h4>
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
                    <form action="/product/editProduct" method="POST" class="forms-sample">
                        <input type="hidden" name="book_id" value="<?php echo $book_id ?>">
                        <div class="form-group">
                        <div class="text-center">
                                <img src="<?php echo $selected_image['address']?>" class="rounded" id="book_image" width="200" height="200" alt="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputCategory"><?=_GALLERY?></label>
                            <select class="form-control select-image" id="exampleInputCategory" name="image_id" onchange="handleSelectChange(event)">
                                <?php $index = 0; ?>
                                <?php foreach($images as $image):?>
                                    <option value="<?php echo $image['image_id']?>" data-image="<?php echo $image['address'] ?>"
                                    <?php 
                                        if($image['isShow'] == 1){
                                            echo ' selected="selected" ';
                                        }
                                    ?>
                                    ><?=_PHOTO?> <?= $index + 1?></option>
                                    <?php $index++;?>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1"><?=_BOOKNAME?></label>
                            <input type="text" class="form-control" id="exampleInputName1" placeholder="<?=_BOOKNAME?>" name="name" value="<?php echo $book['title']?>" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputAuthor1"><?=_AUTHORS?></label>
                            <input type="text" class="form-control" id="exampleInputAuthor1" placeholder="<?=_AUTHORS?>" name="authors" value="<?php echo $book['authors']?>" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputDescription1"><?=_DESCRIPTION?></label>
                            <input type="text" class="form-control" id="exampleInputDescription1" placeholder="<?=_DESCRIPTION?>" name="description" value="<?php echo $book['description']?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputQuantity"><?=_QUANTITY?></label>
                            <input type="number" class="form-control" id="exampleInputQuantity" placeholder="<?=_QUANTITY?>" name="quantity" min="0" value="<?php echo $book['stock']?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputHot"><?=_SHOWHOME?></label>
                            <select class="form-control" id="exampleInputHot" name="hotItem">
                                <option value="1"><?=_YES?></option>
                                <option value="0"><?=_NO?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputCategory"><?=_CATEGORY?></label>
                            <select class="form-control" id="exampleInputCategory" name="category">
                                <?php foreach($categories as $category):?>
                                    <option value="<?php echo $category['category_id']?>"
                                    <?php 
                                        if($category['category_id'] == $book['category_id']){
                                            echo ' selected="selected" ';
                                        }
                                    ?>
                                    ><?= $category['name_category']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPrice"><?=_PRICE?></label>
                            <input type="number" class="form-control" id="exampleInputPrice" name="price" min="1000" step="any" value="<?php echo $book['price']?>" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputQuantity"><?=_SALE?></label>
                            <input type="number" class="form-control" id="exampleInputQuantity" placeholder="<?=_SALE?>" name="sale" min="0" value="<?php echo $book['sale']?:'0'?>" max="100">
                        </div>
                        <button type="submit" name="submit" class="btn btn-success mr-2"><?=_SAVE?></button>
                        <a href="product" class="btn btn-danger mr-2"><?=_CANCEL?></a>
                    </form>
                </div>
            </div>
        </div>



        <div class="col-md-5 grid-margin stretch-card">
            <div class="row-md-12">
                <form action="/branch/selectWareHouse" method="POST">
                        <input type="hidden" name="book_id" value="<?php echo $book_id ?>">
                        <div class="form-group">
                            <label for="exampleInputCategory"><?=_WAREHOUSE?></label>
                            <select class="form-control" id="exampleInputCategory" name="branch_select">
                                <?php foreach($branches as $branch_select):?>
                                    <option value="<?php echo $branch_select['branch_id']?>"
                                    <?php 
                                        if($branch_select['branch_select'] == 1){
                                            echo ' selected="selected" ';
                                        }
                                    ?>
                                    ><?= $branch_select['title']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <button type="submit" name="submit" class="btn btn-success mr-2"><?=_SAVE?></button>
                </form>
            </div>
            <div class="row-md-12 grid margin stretch-card-card">
            <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"><?=_BRANCHNAME?></th>
                                    <th scope="col"><?=_ADDRESS?></th>
                                    <th scope="col"><?=_HOTLINE?></th>
                                    <th scope="col"><?=_DETAIL?></th>
                                </tr>
                            </thead>
                                <?php foreach($branches as $branch):?> 
                                    <tr>
                                        <th scope="row"><?= $index ?></th>
                                        <td><?= $branch['title'] ?></td>
                                        <td><?= $branch['address'] ?></td>
                                        <td><?= $branch['hotline'] ?></td>
                                        <td>
                                            <?php if($branch['status'] == 1): ?>
                                                <a href="/branch/actionStock?book_id=<?php echo $book_id?>&branch_id=<?php echo $branch['branch_id']?>&action=out" class="btn btn-success btn-sm"><?=_INSTOCK?></a>
                                            <?php else: ?>
                                                <a href="/branch/actionStock?book_id=<?php echo $book_id?>&branch_id=<?php echo $branch['branch_id']?>&action=in" class="btn btn-danger btn-sm"><?=_OUTSTOCK?></a>
                                            <?php endif; ?>
                                            

                                            <?php if($branch['branch_select'] == 1):?>
                                                <a href="" class="btn btn-info btn-sm"><?=_WAREHOUSE?></a>
                                            <?php endif; ?>
                                            
                                        </td>
                                    <?php $index ++?>
                                    </tr>   
                                <?php endforeach;?>
                            </tbody>
                </table>
            </div>
        </div>                             
    </div>

	

</section>
        </div>
    </div>
    
</body>
</html>
<script>
    function handleSelectChange(event) {
        var selectElement = event.target;
        var value = selectElement.value;
        var imageSrc = selectElement[event.target.selectedIndex].dataset.image;
        // alert(image);

        var image = new Image();
        image.onload = function () {
            document.getElementById('book_image').setAttribute('src', this.src);
        };
        image.src = imageSrc;
    }
</script>
