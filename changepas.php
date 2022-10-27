<?php
 require_once "control.php";
 // if not set email
 if (!isset($_SESSION['ses_Email'])) {
	 	header('location:index.php');
	 	exit();
	 }
?>

<!DOCTYPE html>

<html lang="en">

<head>
	
	<meta charset="UTF-8">
	<!-- title -->
	<title>Change Password</title>
	
	<!-- Latest compiled and minified CSS -->
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	
	<!-- fav icon -->
	<link rel="fav icon" href="upload/fav.png">
	
	<!-- Custom style -->
	<link rel="stylesheet" href="css/stylechange.css">

</head>

<body>
    <?php include "menu.php"; ?>
    	<!-- starts here -->
		<div class="container-fluid">
			
			<div class="row" >
		    
				<div class="align-content-xl-stretch offset-md-4" style="margin-top: 100px; width: 600px;border: 1px solid silver; padding: 0px 10px;">
			
					<form action="" method="post">
					
		    		<!-- successful message-->
					<?php if (count($message) > 0): ?>
				    
				    <div class="alert alert-danger alert-dismissible" role="alert" style="position: sticky;top: 90px;">

						<?php foreach ($message as $message): ?>
						
						<li><?php echo $message ?></li>
					
					<?php endforeach; ?>
					
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        
                    		<span aria-hidden="true">&times;</span>
                    
                    	</button>
					
					</div>
					
					<?php endif; ?>
					
					<div>
					
					<h3 class="text-center" style="margin-top: 30px">Change Password</h3>
					
					<hr>
					<!-- error message -->
					<?php if (count($error) > 0): ?>
				    
				    <div class="alert alert-danger alert-dismissible" role="alert" style="position: sticky;top: 90px;">

						<?php foreach ($error as $error): ?>
						
						<li><?php echo $error ?></li>
						
						<button type="button" class="close" data-dismiss="alert">&times;</button>
					
						<?php endforeach; ?>
					
					</div>
					
					<?php endif; ?>
					
					<div class="form-group">
						
						<label for="email">Email</label>
						
						<input type="email" value="<?php echo $_SESSION['ses_Email'] ?>" class="form-control form-control-lg" disabled>
					
					</div>
					
					<!-- starts here -->
					<div class="form-group">
						
						<label for="password">Current Password</label>
						
						<input type="password" name="oldpas" class="form-control form-control-lg">
					
					</div>
					
					<div class="form-group">
						
						<label for="password">New Password</label>
						
						<input type="password" name="newpas" class="form-control form-control-lg">
					
					</div>
					
					<div class="form-group">
						
						<label for="password">Confirm Password</label>
						
						<input type="password" name="conpas" class="form-control form-control-lg">
					
					</div>

					<div class="form-group">
						
						<button type="submit" name="change" class="btn btn-primary btn-block btn-lg">Change</button>
						
						<button type="reset" name="reset-btn" class="btn btn-danger btn-block btn-lg">Cancel</button>
					
					</div>
				
				</div>
			
			</form>
		
		</div>
	
	</div>

</div>

</body>

<script>
	// load number cart item
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</html>