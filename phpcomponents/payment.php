<?php
include_once "SQLconnect.php";
include_once "SQLdisconnect.php";

try{
	$name = $_GET["name"];
}
catch(Exception $e) {
	echo 'Message: ' . $e->getMessage();
}
$who_paid = [
	1 => "dougpaid",
	2 => "garethpaid",
	3 => "sarahpaid"
];
$person = "c.". $who_paid[$name];
$conn = connect();
$stmt = $conn->prepare("SELECT a.date, b.storename, a.amount
						FROM transaction AS a
						INNER JOIN store b
						ON a.store = b.idstore
						INNER JOIN paid c
						ON a.idtran = c.transaction
						WHERE $person = FALSE
						ORDER BY a.date ASC");
$stmt->execute();
//echo print_r($stmt);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($stmt->rowcount()>0){
	$table_statement = "<table class='table table-striped'><tr><th>Date</th><th>Store</th><th>Amount</th></tr>";
	foreach ($results as $row){
		$table_statement .= "<tr><td>" . $row['date'] . "</td><td>" . $row['storename'] . "</td><td>$" . $row['amount']
			. "</td></tr>";
	}
	$table_statement .="</table>";
	echo $table_statement;
	echo "<br><button type='button' onclick='pay_bill()' class='btn btn-info'>Pay running total</button>
	<button type='button' class='btn btn-info'>Ignore</button> ";
}
else{
	echo "<h2>Congratulations you are up to date!</h2>";
}
close($conn);

