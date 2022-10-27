<?php
session_start();

//logout
if(session_destroy()) {
	header("Location: index.php");
}
?>