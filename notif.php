<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Notifications</title>
	
	<!-- fav icon -->
	<link rel="fav-icon" href="img/fav.png">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

</head>
<body>
	<?php include "menu.php"; ?>
	
	<div class="container">
		
		<div>

			<?php 
			$id = $_SESSION['ses_Id'];

			$query = "SELECT * from cart_order_delivered_tb,producttb WHERE cart_order_delivered_tb.message = 'co' AND producttb.pId = cart_order_delivered_tb.pId AND cart_order_delivered_tb.uId = '$id' order by cart_order_delivered_tb.c_o_d_date DESC";
                 $result = $conn->query($query);
                 if($result->num_rows > 0 ){
                 	while($row = $result->fetch_assoc()){
                 		
                 		echo "<a href='plor2.php' style='font-weight:bold'>";
                 		echo $row['i_Name'];
						echo " you've ordered was Confimed!<br></a>";
						echo "<p style='float:right;'>";
						echo date('F j, Y, g:i a',strtotime($row['c_o_d_date']));
						echo "</p>";
						echo "<br>";
						echo "<hr>";
			}
		}
			?>
		</div>

	</div>

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
   load_notif_number();
  function load_notif_number(){
    $.ajax({
      url: 'control.php',
      method: 'get',
      data: {bell:"bell"},
      success:function(response){
        $("#bell").html(response);
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