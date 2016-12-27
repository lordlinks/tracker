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