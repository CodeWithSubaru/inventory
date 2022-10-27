<?php
require_once "control.php";
// if not set email
if (!isset($_SESSION['ses_Email'])) {
	header('location:index.php');
	exit();
}
// if set email
if (isset($_SESSION['ses_Email'])) {
	if ($_SESSION['ses_Type'] >= 8) {
	}
	if ($_SESSION['ses_Type'] < 8) {
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

	<title>Orders - Lazaro Delivery Gas</title>

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

	<?php include "menu.php"; ?>

	<!-- if there is message -->

	<?php if (isset($_SESSION['message'])) : ?>

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

	<div class="container">
		<?php
		// starts here if message is set
		if (isset($_SESSION['message'])) : ?>

			<div class="alert alert-warning alert-dismissible fade show" role="alert" style="width: 100%;text-align: auto;">

				<?= $_SESSION['msg_type']; ?>

				<?php

				echo $_SESSION['message'];

				unset($_SESSION['message']);
				?>

				<button type="button" class="close" data-dismiss="alert" aria-label="Close">

					<span aria-hidden="true">&times;</span>

				</button>
			</div>

		<?php endif; ?>

		<h1 class="rounded bg-danger d-block text-light text-center" style="margin-top: 20px;">Confirm Order(s) :</h1>

		<div class="row ml-xl-n5 table-hover text-nowrap">

			<table class="table">

				<thead>

					<tr>
						<th scope="col" class="text-center">Name</th>
						<th scope="col">Product Name</th>
						<th scope="col">Quantity</th>
						<th scope="col">Total Price</th>
						<th scope="col" class="text-center">Date/Time</th>
						<th class="text-center">Action</th>

					</tr>

				</thead>
				<?php
				// query date
				$x = 'p';
				$grand_total = 0;
				$sql = $conn->prepare("SELECT * FROM cart_order_delivered_tb,userstb,producttb WHERE cart_order_delivered_tb.message = ? AND cart_order_delivered_tb.uId = userstb.uId AND producttb.pId = cart_order_delivered_tb.pId ORDER BY cart_order_delivered_tb.c_o_d_date DESC");
				$sql->bind_param('s', $x);
				$sql->execute();
				$result = $sql->get_result();
				while ($row = $result->fetch_assoc()) :
				?>

					<tbody>

						<tr>

							<td>
								<?= $row["u_First"]; ?>

								<?php echo " "; ?>

								<?= $row["u_Last"]; ?>
							</td>

							<td class="text-center">
								<?= $row["i_Name"]; ?>
							</td>

							<td class="text-center">
								<?= $row["qty"]; ?>
							</td>

							<td>
								₱ <?= number_format($row["total_price"], 2); ?>
							</td>

							<td>
								<?= date('F j, Y', strtotime($row['c_o_d_date'])); ?>
								<br>
								<?= date('g:i a', strtotime($row['c_o_d_date'])); ?>
							</td>

							<td class="btn-group">
								<a href="control.php?co=<?= $row['c_o_d_Id'] ?>" class="btn btn-sm lead btn-outline-secondary m-sm-1">Confirm</a>
								<a href="control.php?cancel1=<?= $row['c_o_d_Id'] ?>" class="btn btn-sm lead btn-outline-danger m-sm-1">Cancel</a>
		</div>
	</div>
	</div>
	</div>

	</td>

	</tr>

	</tbody>
	<?php
					$grand_total += $row['total_price'];
	?>
<?php endwhile; ?>

<tr>
	<td></td>
	<td></td>
	<?php if ($grand_total > 0) { ?>

		<td>
			<b>Grand Total =</b>
		</td>
		<td><b>₱ <?= number_format($grand_total, 2) ?></b></td>
		<td></td>
	<?php } else { ?>
		<td class="text-center" colspan="2">0 Result</td>
		<td></td>
		<td></td>
		<td></td>
	<?php } ?>
</tr>


</table>

</div>

<!-- starts here -->

<h1 class="rounded bg-danger text-light text-center" style="margin-top: 20px;">Order Report :</h1>

<div class="row justify-content-center table-hover text-nowrap">

	<table class="table">

		<thead>

			<tr>
				<th scope="col" class="text-center">Name</th>
				<th scope="col">Product Name</th>
				<th scope="col">Quantity</th>
				<th scope="col">Total Price</th>
				<th scope="col">Date</th>

			</tr>

		</thead>
		<?php
		// query date
		$x = 'de';
		$sql = $conn->prepare("SELECT * FROM userstb,producttb,cart_order_delivered_tb WHERE cart_order_delivered_tb.message = ? AND cart_order_delivered_tb.uId = userstb.uId AND producttb.pId = cart_order_delivered_tb.pId ORDER BY cart_order_delivered_tb.c_o_d_date DESC");
		$sql->bind_param('s', $x);
		$sql->execute();
		$result = $sql->get_result();
		$grand_total = 0;
		while ($row = $result->fetch_assoc()) :
		?>

			<tbody>

				<tr>

					<td>
						<?= $row["u_First"]; ?>

						<?php echo " "; ?>

						<?= $row["u_Last"]; ?>
					</td>

					<td class="text-center">
						<?= $row["i_Name"]; ?>
					</td>

					<td class="text-center">
						<?= $row["qty"]; ?>
					</td>

					<td>
						₱ <?= number_format($row["total_price"], 2); ?>
					</td>

					<td>
						<?= date('F j, Y', strtotime($row['c_o_d_date'])); ?>
						<br>
						<?= date('g:i a', strtotime($row['c_o_d_date'])); ?>
					</td>

				</tr>

			</tbody>
			<?php
			$grand_total += $row['total_price'];
			?>
		<?php endwhile; ?>

		<tr>
			<td></td>
			<td></td>
			<?php if ($grand_total > 0) { ?>

				<td>
					<b>Grand Total =</b>
				</td>
				<td><b>₱ <?= number_format($grand_total, 2) ?></b></td>
				<td></td>
			<?php } else { ?>
				<td>0 Result</td>
				<td></td>
				<td></td>
			<?php } ?>
		</tr>


	</table>

</div>

<!-- starts here -->

<h1 class="rounded bg-danger text-light text-center" style="margin-top: 20px;">Cancelled Orders :</h1>
<div class="row justify-content-center table-hover text-nowrap">

	<table class="table">

		<thead>

			<tr>
				<th scope="col" class="text-center">Name</th>
				<th scope="col">Product Name</th>
				<th scope="col">Quantity</th>
				<th scope="col">Total Price</th>
				<th scope="col">Date</th>

			</tr>

		</thead>
		<?php
		// query date
		$x = 'x';
		$sql = $conn->prepare("SELECT * FROM userstb,producttb,cart_order_delivered_tb WHERE cart_order_delivered_tb.message = ? AND cart_order_delivered_tb.uId = userstb.uId AND producttb.pId = cart_order_delivered_tb.pId ORDER BY cart_order_delivered_tb.c_o_d_date DESC");
		$sql->bind_param('s', $x);
		$sql->execute();
		$result = $sql->get_result();
		while ($row = $result->fetch_assoc()) :
		?>

			<tbody>

				<tr>

					<td>
						<?= $row["u_First"]; ?>

						<?php echo " "; ?>

						<?= $row["u_Last"]; ?>
					</td>

					<td class="text-center">
						<?= $row["i_Name"]; ?>
					</td>

					<td class="text-center">
						<?= $row["qty"]; ?>
					</td>

					<td>
						₱ <?= number_format($row["total_price"], 2); ?>
					</td>

					<td>
						<?= date('F j, Y', strtotime($row['c_o_d_date'])); ?>
						<br>
						<?= date('g:i a', strtotime($row['c_o_d_date'])); ?>
					</td>

				</tr>

			</tbody>
			<?php
			$grand_total += $row['total_price'];
			?>
		<?php endwhile; ?>

		<tr>
			<td></td>
			<td></td>
			<?php if ($grand_total > 0) { ?>

				<td>
					<b>Grand Total =</b>
				</td>
				<td><b>₱ <?= number_format($grand_total, 2) ?></b></td>
				<td></td>
			<?php } else { ?>
				<td>0 Result</td>
				<td></td>
				<td></td>
			<?php } ?>
		</tr>

	</table>

</div>

</body>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</html>