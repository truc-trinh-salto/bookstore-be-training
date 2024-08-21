<?php 
    session_start();
    require_once('../../database.php');
    $db = DBConfig::getDB();
    if(isset($_GET['lang']) && !empty($_GET['lang'])){
      $_SESSION['lang'] = $_GET['lang'];
      if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
       echo "<script type='text/javascript'> location.reload(); </script>";
      }
  }
  if(isset($_SESSION['lang'])){
          include "../../public/language/".$_SESSION['lang'].".php";
  }else{
          include "../../public/language/en.php";
  }

  $stmt = $db->prepare('SELECT * FROM categories');
  $stmt->execute();
  $categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<html lang="en"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Checkout example for Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/checkout/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <!-- Custom styles for this template -->
    <link href="form-validation.css" rel="stylesheet">
  </head>

  <body class="bg-light">

    <div class="container">
      <?php include 'partials/sub_header.php';?>

      <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted"><?=_YOURCART?></span>
            <span class="badge badge-secondary badge-pill"><?php echo count($_SESSION['cart']); ?></span>
          </h4>
          <ul class="list-group mb-3">
          <?php
						//initialize total
						$total = 0;
						if(!empty($_SESSION['cart'])){
						//connection
						$conn = DBConfig::getDB();
						//create array of initail qty which is 1
 						
 						if(!isset($_SESSION['qty_array'])){
 							$_SESSION['qty_array'] = array_fill(0, count($_SESSION['cart']), 1);
 						}
						$sql = "SELECT * FROM books WHERE book_id IN (".implode(',',$_SESSION['cart']).")";
						$query = $conn->query($sql);
							while($row = $query->fetch_assoc()){
                $index = array_search($row['book_id'], $_SESSION['cart']);
								?>
                <?php if($row['sale'] != null && $row['sale'] != 0){
                        $price = $row['price'] * (1 - $row['sale']/100);
                      } else {
                        $price = $row['price'];
                      }
                ?>
								<li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <h6 class="my-0"><?php echo $row['title'] ?></h6>
                                    <div>
                                        <small class="text-muted">
                                            <td><?=_PRICE?>: <?php echo number_format($price, 2); ?></td>
                                            <td class="form-control" value="<?php echo $_SESSION['qty_array'][$index]; ?>" name="qty_<?php echo $index; ?>"><?=_QUANTITY?>: <?php echo $_SESSION['qty_array'][$index]; ?></td>
                                        </small>
                                    </div>
                                    <span class="text-muted"><?php echo number_format($_SESSION['qty_array'][$index]*$price, 2); ?></span>
									<?php $total += $_SESSION['qty_array'][$index]*$price; ?>
								</li>
								<?php
								
							}
						}
						else{
							?>
							<tr>
								<td colspan="4" class="text-center"><?=_EMPTYCART?></td>
                                </tr>
							<?php
						}
 
					?>
                        
            <li class="list-group-item d-flex justify-content-between">
              <span><?=_TOTAL?> (VND)</span>
              <strong id="total-price"><?php echo number_format($total, 2); ?></strong>
            </li>
          </ul>

          <div class="card p-2">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="<?=_PROMOCODE?>" name="code" id="coupon">
              <div class="input-group-append">
                <button class="btn btn-secondary btn-apply-coupon"><?=_REDEEM?></button>
              </div>
            </div>
          </div>
          <!-- </form> -->
            <div class="card p-2 show-code-sale" id="show-code-sale">


            </div>

        </div>
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3"><?=_BILLADDRESS?></h4>
          <form class="needs-validation" novalidate="" method="POST">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName"><?=_FIRST?></label>
                <input type="hidden" name="code-user" value="" id="code-user">
                <input type="text" class="form-control" id="firstName" placeholder="" value="" required="" name="firstname">
                <div class="invalid-feedback">
                  <?=_VALIDFIRST?>.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName"><?=_LAST?></label>
                <input type="text" class="form-control" id="lastName" placeholder="" value="" required="" name="lastname">
                <div class="invalid-feedback">
                  <?=_VALIDLAST?>.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="username"><?=_USERNAME?></label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">@</span>
                </div>
                <input type="text" class="form-control" id="username" placeholder="<?=_USERNAME?>" required="" name="username">
                <div class="invalid-feedback" style="width: 100%;">
                  <?=_VALIDUSERNAME?>.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="email"><?=_EMAIL?> <span class="text-muted">(<?=_OPTIONAL?>)</span></label>
              <input type="email" class="form-control" id="email" placeholder="ABC@example.com">
              <div class="invalid-feedback">
              <?=_VALIDEMAIL?>.
              </div>
            </div>

            <div class="mb-3">
              <label for="address"><?=_ADDRESS?></label>
              <input type="text" class="form-control" id="address" placeholder="1234 Main St" required="" name="address">
              <div class="invalid-feedback">
                <?=_VALIDADDRESS?>.
              </div>
            </div>

            <div class="mb-3">
              <label for="address2"><?=_ADDRESS2?> <span class="text-muted">(<?=_OPTIONAL?>)</span></label>
              <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
            </div>

            <div class="row">
              <div class="col-md-5 mb-3">
                <label for="country"><?=_COUNTRY?></label>
                <select class="custom-select d-block w-100" id="country" required="" name="country">
                  <option value=""><?=_CHOOSE?>...</option>
                  <option>United States</option>
                </select>
                <div class="invalid-feedback">
                <?=_VALIDCOUNTRY?>.
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="state"><?=_STATE?></label>
                <select class="custom-select d-block w-100" id="state" required="" name="state">
                  <option value=""><?=_CHOOSE?>...</option>
                  <option>California</option>
                </select>
                <div class="invalid-feedback">
                <?=_VALIDSTATE?>.
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="zip"><?=_ZIP?></label>
                <input type="text" class="form-control" id="zip" placeholder="" required="">
                <div class="invalid-feedback">
                <?=_VALIDZIP?>.
                </div>
              </div>
            </div>
            <hr class="mb-4">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="same-address">
              <label class="custom-control-label" for="same-address"><?=_SHIPNOTE1?></label>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="save-info">
              <label class="custom-control-label" for="save-info"><?=_SHIPNOTE2?></label>
            </div>
            <hr class="mb-4">

            <h4 class="mb-3"><?=_PAYMENT?></h4>

            <div class="d-block my-3">
              
            </div>
            <div class="row">
              
            </div>

            <div class="row">
              <div class="col-md-3 mb-3">
                
              </div>
              <div class="col-md-3 mb-3">
                
              </div>
            </div>
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit" name="submit"><?=_CONFIRMCHECKOUT?></button>
          </form>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';

        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');

          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
              form.action = '../../service/cart/confirm_checkout.php';
            }, false);
          });
        }, false);
      })();

      document.addEventListener('DOMContentLoaded', function () {
        const applyCoupon = document.querySelector('.btn-apply-coupon');
        applyCoupon.addEventListener('click', function (event) {
          event.preventDefault();
          const code = document.querySelector('#coupon').value;
          const totalPrice =  <?php echo $total;?>;
          // alert(totalPrice);
          $.ajax({
                    url: '../../service/cart/apply_coupon.php',
                    method: 'POST',
                    data: {code: code,total : totalPrice},
                    success: function (response) {
                        const message = JSON.parse(response).message;
                        document.querySelector('.show-code-sale').textContent = message;
                        const code_id = JSON.parse(response).code_id;
                        const totalAfterCoupon = JSON.parse(response).total;
                        if(code_id) {
                          document.getElementById('code-user').value = code_id;
                          const value = document.getElementById('code-user').value;
                        }

                        if(totalPrice != totalAfterCoupon) {
                          const text = '<p class="font-weight-bold text-danger">Giảm giá: -'+((totalPrice - totalAfterCoupon).toLocaleString('it-IT', {style : 'currency', currency : 'VND'})+'</p>');
                          const textAfter = '<p class="font-weight-bold text-success">Sau khi giảm: '+(totalAfterCoupon.toLocaleString('it-IT', {style : 'currency', currency : 'VND'})+'</p>');
                          document.getElementById('show-code-sale').innerHTML = text + textAfter;
                        } else {
                          const text = '<p class="font-weight-bold text-danger">'+JSON.parse(response).message +'</p>';
                          document.getElementById('show-code-sale').innerHTML = text;
                        }
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
        });
        
        
    });

      



    </script>
</body></html>