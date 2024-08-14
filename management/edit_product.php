<?php
    session_start();
    require_once('../database.php');

    $db = DBConfig::getDB();
    $stmt = $db->prepare('SELECT * FROM categories');
    $stmt->execute();
    $result = $stmt->get_result();
    $categories = $result->fetch_all(MYSQLI_ASSOC);

    $book_id = $_GET['book_id'];

    $book;
    $stmt = $db->prepare('SELECT b.title, b.image, b.book_id, b.description, b.category_id, b.price, 
                                    b.created_at, b.updated_at, b.sale, b.hotItem, b.stock, b.authors, c.name_category
                                    FROM books as b 
                                    LEFT JOIN categories as c 
                                    ON b.category_id = c.category_id
                                    WHERE b.book_id = ?
                                    ORDER BY b.book_id ASC');
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $book = $stmt->get_result()->fetch_assoc();


    $branchs;
        
    $stmt = $db->prepare('SELECT br.branch_id, br.title, br.address, br.hotline, br.image, brst.status, brst.branch_select FROM branch as br
                            LEFT JOIN branchstockitem as brst
                            ON br.branch_id = brst.branch_id
                            WHERE brst.book_id = ?');
    $stmt->bind_param('i', $book_id);
    $stmt->execute();
    $branchs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmt = $db->prepare('SELECT * FROM gallery_image where book_id =?');
    $stmt->bind_param('i', $book_id);
    $stmt->execute();

    $images = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

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
        <?php include('../partials/admin_header.php') ?>
        <div class="container">
        <section layout:fragment="content">
    <div class="row">
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Thêm sản phẩm mới</h4>
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
                    <form action="" method="POST" class="forms-sample">
                        <div class="form-group">
                        <div class="text-center">
                                <img src="../<?php echo $selected_image['address']?>" class="rounded" id="book_image" width="200" height="200" alt="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputCategory">Mục hình ảnh</label>
                            <select class="form-control select-image" id="exampleInputCategory" name="image_id" onchange="handleSelectChange(event)">
                                <?php $index = 0; ?>
                                <?php foreach($images as $image):?>
                                    <option value="<?php echo $image['image_id']?>" data-image="<?php echo '../'.$image['address'] ?>"
                                    <?php 
                                        if($image['isShow'] == 1){
                                            echo ' selected="selected" ';
                                        }
                                    ?>
                                    >Hình <?= $index + 1?></option>
                                    <?php $index++;?>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="exampleInputName1" placeholder="Product Name" name="name" value="<?php echo $book['title']?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputAuthor1">Tác giả</label>
                            <input type="text" class="form-control" id="exampleInputAuthor1" placeholder="Authors" name="authors" value="<?php echo $book['authors']?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputDescription1">Mô tả</label>
                            <input type="text" class="form-control" id="exampleInputDescription1" placeholder="Description" name="description" value="<?php echo $book['description']?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputQuantity">Số lượng</label>
                            <input type="number" class="form-control" id="exampleInputQuantity" placeholder="Quantity" name="quantity" value="<?php echo $book['stock']?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputHot">Hiển thị trang chủ</label>
                            <select class="form-control" id="exampleInputHot" name="hotItem">
                                <option value="1">Có</option>
                                <option value="0">Không</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputCategory">Thể loại</label>
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
                            <label for="exampleInputPrice">Giá tiền</label>
                            <input type="number" class="form-control" id="exampleInputPrice" name="price" value="<?php echo $book['price']?>">
                        </div>
                        <button type="submit" name="submit" class="btn btn-success mr-2">Lưu lại</button>
                        <a href="product.php" class="btn btn-danger mr-2">Huỷ</a>
                    </form>
                </div>
            </div>
        </div>



        <div class="col-md-5 grid-margin stretch-card">
            <div class="row-md-12">
                <form action="edit_branch_select.php" method="POST">
                        <input type="hidden" name="book_id" value="<?php echo $book_id ?>">
                        <div class="form-group">
                            <label for="exampleInputCategory">Nơi xuất kho</label>
                            <select class="form-control" id="exampleInputCategory" name="branch_select">
                                <?php foreach($branchs as $branch_select):?>
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
                        <button type="submit" name="submit" class="btn btn-success mr-2">Lưu lại</button>
                </form>
            </div>
            <div class="row-md-12 grid margin stretch-card-card">
            <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên chi nhánh</th>
                                    <th scope="col">Địa chỉ</th>
                                    <th scope="col">Số điện thoại</th>
                                    <th scope="col">Chi tiết</th>
                                </tr>
                            </thead>
                                <?php foreach($branchs as $branch):?> 
                                    <tr>
                                        <th scope="row"><?= $index ?></th>
                                        <td><?= $branch['title'] ?></td>
                                        <td><?= $branch['address'] ?></td>
                                        <td><?= $branch['hotline'] ?></td>
                                        <td>
                                            <?php if($branch['status'] == 1): ?>
                                                <a href="action_stock.php?book_id=<?php echo $book_id?>&branch_id=<?php echo $branch['branch_id']?>&action=out" class="btn btn-success btn-sm">Còn hàng</a>
                                            <?php else: ?>
                                                <a href="action_stock.php?book_id=<?php echo $book_id?>&branch_id=<?php echo $branch['branch_id']?>&action=in" class="btn btn-danger btn-sm">Hết hàng</a>
                                            <?php endif; ?>
                                            

                                            <?php if($branch['branch_select'] == 1):?>
                                            <a href="" class="btn btn-info btn-sm">Xuất kho</a>
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

<?php
    if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $image = $_POST['image_id'];
        $name = $_POST['name'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $hotItem = $_POST['hotItem'];
        $categoryId = $_POST['category'];
        $authors = $_POST['authors'];
        $description = $_POST['description'];

        echo $image;

        $stmt = $db->prepare('UPDATE books SET image = ?, title=?, stock =? , price =?, hotItem=?, category_id=?, authors=?, description=?, updated_at=NOW() WHERE book_id=?');
        $stmt->bind_param('isidiissi', $image, $name, $quantity, $price, $hotItem, $categoryId, $authors, $description,$book_id);
        $stmt->execute();

        if($stmt->affected_rows > 0)
        {
            $stmt = $db->prepare('UPDATE gallery_image SET isShow = 0 WHERE book_id=?');
            $stmt->bind_param('i', $book_id);
            $stmt->execute();

            $stmt = $db->prepare('UPDATE gallery_image SET isShow = 1 WHERE image_id=?');
            $stmt->bind_param('i', $image);
            $stmt->execute();
            $_SESSION['message'] = 'Cập nhật sản phẩm thành công';
            header("refresh: 0");
        }
        else
        {
            $_SESSION['message'] = 'Cập nhật sản phẩm thất bại';
            header("refresh: 0");
        }
    }

?>