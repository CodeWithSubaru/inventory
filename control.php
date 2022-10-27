<?php
session_start();

require 'conn.php';

$errors = array();
$email = "";


// if user click on sign up
if (isset($_POST['signup-btn'])) {
	$fir = $_POST['fir'];
	$las = $_POST['las'];
	$house = $_POST['house'];
	$street = $_POST['street'];
	$bar = $_POST['bar'];
	$town = $_POST['town'];
	$prov = $_POST['prov'];
	$num = $_POST['num'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$passwordConf = $_POST['passwordConf'];
	// validation
	if (!preg_match("/^[a-zA-Z ]*$/", $fir)) {
		$errors['fir'] = "Only letters and white space allowed at your first name";
	}
	if (!preg_match("/^[a-zA-Z -]*$/", $las)) {
		$errors['las'] = "Only letters and white space allowed at your last name";
	}

	if (empty($fir)) {
		$errors['fir'] = "First Name required";
	}
	if (empty($las)) {
		$errors['las'] = "Last Name required";
	}
	if (empty($house)) {
		$errors['house'] = "House/Bldg No. required";
	}
	if (empty($bar)) {
		$errors['bar'] = "Baranggay required";
	}
	if (empty($num)) {
		$errors['num'] = "Mobile Number required";
	}
	if (!empty($_POST['num'])) {
		if (!preg_match(("/^[0-9]{11}$/"), $num)) {
			$errors['num'] = "Mobile Number must have 11 digits only";
		}
	}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = "Email Address is invalid";
	}
	if (empty($email)) {
		$errors['email'] = "Email required";
	}

	$sql = "SELECT * FROM userstb WHERE u_Email = '$email' OR u_Num= '$num'";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		if ($num == $row['u_Num']) {
			$errors['num'] = "Number already exists";
		}
		if ($email == $row['u_Email']) {
			$errors['email'] = "Email already exists";
		}
	}
	if (empty($password)) {
		$errors['password'] = "Password required";
	}
	if (!empty($password)) {
		if (!empty($passwordConf)) {
			if ($password !== $passwordConf) {
				$errors['password'] = "Two password do not match";
			}
		}
	}
	if (!empty($_POST['password'])) {
		if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/", $password)) {
			$errors['password'] = "Password must have 6 to 20 characters which contain at least one numeric digit, one uppercase and one lowercase letter";
		}
	}

	//if No error(s)

	if (count($errors) === 0) {
		$add1 = $house . " " . $street . " St. " . $bar . ", " . $town . ", " . $prov;
		$u_Type = 3;

		try {
			$read = $conn->prepare("SELECT uId FROM userstb WHERE u_Email = ?");
			$read->bind_param("s", $email);
			$read->execute();
			$read->store_result();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		if ($read->num_rows == 0) {
			$password1 = md5($password);
			$fir1 = ucwords($fir);
			$las1 = ucwords($las);
			$add = ucwords($add1);
			$x = 1;
			$mes = 'Member';

			$new = $conn->prepare("INSERT INTO userstb (u_First, u_Last, u_Email, u_Pass, u_Type, u_Add, u_Num,status,u_Message) VALUES (?,?,?,?,?,?,?,?,?)");
			$new->bind_param("ssssissis", $fir1, $las1, $email, $password1, $u_Type, $add, $num, $x, $mes);
			$new->execute();
			if ($conn->query($new) === FALSE) {
				echo "Error: " . $sql . "<br>" . $conn->error;
			} else {
				//login user
				// set flash message

				$_SESSION['message'] = "You've Been Succesfully Registered";

				$_SESSION['msg_type'] = "Success:";

				header('location: index.php');
				exit();
			}
		}
	}
}

// Login
if (isset($_POST['login-btn'])) {
	$email = $_POST['ema'];
	$password = $_POST['pas'];

	$password1 = md5($password);

	$sql1 = "SELECT * FROM userstb WHERE u_Email='$email' AND u_Pass='$password1'";
	$result = $conn->query($sql1);

	$row = $result->fetch_assoc();

	if (empty($email)) {
		$errors['ema'] = "Email required";
	}

	if (empty($password)) {
		$errors['pas'] = "Password required";
	}

	$u_Email = $row['u_Email'] ?? '';
	$u_Pass = $row['u_Pass'] ?? '';

	if (isset($email) && isset($password)) {
		if ($email != $u_Email && $password1 != $u_Pass) {
			$errors['ema'] = "Wrong Credentials";
		}
	}

	// Enter various page base on your role
	if (count($errors) === 0) {
		$sql = "SELECT * FROM userstb WHERE u_Email='$email' AND u_Pass='$password1'";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {


			$row = $result->fetch_assoc();
			$_SESSION['ses_Email'] = $row['u_Email'];
			$_SESSION['ses_Pass'] = $row['u_Pass'];
			$_SESSION['ses_Type'] = $row['u_Type'];
			$_SESSION['ses_Status'] = $row['status'];


			if ($_SESSION['ses_Type'] == 9) {
				header('location: activationad.php');
				exit();
			}
			if ($_SESSION['ses_Type'] == 8) {
				header('location: orders.php');
				exit();
			}
			if ($_SESSION['ses_Type'] < 4) {
				header('location: index_1.php');
				exit();
			}
			if ($_SESSION['ses_Status'] == 0) {
				header('location: deleted.php');
				exit();
			}
		}
	}
}






// Update Profile
if (isset($_POST['upd'])) {
	$ema = $_SESSION['ses_Email'];
	$fir_1 = $_POST['first'];
	$las_1 = $_POST['last'];
	$num_1 = $_POST['number'];
	$house = $_POST['house'];
	$street = $_POST['street'];
	$bar = $_POST['bar'];
	$town = $_POST['town'];
	$prov = $_POST['prov'];

	if (empty($fir_1)) {
		$errors['first'] = "First Name required";
	}
	if (empty($las_1)) {
		$errors['last'] = "Last Name required";
	}
	if (empty($house)) {
		$errors['house'] = "House/Bldg No. required";
	}
	if (empty($bar)) {
		$errors['bar'] = "Baranggay required";
	}
	if (empty($num_1)) {
		$errors['number'] = "Mobile Number required";
	}
	if (!preg_match("/^[a-zA-Z ]*$/", $fir_1)) {
		$errors['first'] = "Only letters and white space allowed at your first name";
	}
	if (!preg_match("/^[a-zA-Z .-]*$/", $las_1)) {
		$errors['last'] = "Only letters and white space allowed at your last name";
	}
	if (!empty($_POST['number'])) {

		if (!preg_match(("/^[0-9]{11}$/"), $num_1)) {
			$errors['number'] = "Mobile Number must have 11 digits only";
		}
	}
	if (count($errors) === 0) {
		$fir1 = ucwords($fir_1);
		$las1 = ucwords($las_1);
		$add1 = $house . " " . $street . " St. " . $bar . ", " . $town . ", " . $prov;
		$sql = "UPDATE userstb SET u_First='$fir1',u_Last='$las1', u_Num='$num_1', u_Add = '$add1' WHERE u_Email='$ema'";

		$result = $conn->query($sql);
		$_SESSION['message'] = "Updated Successfully";
		header('location: updateprof.php');
		exit();
	}
}

//Change Password
$error = array();
$message = array();
if (isset($_POST['change'])) {
	$ema = $_SESSION['ses_Email'];
	$pas = $_SESSION['ses_Pass'];
	$old = $_POST['oldpas'];
	$new = $_POST['newpas'];
	$con = $_POST['conpas'];

	if (empty($old)) {
		$error['oldpas'] = "Current Password Required";
	}
	if (empty($new)) {
		$error['newpas'] = "New Password Required";
	}
	if (empty($con)) {
		$error['conpas'] = "Confirm Password Required";
	}

	$pas1 = md5($old);
	$pas2 = md5($new);

	$sql = "SELECT * FROM userstb WHERE u_Email='$ema' AND u_Pass='$pas'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

	if (!empty($old)) {
		if ($pas1 != $row['u_Pass']) {
			$error['oldpas'] = "Wrong Current Password";
		}
	}
	if (!empty($new)) {
		if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/", $new)) {
			$error['newpas'] = "Password must have 6 to 20 characters which contain at least one numeric digit, one uppercase and one lowercase letter";
		}
	}

	if (!empty($new)) {
		if ($pas2 == $row['u_Pass']) {
			$error['newpas'] = "Try different Password";
		}
		if (!empty($con)) {
			if ($new != $con) {
				$error['conpas'] = "New and Conf doesn't match";
			}
		}
	}

	if (count($error) === 0) {
		$pas2 = md5($new);
		$sql = "UPDATE userstb SET u_Pass = '$pas2' WHERE u_Email = '$ema' AND u_Pass = '$pas';";

		if ($conn->query($sql) === TRUE) {
			$message['conpas'] = "Password Updated Successfully";
		}
	}
}

// Account Deletion
if (isset($_GET['del'])) {
	$id = $_GET['del'];

	$x = 0;

	$sql = "UPDATE userstb SET status='$x'  WHERE uId='$id'";
	if ($conn->query($sql) === TRUE) {
		$_del = true;
		$_SESSION['message'] = "The Account was Deleted";
		$_SESSION['msg_type'] = "Success:";
		header("location: activationad.php");
		exit();
	} else {
		$_SESSION['msg_type'] = "Error updating record: " . $conn->error;
	}
}

// Restoration of Account
if (isset($_GET['res'])) {
	$id = $_GET['res'];

	$x = 1;

	$sql = "UPDATE userstb SET status='$x'  WHERE uId='$id'";
	if ($conn->query($sql) === TRUE) {
		$_del = true;
		$_SESSION['message'] = "The Account was Restored";
		$_SESSION['msg_type'] = "Success:";
		header("location: activationad.php");
		exit();
	} else {
		$_SESSION['msg_type'] = "Error updating record: " . $conn->error;
	}
}


// Cancel activation
if (isset($_POST['cancel'])) {
	$update = false;
	header("location: activation.php");
	exit();
}

// Add to Cart
if (isset($_POST['pId'])) {
	$uId = $_SESSION['ses_Id'];
	$pId = $_POST['pId'];
	$x = 'c';
	$y = "cart";
	$stmt = $conn->prepare("
		SELECT * FROM cart_order_delivered_tb,producttb
		WHERE cart_order_delivered_tb.pId = ?
		AND cart_order_delivered_tb.message = ?
		AND cart_order_delivered_tb.pId = producttb.pId
	");
	$stmt->bind_param("is", $pId, $x);
	$stmt->execute();
	$result = $stmt->get_result();
	$r = $result->fetch_assoc();

	$mes = $r['message'];
	$c_o_d_Id = $r['c_o_d_Id'];
	$qty2 = $r['qty'];
	$Mes = $r['Mes'];

	//if cart

	if (isset($mes) && $mes == $x) {
		if ($qty2 >= $Mes) {
			echo '
			<div class="alert alert-success alert-dismissible mt-2"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Item already added to your cart!</strong></div>';
		} else {
			$sel = $conn->prepare("SELECT i_Amount FROM producttb WHERE pId = ?");
			$sel->bind_param("i", $pId);
			$sel->execute();
			$result = $sel->get_result();
			$row = $result->fetch_assoc();
			$qty1 = 1;
			$i_Amount = $row['i_Amount'];
			$qty1 = $qty1 + $qty2;
			$total_price2 = $qty1 * $i_Amount;
			$ins = $conn->prepare("UPDATE cart_order_delivered_tb SET qty = ?, total_price = ? WHERE pId = ?");
			$ins->bind_param("iis", $qty1, $total_price2, $pId);
			$ins->execute();

			// if item already added 
			echo '
			<div class="alert alert-success alert-dismissible mt-2"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Item already added to your cart!</strong></div>';
		}
	} else {
		$sel = $conn->prepare("SELECT i_Amount FROM producttb WHERE pId = ?");
		$sel->bind_param("i", $pId);
		$sel->execute();
		$result = $sel->get_result();
		$row = $result->fetch_assoc();
		$qty = 1;
		$i_Amount1 = $row['i_Amount'];
		// if not set into cart
		$query = $conn->prepare("INSERT INTO cart_order_delivered_tb(uId,pId,qty,total_price,message,mes_Des)VALUES(?,?,?,?,?,?)");
		$query->bind_param("iisiss", $uId, $pId, $qty, $i_Amount1, $x, $y);
		$query->execute();

		echo '
		<div class="alert alert-success alert-dismissible mt-2"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Item added to your cart!</strong></div>';
	}
}

// load number of cart
if (isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item') {
	$id = $_SESSION['ses_Id'];
	$x = 'c';
	$stmt = $conn->prepare("SELECT * FROM cart_order_delivered_tb WHERE cart_order_delivered_tb.message='$x' AND cart_order_delivered_tb.uId = '$id'");
	$stmt->execute();
	$stmt->store_result();
	$rows = $stmt->num_rows;

	echo $rows;
}

// load number of cart
if (isset($_GET['user']) && isset($_GET['user']) == 'fa-user') {
	$id = $_SESSION['ses_Id'];
	$x = 'c';
	$p = 'p';
	$stmt = $conn->prepare("SELECT * FROM cart_order_delivered_tb WHERE cart_order_delivered_tb.message='$x' AND cart_order_delivered_tb.uId = '$id'");
	$stmt->execute();
	$stmt->store_result();
	$rows = $stmt->num_rows;

	echo $rows;
}
// load number notif
if (isset($_GET['bell']) && isset($_GET['bell']) == 'fa-bell') {
	$id = $_SESSION['ses_Id'];
	$x = "co";
	$stmt = $conn->prepare("SELECT * from cart_order_delivered_tb,producttb WHERE cart_order_delivered_tb.message = '$x' AND producttb.pId = cart_order_delivered_tb.pId AND cart_order_delivered_tb.uId = '$id';");
	$stmt->execute();
	$stmt->store_result();
	$rows = $stmt->num_rows;

	echo $rows;
}

// if trigger remove
if (isset($_GET['rem'])) {
	$id_rem = $_GET['rem'];
	$x1 = 'd';
	$x2 = 'deleted';
	$y2 = 'c';
	$delete = $conn->prepare("UPDATE cart_order_delivered_tb SET message = ?, mes_Des = ? WHERE c_o_d_Id=? AND message = ?");
	$delete->bind_param('ssis', $x1, $x2, $id_rem, $y2);
	$delete->execute();

	if ($delete->affected_rows > 0) {
		$_SESSION['message'] = "<strong>Item was Successfully Removed from the cart</strong>";
		$_SESSION['msg_type'] = "Success:";
		header('location:cart1.php');
		exit();
	} else {

		$_SESSION['message'] = "Item was unsuccessfully Removed from the cart";
		$_SESSION['msg_type'] = "There was an error:";
		header('location:cart1.php');
	}
}

//clear all cart 
if (isset($_GET['clear'])) {
	$id = $_GET['clear'];
	$y = 'd';
	$y1 = 'deleted';
	$x = 'c';
	$delete = $conn->prepare("UPDATE cart_order_delivered_tb SET message = ?, mes_Des = ? WHERE uId = ? AND message = ?");
	$delete->bind_param('ssis', $y, $y1, $id, $x);
	$delete->execute();

	if ($delete->affected_rows > 0) {
		$_SESSION['message'] = "All Items was Successfully Removed from the cart";
		$_SESSION['msg_type'] = "Success:";

		header('location:cart1.php');
		exit();
	}
}
// auto reload of quantity total amount and grand total
if (isset($_POST['qty'])) {
	$qty = $_POST['qty'];
	$pId = $_POST['pid'];
	$pamount = $_POST['p_amount'];
	$tpamount = $qty * $pamount;

	$upd = $conn->prepare("UPDATE cart_order_delivered_tb SET qty=?, total_price = ? WHERE c_o_d_Id=?");
	$upd->bind_param("isi", $qty, $tpamount, $pId);
	$upd->execute();
}

/*cancel order*/

if (isset($_GET['cancel1'])) {
	$id = $_GET['cancel1'];
	$x = 'x';
	$x1 = "cancel";
	$sel = $conn->prepare('UPDATE cart_order_delivered_tb SET message = ?, mes_Des = ? WHERE c_o_d_Id = ?');
	$sel->bind_param('ssi', $x, $x1, $id);
	if ($sel->execute()) {
		echo '
		<div class="alert alert-success alert-dismissible mt-2"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>The Item was Successfully Cancelled!</strong></div>';
		header('location:orders.php');
		exit();
	}
}

/*cancel order*/

if (isset($_GET['cancel2'])) {
	$id = $_GET['cancel2'];
	$x = 'x';
	$x1 = 'cancel';
	$sel = $conn->prepare('UPDATE cart_order_delivered_tb SET message = ?, mes_Des = ? WHERE c_o_d_Id = ?');
	$sel->bind_param('ssi', $x, $x1, $id);
	if ($sel->execute()) {
		$succes = '
		<div class="alert alert-success alert-dismissible mt-2"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>The Item was Successfully Cancelled!</strong></div>';
		header('location:plor2.php');
		exit();
	}
}


// delivered
if (isset($_GET['de'])) {
	$id = $_GET['de'];
	$x = 'de';
	$x1 = "delivered";
	$co = "co";
	$sel = $conn->prepare("UPDATE producttb, cart_order_delivered_tb set cart_order_delivered_tb.message = '$x',cart_order_delivered_tb.mes_Des = '$x1',producttb.Mes = (SELECT SUM(producttb.Mes) - (cart_order_delivered_tb.qty) as QTY ) WHERE cart_order_delivered_tb.message = '$co' and cart_order_delivered_tb.c_o_d_Id = '$id' and cart_order_delivered_tb.pId = producttb.pId
		");
	$sel->execute();
	header("location:plor2.php");
	exit();
}
// add quantity of admin
if (isset($_POST['add'])) {

	$id = $_POST['add'];
	$qty = $_POST['qty'];
	$pId = $_POST['pId'];

	$sel = $conn->prepare("UPDATE producttb SET Mes = (SELECT SUM(Mes) + ($qty) as QTY ) WHERE pId = '$pId'
		");
	$sel->execute();

	header("location:products.php");
	exit();
}
// deduct quantity of admin
if (isset($_POST['deduct'])) {

	$id = $_POST['deduct'];
	$qty = $_POST['qty'];
	$pId = $_POST['pId'];

	$sel = $conn->prepare("UPDATE producttb SET Mes = (SELECT SUM(Mes) - ($qty) as QTY ) WHERE pId = '$pId'
		");
	$sel->execute();

	header("location:products.php");
	exit();
}
// confirm orders
if (isset($_GET['co'])) {
	$id = $_GET['co'];
	$x = 'co';
	$x1 = "confirm";
	$p = 'p';
	$id1 = $_SESSION['ses_Id'];
	$sel = $conn->prepare("UPDATE cart_order_delivered_tb SET message = '$x',mes_Des = '$x1' WHERE c_o_d_Id = '$id' AND message = '$p'");
	$sel->execute();

	echo '
				<div class="alert alert-success alert-dismissible mt-2"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Item added to your cart!</strong></div>';
	header('location:orders.php');
	exit();
}

// Turn into admin
if (isset($_GET['admin'])) {
	$id = $_GET['admin'];
	$x = 9;
	$admin = "Admin";
	$sel = $conn->prepare('UPDATE userstb SET u_Type = ? , status = ?, u_Message = ? WHERE uId = ?');
	$sel->bind_param('iiis', $x, $x, $admin, $id);
	if ($sel->execute()) {
		echo '
			<div class="alert alert-success alert-dismissible mt-2"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Item added to your cart!</strong></div>';
		header('location:activationad.php');
		exit();
	}
}
