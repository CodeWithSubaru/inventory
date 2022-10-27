<?php 
	require_once "control.php";
	// if not set email
	if (!isset($_SESSION['ses_Email'])) {
	 	header('location:index.php');
	 	exit();
	 }
	 // if set email
	if (isset($_SESSION['ses_Email'])){
		if ($_SESSION['ses_Type'] >= 8){
		
		}
		if ($_SESSION['ses_Type'] < 8 ) {
			if ($_SESSION['ses_Status'] == 0) {
				header('location: deleted.php');
				exit();
			} else {
				header('location: index_1.php');
			    exit();
			}
		}
	}
 ?>
<!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="UTF-8">

	<title>Order Report -  Lazaro Delivery Gas</title>

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
	
	<?php include "menu.php";
	     // message is set
	     if (isset($_SESSION['message'])): 
	?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: sticky;top:0px;display: block;text-align:center;">
 		<?php
 			echo $_SESSION['message'];
 		
 			unset($_SESSION['message']);
 		?>
 		
 		<button type="button" class="close" data-dismiss="alert" aria-label="Close">

    	<span aria-hidden="true">&times;</span>
 		
 		</button>

</div>
 <?php endif ?>
	<!-- starts here -->
    <div class="container">
    
    		<h1 class="rounded bg-secondary text-light text-center" style="margin-top: 20px;">Order Report :</h1>

    	<div class="row justify-content-center table-hover">

    		<table class="table"> 			
    
    		<thead>
	
				<tr>
		
			        <th scope="col">First Name</th>
		
			        <th scope="col">Last Name</th>
		
			        <th scope="col">Product Name</th>
		
			        <th scope="col">Quantity</th>
		
			        <th scope="col">Total Price</th>
		
			        <th scope="col">Date</th>
		
			        <th scope="col">Action</th>

			    </tr>
			</thead>
   <?php 
 	// query all months
 	$x = 'o';
 	$sql=$conn->prepare("SELECT *,MONTHNAME(c_o_date) as mname,YEAR(c_o_date) as yname, DAY(c_o_date)as dname, TIME(c_o_date) as tname FROM cart_order_tb,userstb WHERE cart_order_tb.message = ? AND cart_order_tb.id = userstb.id GROUP BY (c_o_date)");
 	
 	$sql->bind_param('s',$x);
 	
 	$sql->execute();
 	
 	$result = $sql->get_result();
    	while ($row = $result->fetch_assoc()):
   ?>
    		
			<tbody>
				
				<tr>	
			    	
			    	<td>
			    	
			    		<?= $row["u_First"]; ?>
			    	
			    	</td>
			    	
			    	<td>
			    		
			    		<?= $row["u_Last"]; ?>
			    	
			    	</td>
			   		
			   		<td>
			    		
			    		<?= $row["p_name"]; ?>
			    	</td>
			    	
			    	<td>
			    	
			    		<?= $row["qty"]; ?>
			    	
			    	</td>
			    	
			    	<td>
			    	
			    		₱ <?=number_format($row["total_price"] ,2); ?>
			    	
			    	</td>
			    	
			    	<td>
			    	
			    		<?= $row['c_o_date'] ?>
			    	
			    	</td>
			    	
			    	<td>
			    		
			    		<?php if ($row['message'] == 'o') {
			    		
			    		echo 'Delivered';
			    	}
			    ?>
			    	</td>
				</tr>
		
		</tbody>

	<?php
	 endwhile;
	?>			    
	
	</table>

</div>

</div>


</body>

<script>
	// load items to cart
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