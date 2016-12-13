<html>
	<?php include "phpcomponents/header.php";?>
	<?php include "phpcomponents/name_drop.php";?>
	<?php include "phpcomponents/runningTotal.php"?>
	<script src="js/js.js"></script>
	<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h1>Hi my name is?</h1>
					</div>
					<div class="panel-body">
						<p>
							You must select your name or none of the other functions will work.
						</p>
						<select class="col-md-12" id="name">
							<?php names();?>
						</select>
						<br>
						<div class="alert alert-danger" role="alert" id="shady">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only">Error:</span>
							You are not the real Slim Shady
						</div>
						<button class="btn btn-info">SELECT</button>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h1>I want to add a transaction?</h1>
					</div>
					<div class="panel-body">
						<p>
							This receipt is from:
							<select class="col-md-12" id="shop">
								<?php shops();?>
							</select>
						</p>
						<br>
						<div class="alert alert-danger" role="alert" id="shoppy">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only">Error:</span>
							Select a real shop!
						</div>
						<br>
						<p>
							How much was the purchase? (DDDD.cc)
						</p>
						<input type="text" class="col-md-12 form-control" placeholder="0.00"
						       name="Amount" id="Amount">
						<br>
						<div class="alert alert-danger" role="alert" id="dollarydoos">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only">Error:</span>
							Enter a real amount of dollarydoos!
						</div>
						<br>
						<p>
							The purchase was made? (YYYY-MM-DD)
						</p>
						<div class="input-group">
							<input class="col-md-12 form-control" type="date"
							       placeholder='<?php echo date("Y-m-d");?>' name="Date" id="Date">
							<br>
							<span class="input-group-btn">
								<button type="button" class="btn btn-default"
								        onclick="add_transaction()">Add Receipt</button>
							</span>
						</div>
						<div class="alert alert-danger" role="alert" id="timeywhimey">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only">Error:</span>
							You are not Dr. Who, Use real linear time.
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h1>The table of knowing</h1>
					</div>
					<div class="panel-body">
						<table class="table table-striped" id="knowing">
							<?php tableOfKnowing() ?>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-warning">
						<div class="panel-heading">
							<h1>NO I REALLY WANTED TO PAY A BILL!</h1>
						</div>
					</div>
					<div class="panel-body">
					</div>
				</div>
			</div>
		</div>
	</div>
	</body>
</html>