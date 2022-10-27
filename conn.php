<?php

$DB_Host = "localhost";

$DB_User = "root";

$DB_Name = "inventory_old";

$DB_Pass = "";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Create connection
$conn = new mysqli($DB_Host, $DB_User, $DB_Pass, $DB_Name);
// Check connection
if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
}
