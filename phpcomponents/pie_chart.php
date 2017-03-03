<?php
/**
 * Created by PhpStorm.
 * User: links
 * Date: 3/03/2017
 * Time: 6:19 PM
 */

include_once "SQLconnect.php";
include_once "SQLdisconnect.php";


$conn = connect();
try{
	$stmt = $conn->prepare('SELECT storename, SUM(amount) AS moneys
FROM store
JOIN transaction ON store.idstore = transaction.store
WHERE transaction.date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
GROUP BY storename;');
	$stmt->execute();
	$listout = array();
	$resultant = array();
	if ($stmt->rowCount()>0) {
		$listout['cols'] = array(
			array('id' => '', 'label' => 'Shop', 'type' => 'string'),
			array('id' => '', 'label' => 'amount', 'type' => 'number')
		);
		foreach ($stmt as $row){
			$temp = array();
			$temp[] = array('v' => (string) $row['storename']);
			$temp[] = array('v' => (float) $row['moneys']);
			$resultant[] = array('c' => $temp);
		}
		$listout['rows'] = $resultant;
		$jason_table = json_encode($listout, true);
		echo $jason_table;
	}
	else{
		return ['No receipts yet', 1];
	}
}
catch (Exception $e){
	echo 'ERROR: ' . $e->getMessage();
}
close($conn);
