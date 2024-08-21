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

    $user_id = $_SESSION['user_id'];

    $stmt = $db->prepare('SELECT * FROM users where id =?');
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $user = $stmt->get_result()->fetch_assoc();

    $stmt = $db->prepare('SELECT * FROM categories');
    $stmt->execute();

    $categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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
    <style>
        .dropdown:hover>.dropdown-menu {
            display: block;
            }

        
    </style>
</head>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<body>
<hr>
<?php include 'partials/sub_header.php';?>
<div class="container bootstrap snippet">
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
  		<div class="col-sm-10"><h1><?php echo $user['username'] ?></h1></div>
    	<div class="col-sm-2"><a href="/users" class="pull-right"><img title="profile image" class="img-circle img-responsive" src="http://www.gravatar.com/avatar/28fd20ccec6865e2d5f0e1f4446eb7bf?s=100"></a></div>
    </div>
    <div class="row">
  		<div class="col-sm-3"><!--left col-->
              

      <div class="text-center">
      <img src="<?php echo '../../'.$user['image'] ?: 'http://ssl.gstatic.com/accounts/ui/avatar_2x.png'; ?>" class="avatar img-circle img-thumbnail" alt="avatar">
      </div></hr><br>

               
          <div class="panel panel-default">
            <div class="panel-heading">Social Media</div>
            <div class="panel-body">
            	<i class="fa fa-facebook fa-2x"></i> <i class="fa fa-github fa-2x"></i> <i class="fa fa-twitter fa-2x"></i> <i class="fa fa-pinterest fa-2x"></i> <i class="fa fa-google-plus fa-2x"></i>
            </div>
          </div>
          
        </div><!--/col-3-->
        
    	<div class="col-sm-9">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home"><?=_IN4?></a></li>
                <li><a data-toggle="tab" href="#messages"><?=_AVATAR?></a></li>
                <li><a data-toggle="tab" href="#settings"><?=_CHANGEPASSWORD?></a></li> 
              </ul>

              
          <div class="tab-content">
            <div class="tab-pane active" id="home">
                <hr>
                  <form class="form" action="../../service/user/edit_profile.php" method="POST" id="registrationForm">
                      <div class="form-group">
                          <div class="col-xs-6">
                              <label for="fullname"><h4><?=_NAME?></h4></label>
                              <input type="text" class="form-control" name="fullname" id="fullname" placeholder="<?=_NAME?>" title="enter your first name if any." value="<?php echo $user['fullname'] ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                            <label for="date"><h4><?=_BIRTHDAY?></h4></label>
                                <input type="date" class="form-control" id="date" name="birthday" required value="<?php echo $user['birthday'] ?>">
                          </div>
                      </div>
          
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                              <label for="phone"><h4><?=_PHONE?></h4></label>
                              <input type="text" class="form-control" name="phone" id="phone" placeholder="<?=_PHONE?>" title="enter your phone number if any." value="<?php echo $user['phonenumber'] ?>">
                          </div>
                      </div>
          
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                              <label for="email"><h4><?=_EMAIL?></h4></label>
                              <input type="email" class="form-control" name="email" id="email" placeholder="ABC@email.com" title="enter your email." value="<?php echo $user['email'] ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          
                          <div class="col-xs-6">
                              <label for="location"><h4><?=_LOCATION?></h4></label>
                              <input type="text" class="form-control" id="location" placeholder="<?=_LOCATION?>" title="enter a location">
                          </div>
                      </div>
                      <div class="form-group">
                           <div class="col-xs-12">
                                <br>
                              	<button class="btn btn-lg btn-success" type="submit" name="submit"><i class="glyphicon glyphicon-ok-sign"></i> <?=_SAVE?></button>
                               	<!-- <button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button> -->
                            </div>
                      </div>
              	</form>
              
              <hr>
              
             </div><!--/tab-pane-->
             <div class="tab-pane" id="messages">
               
               <h2></h2>
               
               <hr>
               <form action="../../service/user/uploadImage.php" method="POST" enctype="multipart/form-data">
                    <div class="text-center">
                            <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar" height="300" width="300">
                            <h6><?=_UPLOADPHOTO?></h6>
                            <input type="file" class="text-center center-block file-upload" name="profile_image">
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 right">
                            <br>
                            <button class="btn btn-lg btn-success pull-right" type="submit" name="submit"><i class="glyphicon glyphicon-ok-sign"></i> <?=_SAVE?></button>
                        </div>
                    </div>
               </form>
               
             </div><!--/tab-pane-->
             <div class="tab-pane" id="settings">
                  <hr>
                  <form method="POST" action="../../service/user/change_password.php">
                    <div class="form-group">
                          <div class="col-xs-12">
                              <label for="old_password"><h4><?=_OLDPASSWORD?></h4></label>
                              <input type="password" class="form-control" name="old_password" id="old_password" placeholder="<?=_OLDPASSWORD?>" title="enter your password.">
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-xs-12">
                              <label for="new_password"><h4><?=_NEWPASSWORD?></h4></label>
                              <input type="password" class="form-control" name="new_password" id="new_password" placeholder="<?=_NEWPASSWORD?>" title="enter your password.">
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-xs-12">
                            <label for="confirm_password"><h4><?=_CONFIRMPASSWORD?></h4></label>
                              <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="<?=_CONFIRMPASSWORD?>" title="enter your password2.">
                          </div>
                      </div>
                      <div class="form-group">
                           <div class="col-xs-12">
                                <br>
                              	<button class="btn btn-lg btn-success pull-right" type="submit" name="submit"><i class="glyphicon glyphicon-ok-sign"></i> <?=_SAVE?></button>
                               	<!--<button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button>-->
                            </div>
                      </div>
              	</form>
              </div>
               
              </div><!--/tab-pane-->
          </div><!--/tab-content-->

        </div><!--/col-9-->
   
    </div><!--/row-->
  </div> <!--/.container-->
</body>
</html>

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
</script>
                                                      