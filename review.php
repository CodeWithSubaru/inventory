<?php
require_once 'control.php';

// if set email
if (!isset($_SESSION['ses_Email'])) {
	header('location: index.php');
	exit();
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="UTF-8">

	<title>Reviews - Lazaro Gas Delivery</title>

	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta name="HandheldFriendly" content="true">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- fav icon -->
	<link rel="fav icon" href="upload/fav.png">

	<!-- custom style -->
	<link rel="stylesheet" href="css/style_Box1.css">

</head>

<body>
	<?php include 'menu.php'; ?>

	<!-- starts here -->
	<div class="container">

		<div id="com">

			<div style="text-align: center;">

				<div style="background-image: url('upload/bg.jpg');">

					<h3 style="display:inline-block;margin: 20px auto;font-size: 1.4em;box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16),0 2px 10px 0 rgba(0, 0, 0, 0.32);" class="badge badge-danger">Feedbacks and Suggestion</h3>

				</div>

				<br>

				<div>
					<h5>We would like to hear your Feedbacks and Suggestions!</h5>
				</div>

				<hr>

			</div>


			<div id='comment'>

				<?php

				$sql = ('SELECT userstb.u_First,userstb.u_Last,messagetb.message,messagetb.m_date FROM userstb,messagetb WHERE userstb.uId=messagetb.uId ORDER BY messagetb.m_Id ASC');

				$result = $conn->query($sql);

				if ($result->num_rows > 0) {

					while ($row = $result->fetch_assoc()) {
						echo '<p>';
						echo $row['u_First'];
						echo "  ";
						echo $row['u_Last'];
						echo '<br>';
						echo $row['message'];
						echo '<span class="float-lg-right">';
						echo $row['m_date'];
						echo '</span>';
						echo '</p>';
						echo '<hr>';
					}
				} else {
					echo 'There are no Comments';
				}
				?>
			</div>
		</div>
		<br>
		<div class='wrapper'>

			<div class="box2">

				<h3 class="badge badge-success" style="font-size: 1.2em;font-family: arial;">Comment Down Below!</h3>

				<form class="form-submit" method="post">

					<textarea cols="114" class="commen" rows="5"></textarea>
					<div>

						<button type="reset" class="btn btn-danger float-md-right" style="margin-left: 8px;">Clear</button>

						<button id='btn2' class="btn btn-primary float-md-right">Submit</button>

					</div>

				</form>

			</div>

		</div>

	</div>

	<script>
		// is feature
		$(document).ready(function() {
			$("#btn2").click(function(e) {
				e.preventDefault();
				var $form = $(this).closest(".form-submit");
				var rev = $form.find(".commen").val();
				if (!rev == "") {
					$.ajax({
						url: 'comment_Sec.php',
						method: 'post',
						data: {
							rev: rev
						},
						success: function(response) {
							$("#message").html(response);
							load_comment();
						}
					});
				} else {
					$("#message").html(response);
				}
			});

			function load_comment() {
				$.ajax({
					url: 'comment_Sec.php',
					method: 'get',
					data: {
						rev: "rev"
					},
					success: function(response) {
						$("#comment").html(response);
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
</body>

</html>