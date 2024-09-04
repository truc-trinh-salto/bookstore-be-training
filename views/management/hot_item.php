<?php
        session_start();
        $date = $_GET['date_select'];
        
        if(!isset($_GET['page'])){
            $page = 1;
        } else {
            $page = $_GET['page'];
        }

        $page_first = ($page - 1) * $limit;

        $index = $page * $limit - $limit + 1;
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
                <div class="col-md-6 justify-content-start">
                            <a href="product" class="btn btn-success"><?=_BACK?></a>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                        <form class="form-inline nav-item col-md-6 justify-content-center" method="GET" action="/product/exportListHotItems">
                            <input class="form-control mr-sm-2" type="hidden" name="date_select" value="<?php echo $date?>">
                            <button class="btn btn-info my-2 my-sm-0" type="submit"><?=_EXPORT?></button>
                        </form>
                </div>
            </div>
                <div class="d-flex justify-content-center">
                            <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php if($page - 1 == 0):?>
                                            <li class="page-item disabled"><a class="page-link" href="hotItem?search_keyword=<?php echo $search_keyword ?>&date_select=<?php echo $date ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                                        <?php else:?>
                                            <li class="page-item"><a class="page-link" href="hotItem?search_keyword=<?php echo $search_keyword ?>&date_select=<?php echo $date ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                                        <?php endif;?>
                                        <li class="page-item active"><a class="page-link" href="hotItem?search_keyword=<?php echo $search_keyword ?>&date_select=<?php echo $date ?>&page=<?php echo $page?>"><?php echo $page ?></a></li>
                                        <?php if($page +1 > $number_page):?>
                                            <li class="page-item disabled"><a class="page-link" href="hotItem?search_keyword=<?php echo $search_keyword ?>&date_select=<?php echo $date ?>&page=<?php echo $page +1?>"><?=_NEXT?></a></li>
                                        <?php else:?>
                                            <li class="page-item"><a class="page-link" href="hotItem?search_keyword=<?php echo $search_keyword ?>&date_select=<?php echo $date ?>&page=<?php echo $page +1?>"><?=_NEXT?></a></li>
                                        <?php endif;?>
                                    </ul>
                                </nav>
                        </div>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center">
                            <form class="form-inline nav-item col-md-6" method="GET" action="">
                                    <input class="form-control mr-sm-2" type="search" placeholder="<?=_SEARCH?>" aria-label="Search" name="search_keyword" value="<?php echo $search_keyword?>">
                                    <input class="form-control mr-sm-2" type="month" placeholder="Search" aria-label="Search" name="date_select" value="<?php echo $date?>">
                                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?=_SEARCH?></button>
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
                                    <th scope="col"><?=_SHOWHOME?></th>
                                    <th scope="col"><?=_QUANTITYSOLD?></th>
                                    <th scope="col"><?=_QUANTITYTOTAL?></th>
                                    <th scope="col"><?=_STOCK?></th>
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
                                        <td><?php if($book['sale']): ?>
                                            <div class="row">
                                                <del class="col-md-12"><?php echo number_format($book['price'],2) ?></del>
                                                <span class="col-md-12 text-danger">-<?php echo $book['sale'] ?>%</span>
                                                <span class="col-md-12 text-success"><?php echo number_format($book['price'] - $book['sale']*$book['price'] / 100,2)?></span>
                                            </div>
                                        <?php else:?>
                                            <span><?php echo number_format($book['price'],2) ?></span>
                                        <?php endif;?>
                                        </td>
                                        <td><?php   
                                                if($book['hotItem'] == 1){
                                                    echo 'Có';
                                                } else {
                                                    echo 'Không';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <p class="text-danger font-weight-bold">
                                                <?php echo $book['total']?: 0 ?>
                                            </p>
                                        </td>
                                        <td class="text-info font-weight-bold"><?php echo $book['after_stock']?></td>
                                        <td class="text-success font-weight-bold"><?php echo $book['stock']?></td>
                                        <td>
                                            <a href="pageEditProduct?book_id=<?php echo $book['book_id']?>" class="btn btn-primary btn-sm"><?=_EDIT?></a>
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