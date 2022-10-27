<?php
 require_once "control.php";
?>
<!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="UTF-8">

	<title>Place Order</title>
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	
	<!-- custom style -->
	<link rel="stylesheet" href="css/style_Box3.css">

</head>

<body>
<?php	

	// if not set email
	if (!isset($_SESSION['ses_Email'])) {
		 	header('location:index.php');
		 	exit();
	}
	// if set email
	if (isset($_SESSION['ses_Email'])){
		if ($_SESSION['ses_Type'] == 9){
			header('location:activationad.php');
			exit();
		}
		if ($_SESSION['ses_Type'] < 8 ) {
			if ($_SESSION['ses_Status'] == 0) {
				header('location: deleted.php');
				exit();
			}
		}
	}
?>
<!-- starts here -->
	<div class="container">
		
		<div class="wrapper">
				
				<h4 class="text-danger">Your order(s) was on pending... We will notified you if your order(s) Confirmed</h4>

				
				<p><b>Name of the Receiver :</b> <?=$_SESSION['ses_First']?> 
				
				<?=$_SESSION['ses_Last'] ?></p>
					
				<p><b>Address of the Receiver :</b> <?=$_SESSION['ses_Add'] ?></p>


	<?php 
	//Place Order
	if (isset($_GET['success'])) {
		
		$id = $_GET['success'];
		$mes1 = 'p';
		$mes = 'c';

		// update message into order and execute
		$stmt = $conn->prepare("
			UPDATE cart_order_delivered_tb,producttb
			SET cart_order_delivered_tb.message = ?,
			 	cart_order_delivered_tb.c_o_d_date = NOW() 
			WHERE cart_order_delivered_tb.message = ?
			AND cart_order_delivered_tb.uId = ?
			AND cart_order_delivered_tb.pId = producttb.pId
		");
		
		$stmt->bind_param('ssi',$mes1,$mes,$id);
		$stmt->execute();
		
		// query all order
		$stmt = $conn->prepare("
			SELECT * FROM cart_order_delivered_tb,producttb 
			WHERE cart_order_delivered_tb.c_o_d_date = NOW()
			AND cart_order_delivered_tb.pId = producttb.pId
			ORDER BY cart_order_delivered_tb.c_o_d_date DESC
		");

		$stmt->execute();
		$result = $stmt->get_result();
	 }
?>

</div>
     
      <div class="row justify-content-center">
     
        <table class="table table-bordered table-hover">
          
     	   <thead>
        	  
        	  <tr class="text-center">
            	
            	<th scope="col">Name of Product Ordered</th>
            
            	<th scope="col">Quantity of Item Ordered</th>
           		
           		<th scope="col">Amount of Item Ordered</th>
            	
            	<th scope="col">Total Price Ordered</th>
            	
            	<th scope="col">Date and Time of Item Ordered</th>
          	
          		</tr>
      
      		</thead>
      
      <tbody>
		<form action="" method="post">
			
			<?php	while($row = $result->fetch_assoc()):?>
				
				<tr>
			
					<td><?=$row['i_Name']?></td>
						
					<td class="text-center"> <?=$row['qty'] ?> </td>
					
					<td>

						<span class="float-right">
							
							₱ <?= number_format($row['total_price'],2)?>
								
						</span>
					</td>
				
					<td>
					
						<span class="float-right">

							₱ <?= number_format($row['total_price'],2) ?>
							
						</span>
					</td>
				
					<td class="text-center"><?=$row['c_o_d_date'] ?></td>
				
						<input type="hidden" name="qty" value="<?=$row['qty']?>">
				
					<?php $grand_total += $row['total_price']; ?>
			
				</tr>
			
			<?php endwhile ?>
				
				<tr>
					
					<td></td>
					
					<td></td>
					<!-- trigger if set total price -->
					<?php if ($grand_total > 0): ?>	
			
					<td>

					 	<b class="float-right">Sum Total :</b> 

					</td>
			
					<td> 
						
						<b class="float-right">
						 	
						 	₱<?=number_format($grand_total,2)?>
					
						 </b>
					
					</td>

					<?php endif ?>

					<td></td>

				</tr>

			</form>

		</tbody>

	</table>

</div>

		<a class="btn btn-primary float-right mr-2" href="plor2.php">Go to Order History</a>

	</div>

</body>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</html>