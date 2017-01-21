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
$stmt = $conn->prepare("SELECT * FROM cur_run");
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stg = 0;
$std = 0;
$gts = 0;
$gtd = 0;
$dts = 0;
$dtg = 0;
if ($stmt->rowcount()>0) {
	foreach ($results as $row){
		$stg = $row['sarah_to_gareth'];
		$std = $row['sarah_to_doug'];
		$gts = $row['gareth_to_sarah'];
		$gtd = $row['gareth_to_doug'];
		$dts = $row['doug_to_sarah'];
		$dtg = $row['doug_to_gareth'];
	}
	if($name == 1){
		$dts = 0;
		$dtg = 0;
	}
	elseif ($name == 2){
		$gts = 0;
		$gtd = 0;
	}
	elseif ($name == 3){
		$stg = 0;
		$std = 0;
	}
};
$stmt = $conn->prepare("INSERT INTO running_total
	(sarah_to_gareth, sarah_to_doug, gareth_to_sarah, gareth_to_doug, doug_to_sarah, doug_to_gareth)
	VALUES (:STG, :STD, :GTS, :GTD, :DTS, :DTG)");
$stmt->bindParam(':STG', $stg, PDO::PARAM_STR);
$stmt->bindParam(':STD', $std, PDO::PARAM_STR);
$stmt->bindParam(':GTS', $gts, PDO::PARAM_STR);
$stmt->bindParam(':GTD', $gtd, PDO::PARAM_STR);
$stmt->bindParam(':DTS', $dts, PDO::PARAM_STR);
$stmt->bindParam(':DTG', $dtg, PDO::PARAM_STR);
$stmt->execute();
tableOfKnowing();
close($conn);