<?php
	require_once 'control.php';
	// if not set email
	if (!isset($_SESSION['ses_Email'])) {
	 	header('location:index.php');
	 	exit();
	 }
	 // if set email
	if (isset($_SESSION['ses_Email'])){
		
		if ($_SESSION['ses_Type'] == 9){
			header('location:activationad.php');
			exit();
		}
		if ($_SESSION['ses_Type'] < 9 ) {
			
			if ($_SESSION['ses_Status'] == 1) {
				header('location: index.php');
				exit();
			}
		}
	}
session_destroy();
?>
<!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="UTF-8">
	<!-- title -->
	<title>Deleted - Lazaro Delivery Gas</title>
	
	<!-- fav icon -->
	<link rel="fav icon" href="upload/fav.png">

</head>

<body>
	
	<h1>Sorry, your Account was Deleted</h1>
	
	<p>Reason(s):</p>
	
	<ul>
		
		<li>Inappropriate use of the app</li>
	
	</ul>
		Go Back to <a href="index.php">Login Page </a>
</body>

</html>