<?php
require_once "control.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Your Products</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

</head>

<body>
	<?php include "menu.php"; ?>

	<div class="container">

		<div class="alert alert-warning text-center font-weight-bolder text-danger" style="font-size: 1.2em;">Add/Deduct Quantity</div>
		<div class="row mt-2 pb-3">
			<?php
			$sql = $conn->prepare("SELECT * FROM producttb");
			$sql->execute();
			$result = $sql->get_result();
			while ($row = $result->fetch_assoc()) : ?>

				<div class="col-lg-6 col-md-4 col-sm-4">
					<div class="card-deck">
						<div class="card bg-light p-2 border-danger mb-2" style="border: 3px solid red">
							<img src="<?= $row['Image'] ?>" class="card-img-top" style="background-position: center;background-size: cover; object-fit: contain;height: 250px;">
							<div class="card-body p-1">
								<div class="card-title text-center text-dark">
									<form method="POST">
										<div class="mt-2 font-weight-bold">
											Name : <?php echo $row['i_Name']; ?>
										</div>
										<div class="mt-2">
											Quantity:<input type="hidden" name="pId" value="<?= $row['pId']; ?>">
										</div>
										<div class="mt-2">
											<input type="text" size="1" value="<?= $row['Mes'] ?>" readonly>
										</div>
										<div class="mt-2">
											<input type="number" min="1" max="50" class="qty" name="qty" value="1" class="form-control">
										</div>
										<div class="mt-2">
											<input type="submit" value="Add" name="add" class="btn btn-info btn-block">
											<input type="submit" value="Deduct" name="deduct" class="btn btn-danger btn-block">
										</div>
									</form>

								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endwhile ?>
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