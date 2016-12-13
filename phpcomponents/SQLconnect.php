<?php
function connect(){
	$host = "localhost";
	$user = "root";
	$pass = "";
	$dbname = "receipt_tracker";
	try{
		$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e) {
		echo "connection fail: " . $e->getMessage();
	}
	return $conn;
}
?>