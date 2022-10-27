<?php
require_once "control.php";
// if not set email
if (!isset($_SESSION['ses_Email'])) {
}
// if set email
if (isset($_SESSION['ses_Email'])) {
	if ($_SESSION['ses_Type'] == 9) {
		header('location: activationad.php');
		exit();
	}
	if ($_SESSION['ses_Type'] < 9) {
		if ($_SESSION['ses_Status'] == 0) {
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

	<title>Sign Up - Lazaro Delivery Gas</title>

	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta name="HandheldFriendly" content="true">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- fav icon -->
	<link rel="fav icon" href="upload/fav.png">

	<!-- custom style -->
	<link rel="stylesheet" href="css/style2.css">

</head>

<body>
	<!-- starts here -->
	<div class="container">

		<div class="form-row">

			<div class="col-md-8 form-div">

				<form action="signup.php" method="post" enctype="multipart/form-data">

					<h3 class="text-center">Register</h3>

					<hr>

					<?php if (count($errors) > 0) : ?>

						<div class="alert alert-danger">

							<?php foreach ($errors as $error) : ?>

								<li><?php echo " $error "; ?></li>

							<?php endforeach; ?>

						</div>

					<?php endif; ?>

					<div class="form-group">

						<label for="fir">First Name</label>
						<?php if (isset($_POST['fir'])) { ?>
							<input type="text" name="fir" class="form-control form-control-lg" value="<?= $_POST['fir'] ?>" placeholder="(ex. John Ryan)">
						<?php } else { ?>
							<input type="text" name="fir" class="form-control form-control-lg" placeholder="(ex. John Ryan)">
						<?php } ?>
					</div>

					<div class="form-group">

						<label for="las">Last Name</label>
						<?php if (isset($_POST['las'])) { ?>
							<input type="text" name="fir" class="form-control form-control-lg" value="<?= $_POST['las'] ?>" placeholder="(ex. Doe)">
						<?php	} else { ?>
							<input type="text" name="las" class="form-control form-control form-control-lg" placeholder="(ex. Doe)">
						<?php } ?>
					</div>


					<br>

					<hr style="width:400px;">

					<br>

					<!----Present Address ----->
					<h3>Present Address</h3>

					<div class="form-row">

						<div class="col-md-12">

							<label for="house">House/Bldg No.</label>
							<?php if (isset($_POST['house'])) { ?>
								<input type="text" class="form-control form-control-lg" name="house" value="<?= $_POST['house'] ?>" placeholder="(ex. 23)">
							<?php } else { ?>
								<input type="text" class="form-control form-control-lg" name="house" placeholder="(ex. 23)">
							<?php } ?>
						</div>

						<!----------Street---------->

						<div class="col-md-12">

							<label for="street">Street</label>
							<?php if (isset($_POST['street'])) { ?>
								<input type="text" class="form-control form-control-lg" name="street" value="<?= $_POST['street'] ?>" placeholder="(ex. 23)">
							<?php } else { ?>
								<input type="text" class="form-control form-control-lg" name="street" placeholder="(ex.San Luis)">
							<?php } ?>
						</div>
					</div>
					<!----------Baranggay---------->

					<div class="form-group">

						<label for="bar">Baranggay</label>

						<select class="custom-select custom-select-lg" name="bar">

							<option value="">- - Baranggay - -</option>

							<option value="Hulo">Hulo</option>

							<option value="Lawa">Lawa</option>

							<option value="Hulo">Paco</option>


							<option value="San Pascual">San Pascual</option>

							<option value="Tawiran">Tawiran</option>

						</select>

					</div>

					<!----------Town---------->
					<div class="form-group">

						<label for="town">Town</label>

						<input type="text" class="form-control form-control-lg" name="town" value="Obando" readonly>

					</div>
					<!----------Province---------->

					<div class="form-group">

						<label for="prov">Province</label>

						<input type="text" class="form-control form-control-lg" name="prov" value="Bulacan" readonly> <br>

					</div>

					<!----------Mobile Number---------->
					<div class="form-group">

						<label for="num">Mobile Number</label>
						<?php if (isset($_POST['las'])) { ?>
							<input type="text" name="fir" class="form-control form-control-lg" value="<?= $_POST['las'] ?>">
						<?php	} else { ?>
							<input type="text" name="num" class="form-control form-control-lg" aria-describedby="numHelp">
						<?php } ?>
						<small id="numHelp" class="text-muted">
							Must be 11 digits only.

						</small>

					</div>

					<br>

					<hr style="width: 400px;">

					<br>

					<div class="form-group">

						<label for="email">Email</label>
						<?php if (isset($_POST['email'])) { ?>
							<input type="text" name="email" class="form-control form-control-lg" placeholder="johndoe50@gmail.com" value="<?= $_POST['email'] ?>">
						<?php	} else { ?>
							<input type="email" name="email" class="form-control form-control-lg" placeholder="johndoe50@gmail.com">
						<?php } ?>
					</div>

					<div class="form-group">

						<label for="password">Password</label>
						<input type="password" name="password" class="form-control" aria-describedby="passwordHelpInline">
						<small id="passwordHelpInline" class="text-muted">
							Password must have 6 to 20 characters which contain at least one numeric digit, one uppercase and one lowercase letter.

						</small>

					</div>

					<div class="form-group">

						<label for="passwordConf">Confirm Password</label>

						<input type="password" name="passwordConf" class="form-control form-control-lg">

					</div>

					<div class="form-group">

						<button type="submit" name="signup-btn" class="btn btn-primary btn-block btn-lg">Sign Up</button>

					</div>

					<hr>

					<p class="text-center">Already a Member? <a href="index.php">Sign In</a></p>

				</form>

			</div>

		</div>

	</div>

</body>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</html>