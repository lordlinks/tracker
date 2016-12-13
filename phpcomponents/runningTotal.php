<?php
function rounder($number){
	$thirds = $number / 3;
	return round($thirds, 2, PHP_ROUND_HALF_UP);
}

function tableOfKnowing(){
	//may wish to change this to a materialised view?
	$conn = connect();
	$stmt = $conn->prepare("SELECT a.amount, b.dougpaid, b.garethpaid, b.sarahpaid
						FROM transaction as a
						INNER JOIN paid b
						ON a.idtran = b.transaction");
	$stmt->execute();
	if ($stmt->rowcount()>0){
		$StoD = 0;
		$StoG = 0;
		$GtoD = 0;
		$GtoS = 0;
		$DtoS = 0;
		$DtoG = 0;
		$headerString = "<tr>";
		$elementString = "<tr>";
		foreach ($stmt as $row){
			if ($row['sarahpaid'] == 0){
				$StoG += rounder($row['amount']);
				$StoD += rounder($row['amount']);
			}
			if($row['garethpaid'] == 0){
				$GtoD += rounder($row['amount']);
				$GtoS += rounder($row['amount']);
			}
			if($row['dougpaid'] == 0){
				$DtoG += rounder($row['amount']);
				$DtoS += rounder($row['amount']);
			}
		}
		//make this into a callable function
		if ($StoG>=$GtoS){
			//echo "First triggered, ";
			$StoG = $StoG-$GtoS;
			$headerString .= "<th>Sarah Owes Gareth</th>";
			$elementString .= "<td>$".$StoG."</td>";
		} else {
			//echo "First else triggered, ";
			$GtoS = $GtoS-$StoG;
			$headerString .= "<th>Gareth Owes Sarah</th>";
			$elementString .= "<td>$".$GtoS."</td>";
		};
		if ($GtoD>=$DtoG){
			//echo "Second triggered, ";
			$GtoD = $GtoD-$DtoG;
			$headerString .= "<th>Gareth Owes Doug</th>";
			$elementString .= "<td>$".$GtoD."</td>";
		} else {
			//echo "Second else triggered, ";
			$DtoG = $DtoG-$GtoD;
			$headerString .= "<th>Doug Owes Gareth</th>";
			$elementString .= "<td>$".$DtoG."</td>";
		};
		if ($DtoS>=$StoD){
			//echo "Third triggered";
			$DtoS = $DtoS=$StoD;
			$headerString .= "<th>Doug Owes Sarah</th>";
			$elementString .= "<td>$".$DtoS."</td>";
		} else {
			//echo "Third else triggered";
			$StoD = $StoD-$DtoS;
			$headerString .= "<th>Sarah Owes Doug</th>";
			$elementString .= "<td>$".$StoD."</td>";
		};
		$headerString .= "</tr>";
		$elementString .= "</tr>";
		echo $headerString.$elementString;
	}
	else {
		echo "
	<span class='glyphicon glyphicon-exclamation-sign'></span>
	<span class='sr-only'>Error:</span>
	Sorry there is either an error or there is no transactions to pay :)";
	}
	close($conn);
}

/*
This is the start of my function to simplify things.
function ($number1, $name1, $number2, $name2){
	if ($number1>=$number2){
		$number1 = $number1-$number2;

	}
}
*/
?>