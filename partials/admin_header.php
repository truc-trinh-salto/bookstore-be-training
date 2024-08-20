<?php
    if(isset($_GET['lang']) && !empty($_GET['lang'])){
        $_SESSION['lang'] = $_GET['lang'];
        if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
         echo "<script type='text/javascript'> location.reload(); </script>";
        }
    }
    if(isset($_SESSION['lang'])){
            include "../public/language/".$_SESSION['lang'].".php";
    }else{
            include "../public/language/en.php";
    }
 ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="product.php">Book Store</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="product.php"><?=_PRODUCT?></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="users.php"><?=_USER?></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="store_system.php"><?=_BRANCH?></a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="revenue.php"><?=_REVENUE?></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="codesale.php"><?=_CODESALE?></a>
                    </li>

                    

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php 
                                echo $_SESSION['fullname']; 
                            ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="../management/add_store.php"><?=_ADDBRANCH?></a>
                        <a class="dropdown-item" href="../management/add_codesale.php"><?=_ADDCODESALE?></a>
                        <a class="dropdown-item" href="../logout.php"><?=_LOGOUT?>
                        </a>
                        </div>
                    </li>

                    <li class="nav-item nav-link">
					<script>
						function changeLang(){
						document.getElementById('form_lang').submit();
						}
					</script>
						<form method='get' action='' id='form_lang'>
                            <input type='hidden' name='code_id' value=<?=$code_id?>>
                            <input type='hidden' name='branch_id' value=<?=$branch_id?>>
                            <input type='hidden' name='order_id' value=<?=$order_id?>>
                            <input type='hidden' name='user_id' value=<?=$user_id?>>
                            <input type='hidden' name='category_id' value=<?=$category_id?>>
                            <input type='hidden' name='search_keyword' value=<?=$search_keyword?>>  
                            <input type='hidden' name='page' value=<?=$page?>>
                            <input type='hidden' name='book_id' value=<?=$book_id?>>
                            <input type='hidden' name='import_id' value=<?=$import_id?>>
							<?=_SELECTLANGUAGES?>: <select name='lang' class="text-info font-weight-bold" onchange='changeLang();' >
							<option value='en' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en'){ echo "selected"; } ?> >English</option>
							<option value='vi' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'vi'){ echo "selected"; } ?> >Vietnamese</option>
							</select>
						</form>
					</li>
                    
                </ul>
            </div>
        </div>
    </nav>