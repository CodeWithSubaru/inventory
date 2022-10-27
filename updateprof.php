<?php 
	require_once "control.php";
	// if not set email
	if (!isset($_SESSION['ses_Email'])) {
	 	header('location:index.php');
	 	exit();
	 }
	 // if set email
	if (isset($_SESSION['ses_Email'])){
		if ($_SESSION['ses_Type'] == 9){
		}
		if ($_SESSION['ses_Type'] < 9 ) {
			if ($_SESSION['ses_Status'] == 0) {
				header('location: deleted.php');
				exit();
			}
		}
	}
 ?>
<!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="UTF-8">
	
	<title>Update Profile -  Lazaro Delivery Gas</title>
	
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<meta name="HandheldFriendly" content="true">
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	
	<!-- fav icon -->
	<link rel="fav icon" href="upload/fav.png">
	
	<!-- custom style -->
	<link rel="stylesheet" href="css/stylechange.css">

</head>

<body>

	<?php include "menu.php"; ?>
		<!-- if message is set -->
	    <?php if (isset($_SESSION['message'])): ?>
			
			<div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: sticky;top:0px;display: block;text-align:center;">
 		
		 		<?php
		 			echo $_SESSION['message'];
		 		
		 			unset($_SESSION['message']);
		 		?>
		 		
		 		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	
		    		<span aria-hidden="true">&times;</span>
		  		
		  		</button>
			</div>
 		</div>
 <?php endif ?>
	<!-- starts here -->
	<div class="container-fluid">
		
		<div class="row">
		    
			<div class="align-content-xl-stretch offset-md-4" style="margin-top: 100px; width: 600px;border: 1px solid silver; padding: 0px 10px;">
			    
					<h3 class="text-center" style="margin-top: 30px">Update Information</h3>
		
					<hr>
		
					<?php if (count($errors) > 0): ?>
		
				    <div class="alert alert-danger alert-dismissible" role="alert" style="position: sticky;top: 90px;">

						<?php foreach ($errors as $error): ?>
		
						<li><?php echo $error ?></li>
		
						<button type="button" class="close" data-dismiss="alert">&times;</button>
		
					<?php endforeach; ?>
		
					</div>
		
					<?php endif; ?>
		
					<form action="" method="post">
		
					<div class="form-group">
		
						<label for="email">Email</label>
		
						<input type="email" name="ema" class="form-control form-control-lg" value="<?php echo $_SESSION['ses_Email'] ?>" readonly>
		
					</div>

					<div class="form-group">
		
						<label for="first">First Name</label>
		
						<input type="text" name="first" class="form-control form-control-lg" value="<?php echo $_SESSION['ses_First'] ?>" readonly>
		
					</div>
		
					<div class="form-group">
		
						<label for="last">Last Name</label>
		
						<input type="text" name="last" class="form-control form-control-lg" value="<?php echo $_SESSION['ses_Last'] ?>" readonly>
		
					</div>
		
					<div class="form-group">
		
						<label for="number">Mobile Number</label>
		
						<input type="text" name="number"  class="form-control form-control-lg" value="<?php echo $_SESSION['ses_Num'] ?>" >
		
					</div>		
					<!----Present Address ----->
		
					<div class="form-group">
		
						<label for="add"> Present Address</label>
		
						<input type="text" class="form-control form-control-lg" value="<?php echo $_SESSION['ses_Add'] ?>" readonly>
		
					</div>
                    
                    <hr>
					
					<div class="form-group">
					
						<button name="upd" class="btn btn-primary btn-block btn-lg">Update Now</button>
					
					</div>
					
				</form>

</body>
<script>
  $(document).ready(function(){
    load_cart_item_number();
  
  	function load_cart_item_number(){
  	$.ajax({
  		url: 'control.php',
  		method: 'get',
  		data: {cartItem:"cart_item"},
  		success:function(response){
  			$("#cart-item").html(response);
  		}
  	});
  }
  load_fa_user_number();
  function load_fa_user_number(){
  	$.ajax({
  		url: 'control.php',
  		method: 'get',
  		data: {user:"fa_user"},
  		success:function(response){
  			$("#fa").html(response);
  		}
  	});
  }
});

</script>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</html>