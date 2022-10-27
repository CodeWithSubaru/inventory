<?php require_once "control.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>AutoComplete Search Using Bootstrap 4, PHP, MySQLi & Ajax</title>
    <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
  <form method="POST">
  Donor's Name <input list="date" class="dt">
  <datalist id="date">
<?php
$x = 'o';
$sql = "SELECT cart_order_tb.c_o_date FROM cart_order_tb WHERE cart_order_tb.message = '$x' ORDER BY c_o_date ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<option value='";
        echo $row['c_o_date'];
        echo "'>";
    }
   
} else {
    echo "0 results";
}

?>
       
    </datalist>   
  <input type="submit" id="search" value="Search">
</form>
<br>


<table width="750px" border="1">
  <tr>
     <th>Name</th>
     <th>Address</th>
     <th>Date</th>
     <th>Amount</th>
     <th>Purpose</th>
  </tr>

<?php


$x = 'o';
$sql = $conn->prepare("SELECT * FROM userstb, cart_order_tb WHERE cart_order_tb.message = ? AND cart_order_tb.id = userstb.id");
$sql->bind_param('s',$x);
$sql->execute();
$result = $sql->get_result();
if ($result->num_rows > 0) {
    
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr id='result'><td>"  . $row["u_First"] . " " . $row["u_Last"];
        echo "</td><td align='center'>" . $row["u_Add"];
        echo "</td><td align='center'>" . $row["c_o_date"];
        echo "</td><td align='right'>" . number_format($row["total_price"],2);
        echo "</td><td align='center'>" . $row["message"];
        echo "</td></tr>";
    }
   
} else {
    echo "<td colspan='5' style='text-align:center;'>0 results</td>";
}
?>

</table>

<br><br><br><br>
<div>Prepared By: <br><br><br>Sam Espino</div>
</body>
  <!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script>
  $(document).ready(function(){
    $("#search").click(function(e){
      e.preventDefault();
      var date = $(".dt").val();
      $.ajax({
        url : 'action.php',
        method : 'post',
        data : {date:'date'},
        success:function(response){
          $("#result").html(response);
        }
      });
    });
  });
</script>
</html>