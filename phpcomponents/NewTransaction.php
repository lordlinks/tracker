<?php
include "runningTotal.php";
include_once "SQLconnect.php";
include_once "SQLdisconnect.php";

//these variables should be send from the javascript in the page though the post method.
try{
	$name = $_GET["name"];
	$shop = $_GET["shop"];
	$price = $_GET["price"];
	$date = $_GET["date"];
}
catch(Exception $e){
	echo 'Message: '.$e->getMessage();
}
//connect to the database and insert the current transaction, this is from the information provided on index.php
$conn = connect();
$stmt = $conn->prepare("INSERT INTO transaction (purchaser, store, date, amount) 
						VALUES (:Name, :Store, :Date, :Amount)");
$stmt->bindParam(':Name', $name, PDO::PARAM_INT);
$stmt->bindParam(':Store', $shop, PDO::PARAM_INT);
$stmt->bindParam(':Date', $date, PDO::PARAM_STR);
$stmt->bindParam(':Amount', $price, PDO::PARAM_STR);
$stmt->execute();
//Now we get the last transaction id (the one we just inserted) (maybe change to select id lim 1 desc)
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
// using the id we just got we can now insert the information of who paid into the paid table.
$whoPaid = array(
	'1' => "INSERT INTO paid (transaction, garethpaid, dougpaid, sarahpaid)
								VALUE (:Trans, 0, 1, 0)",
	'2' => "INSERT INTO paid (transaction, garethpaid, dougpaid, sarahpaid)
								VALUE (:Trans, 1, 0, 0)",
	'3' => "INSERT INTO paid (transaction, garethpaid, dougpaid, sarahpaid)
								VALUE (:Trans, 0, 0, 1)"
);
// based on the name of who paid the last transaction you can now insert the value (this uses the above array)
$queryFill = "$whoPaid[$name]";
$insertPaid = $conn->prepare($queryFill);
$insertPaid->bindParam(':Trans', $transactionID, PDO::PARAM_INT);
$insertPaid->execute();
//now we will update the running total which is its own table and throws to a materialised view for later use.
$running = $conn -> prepare("SELECT * FROM cur_run");
$running ->execute();
$resultant =$running ->fetch();

//we will use this array to get the column names and throw the values to the variables above.
$headers = [
	'GtoS' => $resultant['gareth_to_sarah'],
	'GtoD' => $resultant['gareth_to_doug'],
	'StoG' => $resultant['sarah_to_gareth'],
	'StoD' => $resultant['sarah_to_doug'],
	'DtoG' => $resultant['doug_to_gareth'],
	'DtoS' => $resultant['doug_to_sarah']
];
extract($headers);
$thirds_price = rounder($price);
//add the price to the variables so that we can update the running total.
if ($name=='2'){
	$StoG += $thirds_price;
	$DtoG += $thirds_price;
}
elseif ($name=='3'){
	$DtoS += $thirds_price;
	$GtoS += $thirds_price;

}
elseif ($name=='1'){
	$GtoD += $thirds_price;
	$StoD += $thirds_price;
}
else{
	echo "A HUGE ERROR HAS OCCURRED!";
}
// There has to be a more efficient way of doing this next part
// check which is the larger so we know who ows whom money and thus create a new entry into the table.
if ($StoG>=$GtoS){
	$StoG = $StoG-$GtoS;
	$GtoS = 0;
}
else {
	$GtoS = $GtoS-$StoG;
	$StoG=0;
}
if ($GtoD>=$DtoG){
	$GtoD = $GtoD-$DtoG;
	$DtoG = 0;
}
else {
	$DtoG = $DtoG-$GtoD;
	$GtoD = 0;
}
if ($DtoS>=$StoD){
	$DtoS = $DtoS=$StoD;
	$StoD = 0;
}
else {
	$StoD = $StoD-$DtoS;
	$DtoS = 0;
}
$the_running_total = $conn->prepare("INSERT INTO running_total
	(sarah_to_gareth, sarah_to_doug, gareth_to_sarah, gareth_to_doug, doug_to_sarah, doug_to_gareth)
	VALUES (:STG, :STD, :GTS, :GTD, :DTS, :DTG)");
$the_running_total->bindParam(':STG', $StoG, PDO::PARAM_STR);
$the_running_total->bindParam(':STD', $StoD, PDO::PARAM_STR);
$the_running_total->bindParam(':GTS', $GtoS, PDO::PARAM_STR);
$the_running_total->bindParam(':GTD', $GtoD, PDO::PARAM_STR);
$the_running_total->bindParam(':DTS', $DtoS, PDO::PARAM_STR);
$the_running_total->bindParam(':DTG', $DtoG, PDO::PARAM_STR);
$the_running_total->execute();
//update out table in the html
tableOfKnowing();
//confirm with the user that they have just inserted the transaction
echo "<tr><td class='danger' colspan='3'>You have added a transaction worth $ $price!</td></tr>";
close($conn);
?>