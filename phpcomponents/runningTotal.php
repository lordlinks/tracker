<?php
function rounder($number){
	//This function divides the number by 3 and then rounds it to 2 decimal places so it is a good currency format
	$thirds = $number / 3;
	return round($thirds, 2, PHP_ROUND_HALF_UP);
}

function tableOfKnowing(){
	//This returns a table showing the names and amounts of money owed to whom
	//Get the generated view for the current running total.
	$conn = connect();
	$stmt = $conn->prepare("SELECT *
							FROM cur_run");
	$stmt->execute();
	//prettier to read version for the html later
	$headers = [
		"gareth_to_sarah" => "Gareth Owes Sarah",
		"gareth_to_doug" => "Gareth Owes Doug",
		"sarah_to_gareth" => "Sarah Owes Gareth",
		"sarah_to_doug" => "Sarah Owes Doug",
		"doug_to_gareth" => "Doug Owes Gareth",
		"doug_to_sarah" => "Doug Owes Sarah"
	];
	if ($stmt->rowcount()>0){
		$headerString = "<tr>";
		$elemString = "<tr>";
		$results = $stmt->fetch();
		foreach ($results as $res => $value){
			if (($value > 0) & (!is_int($res))){
				//because we are dealing with a multi layered array we want only the version with the column headers
				// and values of the data then assemble them into the table later.
				$headerString .= "<th>$headers[$res]</th>";
				$elemString .= "<td>\${$value}</td>";
			}
		}

		$headerString .= "</tr>";
		$elemString .= "</tr>";
		echo $headerString;
		echo $elemString;
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
	$StoG += $row['amount'];
	$StoD += $row['amount'];
	}
	if($row['garethpaid'] == 0){
	$GtoD += $row['amount'];
	$GtoS += $row['amount'];
	}
	if($row['dougpaid'] == 0){
	$DtoG += $row['amount'];
	$DtoS += $row['amount'];
	}
	}
	//make this into a callable function
	if ($StoG>=$GtoS){
	//echo "First triggered, ";
	$StoG = rounder($StoG-$GtoS);
	$headerString .= "<th>Sarah Owes Gareth</th>";
	$elementString .= "<td>$".$StoG."</td>";
	} else {
	//echo "First else triggered, ";
	$GtoS = rounder($GtoS-$StoG);
	$headerString .= "<th>Gareth Owes Sarah</th>";
	$elementString .= "<td>$".$GtoS."</td>";
	};
	if ($GtoD>=$DtoG){
	//echo "Second triggered, ";
	$GtoD = rounder($GtoD-$DtoG);
	$headerString .= "<th>Gareth Owes Doug</th>";
	$elementString .= "<td>$".$GtoD."</td>";
	} else {
	//echo "Second else triggered, ";
	$DtoG = rounder($DtoG-$GtoD);
	$headerString .= "<th>Doug Owes Gareth</th>";
	$elementString .= "<td>$".$DtoG."</td>";
	};
	if ($DtoS>=$StoD){
	//echo "Third triggered";
	$DtoS = rounder($DtoS=$StoD);
	$headerString .= "<th>Doug Owes Sarah</th>";
	$elementString .= "<td>$".$DtoS."</td>";
	} else {
	//echo "Third else triggered";
	$StoD = rounder($StoD-$DtoS);
	$headerString .= "<th>Sarah Owes Doug</th>";
	$elementString .= "<td>$".$StoD."</td>";
	};
	$headerString .= "</tr>";
$elementString .= "</tr>";
echo $headerString.$elementString;
*/