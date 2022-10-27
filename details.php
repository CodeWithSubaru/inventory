<?php
require_once 'control.php';
if(isset($_POST['submit'])){
    $data = $_POST['search'];
    $x = 'o';
    $sql = "SELECT * FROM userstb,cart_order_tb WHERE cart_order_tb.c_o_date = '$data'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()){ ?>
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
			    	P <?=number_format($row["total_price"] ,2); ?>
			    </td>
			</tr>
		</tbody>
<?php 
  }
}
?>