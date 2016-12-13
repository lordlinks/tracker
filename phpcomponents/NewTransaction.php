<?php
include "runningTotal.php";
include_once "SQLconnect.php";
include_once "SQLdisconnect.php";


try{
	$name = $_GET["name"];
	$shop = $_GET["shop"];
	$price = $_GET["price"];
	$date = $_GET["date"];
}
catch(Exception $e){
	echo 'Message: '.$e->getMessage();
}
$conn = connect();
$stmt = $conn->prepare("INSERT INTO transaction (purchaser, store, date, amount) 
						VALUES (:Name, :Store, :Date, :Amount)");
$stmt->bindParam(':Name', $name, PDO::PARAM_INT);
$stmt->bindParam(':Store', $shop, PDO::PARAM_INT);
$stmt->bindParam(':Date', $date, PDO::PARAM_STR);
$stmt->bindParam(':Amount', $price, PDO::PARAM_STR);
$stmt->execute();
$getLast = $conn->prepare("SELECT idtran
					FROM transaction
					WHERE purchaser=:Name AND store=:Store AND date=:Date AND amount=:Amount
					ORDER BY idtran DESC
					LIMIT 1");
$getLast->bindParam(':Name', $name, PDO::PARAM_INT);
$getLast->bindParam(':Store', $shop, PDO::PARAM_INT);
$getLast->bindParam(':Date', $date, PDO::PARAM_STR);
$getLast->bindParam(':Amount', $price, PDO::PARAM_STR);
$getLast->execute();
$transactionID = $getLast->fetch(PDO::FETCH_ASSOC);
$transactionID = $transactionID['idtran'];
//echo "Transaction id= ". $transactionID['idtran'];
$whoPaid = array(
	'1' => "INSERT INTO paid (transaction, garethpaid, dougpaid, sarahpaid)
								VALUE (:Trans, 0, 1, 0)",
	'2' => "INSERT INTO paid (transaction, garethpaid, dougpaid, sarahpaid)
								VALUE (:Trans, 1, 0, 0)",
	'3' => "INSERT INTO paid (transaction, garethpaid, dougpaid, sarahpaid)
								VALUE (:Trans, 0, 0, 1)"
);
$queryFill = "$whoPaid[$name]";
//echo "<br>";
//echo $queryFill;
$insertPaid = $conn->prepare($queryFill);
$insertPaid->bindParam(':Trans', $transactionID, PDO::PARAM_INT);
$insertPaid->execute();
tableOfKnowing();
echo "<tr><td class='danger' colspan='3'>You have added a transaction worth $ $price!</td></tr>"
?>