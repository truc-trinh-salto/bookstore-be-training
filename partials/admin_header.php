<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="product.php">Book Store</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="product.php">Sản phẩm</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Người dùng</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="store_system.php">Chi nhánh</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="revenue.php">Doanh thu</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="category.php">Thể loại</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="codesale.php">Mã khuyến mãi</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="hot_item.php">Bán chạy</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="inventory.php">Nhập hàng</a>
                    </li>

                    

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php 
                                echo $_SESSION['fullname']; 
                            ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="../management/add_product.php">Thêm sản phẩm mới</a>
                        <a class="dropdown-item" href="../management/add_category.php">Thêm sản thể loại</a>
                        <a class="dropdown-item" href="../management/add_store.php">Thêm chi nhánh mới loại</a>
                        <a class="dropdown-item" href="../management/add_codesale.php">Thêm mã khuyến mãi</a>
                        <a class="dropdown-item" href="../logout.php">Đăng xuất
                        </a>
                        </div>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>