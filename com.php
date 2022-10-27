/*	echo'
		';*/
			<div style="text-align: center;">
				<div style="background-image: url('upload/bg.jpg');">
				<h3 style="display:inline-block;margin: 20px auto;font-size: 1.4em;box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16),0 2px 10px 0 rgba(0, 0, 0, 0.32);" class="badge badge-danger">Reviews About Our Services</h3>
				</div>
				<hr>
			</div>
<?php 
/*var commentCount = 2;
			$("#btn1").click(function(){
				commentCount = commentCount + 2;
				$("#com").load('com.php',{
					commentNewCount: commentCount
				});
			});*/
		require_once 'control.php';

				$sql = 'SELECT userstb.u_First,userstb.u_Last,messagetb.message FROM userstb,messagetb WHERE userstb.u_Type < 9 AND userstb.id=messagetb.id ORDER BY userstb.id DESC';
				
				$query = $conn->query($sql);

				if($query->num_rows > 0){
					while ($row = $query->fetch_assoc()) {
						echo '<p>';
						echo $row['u_First'];
						echo $row['u_Last'];
						echo '<br>';
						echo $row['message'];
						echo '<hr>';
						echo '</p>';
					}
				} else {
					echo 'There are no Comments';
				}







/*

		$rev = $_POST['rev'];
		$id = $_SESSION['id']; 
		$sql = "INSERT messagetb SET (id,message) VALUES ('$id','$rev')";
		$sql2 = "SELECT * FROM messagetb ORDER BY m_Id DESC";
		$result =$conn->query($sql2);
if ($row = $result->fetch_assoc() === true){

	}
}*/
			?>