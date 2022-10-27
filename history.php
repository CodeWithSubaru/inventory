<?php require_once "control.php"; ?>

<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="UTF-8">
	
	<title>History - Lazaro Gas Delivery</title>
	  <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	
	<!-- fav icon -->
	<link rel="fav icon" href="upload/fav.png">

</head>

<body>
	<?php
		include "menu.php";
	?>
	<!-- starts here -->
	<div class="container">
      
      <h1>Deleted</h1>
      
      <div class="row justify-content-center">
      
        <table class="table">
          
        <thead>
          
          <tr>
          	
          	<th scope="col">Email</th>
            
            <th scope="col">Product Name</th>
            
            <th scope="col">Date</th>
            
            <th scope="col">Action</th>
          
          </tr>
      
      </thead>
      <tbody>
	<?php

		$x = 'de';
		$sql = $conn->prepare("SELECT * FROM userstb,cart_order_tb WHERE cart_order_tb.message = ? AND cart_order_tb.id = userstb.id");
		$sql->bind_param('s',$x);
		$sql->execute();
		$result = $sql->get_result();
			while ($row = $result->fetch_assoc()): 
	?>
	 <tr>
	 	
	 	<td><?=$row['u_Email']?></td>
        
        <td>
         
          <?= $row['p_name'] ?>
        
        </td>
        
        <td>
			
			<?= $row['c_o_date'] ?>
        
        </td>
        
        <td>Removed to his/her Cart</td>
     
     </tr>	
	
	<?php endwhile ?>
 
 </tbody>

</table>

</div>

</div>

</body>

</html>