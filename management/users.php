<?php
    session_start();
    require_once('../database.php');
    $db = DBConfig::getDB();
    $users;
    $limit = 6;
    

    if(isset($_GET['search_keyword']) && $_GET['search_keyword']!= null) {
        $search_keyword = $_GET['search_keyword'];
        $search = "%$search_keyword%";
        $stmt = $db->prepare('SELECT * FROM users WHERE username LIKE ? OR email LIKE ? OR phone LIKE ? OR fullname LIKE ?');
        $stmt->bind_param("ssss",$search, $search, $search, $search);
    } else {
        $stmt = $db->prepare("SELECT * FROM users");
    }

    $stmt->execute();

    $number_result = $stmt->get_result()->num_rows;

    $number_page = ceil($number_result/ $limit);
    
    if(isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    $page_first = ($page - 1) * $limit;
    
    if(isset($_GET['search_keyword'] ) && $_GET['search_keyword']!= null) {
        $search_keyword = $_GET['search_keyword'];
        $search = "%$search_keyword%";
        $stmt = $db->prepare('SELECT * FROM users WHERE username LIKE ? OR email LIKE ? OR phone LIKE ? OR fullname LIKE ? LIMIT ?,?');
        $stmt->bind_param("ssssii",$search, $search, $search, $search, $page_first, $limit);
        
    } else {
        $stmt = $db->prepare('SELECT * from users LIMIT ?,?');
        $stmt->bind_param('ii', $page_first, $limit);
    }
    $stmt->execute();
    $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


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
            <form class="form-inline nav-item" method="GET" action="">
                    <input class="form-control mr-sm-2" type="search" placeholder="<?=_SEARCH?>" aria-label="Search" name="search_keyword">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?=_SEARCH?></button>
            </form>

            <div class="d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php if($page - 1 == 0):?>
                                        <li class="page-item disabled"><a class="page-link" href="users.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="users.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page -1?>"><?=_PREVIOUS?></a></li>
                                    <?php endif;?>
                                    <li class="page-item active"><a class="page-link" href="users.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page?>"><?php echo $page ?></a></li>
                                    <?php if($page +1 > $number_page):?>
                                        <li class="page-item disabled"><a class="page-link" href="users.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page +1?>"><?=_NEXT?></a></li>
                                    <?php else:?>
                                        <li class="page-item"><a class="page-link" href="users.php?search_keyword=<?php echo $search_keyword ?>&page=<?php echo $page +1?>"><?=_NEXT?></a></li>
                                    <?php endif;?>
                                </ul>
                            </nav>
                    </div>
                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" colspan="2">#</th>
                                <th scope="col"><?=_USERNAME?></th>
                                <th scope="col"><?=_NAME?></th>
                                <th scope="col"><?=_EMAIL?></th>
                                <th scope="col"><?=_PHONE?></th>
                                <th scope="col"><?=_ROLE?></th>
                                <th scope="col"><?=_STATUS?></th>
                                <th scope="col"><?=_ACTION?></th>
                                <th scope="col"><?=_TRANSACTION?></th>
                            </tr>
                        </thead>
                            <?php foreach($users as $user):?> 
                                <tr>
                                    <th scope="row"><?= $index ?></th>
                                    <td>
                                        <img width="100" height="100" src="
                                        <?php 
                                        if($user['image']){
                                            echo '../'. $user['image'];
                                        }else {
                                            echo 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT3cD47c9xUZyKlO3j3z9vdBHV0P2BIwfkeWg&s';
                                        }?>
                                        " alt="<?php $user['user_id']?>">
                                    </td>
                                    <td><?= $user['username'] ?></td>
                                    <td><?= $user['fullname']?></td>
                                    <td><?= $user['email']?></td>
                                    <td><?= $user['phonenumber']?></td>
                                    <td><?= $user['role'] == 0 ? _USER : _MANAGER ?></td>
                                    <td>
                                        <?php if ($user['deactivate'] == 0): ?>
                                            <a href="activate_user.php?user_id=<?php echo $user['id']?>&action=lock" class="btn btn-success btn-sm"><?=_ACTIVE?></a>
                                        <?php else: ?>
                                            <a href="activate_user.php?user_id=<?php echo $user['id']?>&action=unlock" class="btn btn-danger btn-sm"><?=_NOTACTIVE?></a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="edit_product.php?book_id=<?php echo $book['book_id']?>" class="btn btn-primary btn-sm"><?=_EDIT?></a>

                                    </td>
                                    <td>
                                    <a href="transaction_user.php?user_id=<?php echo $user['id']?>" class="btn btn-info btn-sm"><?=_DETAIL?></a>
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