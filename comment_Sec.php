<?php

require_once 'control.php';
// if trigger submit
if (isset($_POST['rev'])) {
	
	$id = $_SESSION['ses_Id'];
	
	$rev = $_POST['rev'];
		
		$query = $conn->prepare("INSERT INTO messagetb(id,message)VALUES(?,?)");
		
		$query->bind_param("is",$id,$rev);
		
		$query->execute();
}
// selecting all message
if (isset($_GET['rev']) && isset($_GET['rev']) == 'rev'){
	$id = $_SESSION['ses_Id'];
	
	$stmt = "SELECT userstb.u_First,userstb.u_Last,messagetb.message,messagetb.m_date FROM userstb,messagetb WHERE userstb.id = messagetb.id ORDER BY messagetb.m_Id ASC";
	
	$result = $conn->query($stmt);
	// if there is result
	if($result->num_rows > 0){
		while ($row = $result->fetch_assoc()) {
			echo '<p>';
			echo $row['u_First'];
			echo $row['u_Last'];
			echo '<br>';
			echo $row['message'];
			echo '<span class="float-lg-right">';
			echo $row['m_date'];
			echo '</span>';
			echo '<hr>';
			echo '</p>';
		}
	} else {
		
		echo 'There are no Comments';
	
	}
	// if id is not null
	if (!$id == "") {

		echo '<div class="alert alert-success alert-dismissible mt-2"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Comment has been Added</strong></div>';
	
	} else {
		
		echo '<div class="alert alert-success alert-dismissible mt-2"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Comment is Required</strong></div>';
	}

}
	
?>