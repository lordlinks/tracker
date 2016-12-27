<?php
include_once "SQLconnect.php";
include_once "SQLdisconnect.php";

try{
	$name = $_GET["name"];
}
catch(Exception $e) {
	echo 'Message: ' . $e->getMessage();
}
$conn = connect();
$who_paid = [
	1 => "dougpaid",
	2 => "garethpaid",
	3 => "sarahpaid"
];
$stmt = $conn->prepare("UPDATE paid
				SET $who_paid[$name] = 1;");
$stmt->execute();
close($conn);