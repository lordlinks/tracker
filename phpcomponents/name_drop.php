<?php
include "SQLconnect.php";
include "SQLdisconnect.php";

function names(){
	$conn = connect();
	$stmt = $conn->prepare("SELECT idpeople, name FROM people");
	$stmt->execute();
	echo "<option value='0'>Slim Shady</option>";
	foreach ($stmt as $row){
		echo "<option value=$row[idpeople]>$row[name]</option>";
	}
	close($conn);
}

function shops(){
	$conn = connect();
	$stmt = $conn->prepare("SELECT idstore, storename FROM store");
	$stmt->execute();
	echo "<option value='0'>The pile</option>";
	foreach ($stmt as $row){
		echo "<option value=$row[idstore]>$row[storename]</option>";
	}
	close($conn);
}

