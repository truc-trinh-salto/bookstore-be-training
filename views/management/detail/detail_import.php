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

    $import_id = $_GET['import_id'];
    
    $limit = 6;
    
    
    if(!isset($_GET['page'])){
        $page = 1;
    } else {
        $page = $_GET['page'];
    }


    $index = $page * $limit - $limit + 1;
    $total = 0;
?>

<!DOCTYPE html>
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
            <div class="row">
                <div class="col-md-6">
                    <form class="form-inline nav-item" method="GET" action="">
                        <input type="hidden" name="import_id" value="<?php echo $import_id ?>">
                        <input class="form-control mr-sm-2" type="search" placeholder="<?=_SEARCH?>" aria-label="Search" name="search_keyword">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?=_SEARCH?></button>
                    </form>
                </div>
                <div class="col-md-3 justify-content-right">
                    <form class="form-inline nav-item" method="POST" action="<?php echo $import['status'] == 0? '/import/confirmImport':'' ?>">
                        <input type="hidden" name="import_id" value="<?php echo $import_id?>">
                        <button class="btn btn-success my-2 my-sm-0 font-weight-bold" type="submit" <?php echo $import['status'] == 0? '':'disabled=disabled' ?>><?php echo $import['status'] == 0? _SAVE: _ACCEPT?></button>
                    </form>
                </div>

                <div class="col-md-3 d-flex justify-content-end">
                        <form class="form-inline nav-item col-md-6 justify-content-center" method="POST" action="/import/exportFile">
                            <input class="form-control mr-sm-2" type="hidden" name="date_select" value="<?php echo $date?>">
                            <input type="hidden" name="import_id" value="<?php echo $import_id ?>">
                            <button class="btn btn-info my-2 my-sm-0" type="submit"><?=_EXPORT?></button>
                        </form>
                </div>
            </div>


            <div class="row">
                    <div class="col-md-12 text-info d-flex justify-content-center">
                        <h3><?=_TITLE?>: <?php echo $import['title'] ?></h3>
                    </div>
            </div>       
            <div class="d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php if($page - 1 == 0):?>
                                        <li class="page-item disabled"><a class="page-link" href="detailInventory?import_id=<?php echo $import_id ?>&search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="detailInventory?import_id=<?php echo $import_id ?>&search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                                    <?php endif;?>
                                    <li class="page-item active"><a class="page-link" href="detailInventory?import_id=<?php echo $import_id ?>&search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page?>"><?php echo $page ?></a></li>
                                    <?php if($page +1 > $number_page):?>
                                        <li class="page-item disabled"><a class="page-link" href="detailInventory?import_id=<?php echo $import_id ?>&search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page +1?>"><?=_NEXT?></a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="detailInventory?import_id=<?php echo $import_id ?>&search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page +1?>"><?=_NEXT?></a></li>
                                    <?php endif;?>
                                </ul>
                            </nav>
                    </div>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end">
                            <form action="/import/importFile" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="import_id" value="<?php echo $import_id?>">
                                <input type="file" class="text-center center-block file-upload" name="fileimport">
                                <button class="btn btn-outline-success" type="submit" name="submit-import"><?=_MAKEIMPORT?></button>
                            </form>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"><?=_PHOTO?></th>
                                <th scope="col"><?=_BOOKNAME?></th>
                                <th scope="col"><?=_AUTHORS?></th>
                                <th scope="col"><?=_CATEGORY?></th>
                                <th scope="col"><?=_PRICE?></th>
                                <th scope="col"><?=_IMPORTED?></th>
                                <th scope="col"><?=_PREIMPORTED?></th>
                                <th scope="col"><?=_POSTIMPORTED?></th>
                                <th scope="col"><?=_ACTION?></th>
                            </tr>
                        </thead>
                            <?php foreach($books as $book):?> 
                                <tr>
                                    <th scope="row"><?= $index ?></th>
                                    <td>
                                        <img width="100" height="100" src="
                                        <?php 
                                        if($book['address']){
                                            echo '../'.$book['address'];
                                        }else {
                                            echo 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT3cD47c9xUZyKlO3j3z9vdBHV0P2BIwfkeWg&s';
                                        }?>
                                        " alt="<?php $book['book_id']?>">
                                    </td>
                                    <td><?= $book['title'] ?></td>
                                    <td><?= $book['authors']?></td>
                                    
                                    <td><?= $book['name_category']?></td>
                                    <td>
                                        <?php if($book['sale']): ?>
                                            <div class="row">
                                                <del class="col-md-12"><?php echo number_format($book['price'],2) ?></del>
                                                <span class="col-md-12 text-danger">-<?php echo $book['sale'] ?>%</span>
                                                <span class="col-md-12 text-success"><?php echo number_format($book['price'] - $book['sale']*$book['price'] / 100,2)?></span>
                                            </div>
                                        <?php else:?>
                                            <span><?php echo number_format($book['price'],2) ?></span>
                                        <?php endif;?>
                                    </td>

                                    <td class="text-danger font-weight-bold edit">
                                        <span id="quantity-<?php echo $book['book_id'] ?>" style="display:block;"><?php echo number_format($book['quantity'],0)?></span>
                                        <input type="number" class="text-danger font-weight-bold"  style="width: 100px; display:none;" name="edit-quantity-<?php echo $book['book_id']?>" min="0" value="<?php echo number_format($book['quantity'],0)?>">
                                    </td>

                                    <td class="text-primary font-weight-bold"><?php echo number_format($book['before_import'],0)?></td>

                                    <td class="text-success font-weight-bold">
                                        <span id="after-stock-<?php echo $book['book_id'] ?>" style="display:block;"><?php echo number_format($book['after_stock'],0)?></span>
                                    </td>
                                    
                                    <td>
                                        <a href="#" name="button-edit-<?php echo $book['book_id']?>" class="btn btn-primary btn-edit-quantity" style="display:block;"data-book-id="<?php echo $book['book_id'] ?>"><?=_EDIT?></a>
                                        <a href="#" class="btn btn-success btn-save-quantity" style="display:none;" data-book-id="<?php echo $book['book_id'] ?>"><?=_SAVE?></a>
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

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript" >
    document.addEventListener('DOMContentLoaded', function () {
        const addToCartButtons = document.querySelectorAll('.btn-edit-quantity');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                const bookId = this.dataset.bookId;

                const quantitySpan = document.querySelector(`span[id="quantity-${bookId}"]`);
                const quantityInput = document.querySelector(`input[name="edit-quantity-${bookId}"]`);

                if (quantityInput && quantitySpan) {
                    // Toggle visibility
                    quantitySpan.style.display = 'none';
                    quantityInput.style.display = 'block';
                    button.style.display = 'none';
                    button.nextElementSibling.style.display = 'block';
                }

                const quantity = quantityInput.value;
            });
        });

        const saveQuantityButtons = document.querySelectorAll('.btn-save-quantity');
        saveQuantityButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                const bookId = this.dataset.bookId;
                const import_id = <?php echo $_GET['import_id']?>;

                const quantitySpan = document.querySelector(`span[id="quantity-${bookId}"]`);
                const quantityInput = document.querySelector(`input[name="edit-quantity-${bookId}"]`);
                var quantity;
                if(quantityInput.value < 0 ){
                    quantity = 0;
                } else {
                    quantity = quantityInput.value;
                }
                // const quantity = quantityInput.value;
                const buttonEdit = document.querySelector(`a[name="button-edit-${bookId}"]`);
                const quantityAfterStock = document.querySelector(`span[id="after-stock-${bookId}"]`);

                

                $.ajax({
                    url: '/import/updateQuantity',
                    method: 'POST',
                    data: {book_id: bookId, quantity: quantity, import_id: import_id},
                    success: function (response) {
                        quantitySpan.textContent = JSON.parse(response).quantity;
                        quantityAfterStock.textContent = JSON.parse(response).new_after_stock;
                        quantitySpan.style.display = 'block';
                        quantityInput.style.display = 'none';
                        button.style.display = 'none';
                        buttonEdit.style.display = 'block';

                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });
        });
        
    }); 
    </script>