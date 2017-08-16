<?php include 'includes/admin_header.php'; ?>
<?php 

//Retrieve VAT%
$getVat = "SELECT * FROM {$prefix}settings;";
$getVatQ = mysqli_query($connection, $getVat);
while ($row = mysqli_fetch_array($getVatQ)) {
	$vatPercent = $row['vat_percent'];
}

//Check if O.N. exists
$checkOrder = "SELECT * FROM {$prefix}orders;";
$checkQ = mysqli_query($connection, $checkOrder);

$currentON = 0;
$count = 0;

while ($row = mysqli_fetch_array($checkQ)) {
	$currentON = $row['order_num'];
}

while ($count <= $currentON) {
	$count++;
}
//Initialize DATE (m/d/Y)
$date = date("m/d/Y");


$_SESSION['count_sws_ordernum'] = $count;

$checkCart = "SELECT * FROM {$prefix}cart;";
$checkQuery = mysqli_query($connection, $checkCart);
$row = mysqli_fetch_array($checkQuery);

if (mysqli_num_rows($checkQuery) < 1) {
	header('Location:add_sales.php');
}


?>
<div class="row">
	<div class="col-md-12">
		<div class="well well-sm">
			<ol class="breadcrumb" style="margin-bottom: -3px;">
				<li class="active">Select Salesman</li>
				<li class="active">Add Products to Cart</li>
				<li><strong>Delivery Info</strong></li>
				<li class="active">Confirm Order</li>
				<li class="active">Success</li>

			</ol>
		</div>
		<div class="panel panel-success">
			<div class="panel-heading">
				<strong>
					<span class="fa fa-shopping-cart"></span>
					<span>Salesman's Cart</span>
				</strong>
			</div>
			<div class="panel-body">
				<h4>Product List:</h4>
				<table class="table table-hover" id="tae">
					<thead>
						<tr>
							<th class="text-center">Product ID</th>
							<th class="text-center">Product Name</th>
							<th class="text-center">Description</th>
							<th class="text-center">Unit per Case/Box</th>
							<th class="text-center">Quantity</th>
							<th class="text-center">Price per Unit</th>
							<th class="text-center">Total Amount</th>
						</tr>
					</thead>
					<tbody>


						<?php 

						$selectCart = "SELECT * FROM {$prefix}cart INNER JOIN {$prefix}products ON {$prefix}products.product_id = {$prefix}cart.product_id";
						$execSelectCart = mysqli_query($connection, $selectCart);

						$cartCount = 0;
						$computeVATValue = 0;
						$compute1 = 0;
						while ($row = mysqli_fetch_array($execSelectCart)) {

							$cartProId = $row['product_id'];
							$cartProName = $row['product_name'];
							$cartProDesc = $row['description'];
							$cartSellPrice = $row['sell_price'];
							$cartQty = $row['quantityCart'];
							$unit_per = $row['unit_per'];

							$compute = $cartSellPrice * $cartQty;
							$compute1 += $cartSellPrice * $cartQty;
							$totalAmount = number_format((float)$compute, 2, '.', '');

							$computeVATValue = $compute1 - ($compute1/(1+($vatPercent/100)));


							$cartCount++;

							?>

							<tr>
								<td class="text-center"><?php echo $cartProId; ?></td>
								<td class="text-center"><?php echo $cartProName; ?></td>
								<td class="text-center"><?php echo $cartProDesc; ?></td>
								<td class="text-center"><?php echo $unit_per; ?></td>
								<td class="text-center"><?php echo $cartQty; ?></td>
								<td class="text-center">₱ <?php echo number_format($cartSellPrice,2); ?></td>
								<td class="text-center">₱ <?php echo $totalAmount ?></td>
							</tr>

							<?php } ?>
						</tbody>
					</table>

					<hr>
					<div class="row text-right">
						<div class="col-xs-2 col-xs-offset-8">
							<p>
								<strong>
									Sub Total : <br>
									VAT <?php echo $vatPercent; ?>% : <br>
									Total : <br>
								</strong>
							</p>
						</div>
						<div class="col-xs-2">

							₱ <?php echo number_format($compute1 - $computeVATValue,2); ?> <br>
							₱ <?php echo number_format($computeVATValue, 2); ?> <br> 
							<strong>
								₱ <?php echo number_format($compute1,2); ?> <br>
							</strong>
						</div>
					</div>
					<div class="form-group">  
						<a href="add_sales.php" class="btn btn-info btn-sm">
							<span class="glyphicon glyphicon-arrow-left"></span>
							Edit Cart
						</a>
					</div>
				</div>

			</div>


		</div> 
	</div>


	<!-- Start of Billing Info -->
	<div class="panel panel-primary">
		<div class="panel-heading">
			<strong>
				<span class="glyphicon glyphicon-th"></span>
				<span>Delivery Information</span>
			</strong>
		</div>

		<div class="panel-body">


			<div class="panel panel-info">
				<div class="panel-body">


					<form method="post" action="payment_method.php">

						<?php
			//Assign salesman session to variable
						$salesmanID = $_SESSION['salesman'];

						$select1 = "SELECT * from users where user_role = 'Salesman' AND branch = '$capitalPrefix';";
						$exec = mysqli_query($connection,$select1);

						$vehicleNo = $_SESSION['vehicleNo'];

						$selectVe = "SELECT * FROM {$prefix}vehicles WHERE vehicle_id = $vehicleNo";
						$selectVeE = mysqli_query($connection, $selectVe);

						while ($row = mysqli_fetch_array($selectVeE)) {
							$vehicle_id = $row['vehicle_id'];
							$vehicle_firstname = $row['vehicle_firstname'];
							$vehicle_lastname = $row['vehicle_lastname'];
							$vehicle_plateno = $row['vehicle_plateno'];
						}

						?>


						<div class="col-md-6">
							<div class="form-group">
								<label for="date">Date</label>
								<input type="text" class="form-control" name="date" value="<?php echo $date; ?>" readonly />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="ordernumber" class="label-control">Order Number</label>
								<input type="text" class="form-control" name="ordernumber" value=<?php echo sprintf('%08d', $count); ?> readonly>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="employeenumber" class="label-control">Employee Number</label>
								<input type="text" class="form-control" name="employeenumber" value="<?php echo sprintf('%08d', $salesmanID); ?>" disabled>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="route">Route No.</label>
								<input type="text" class="form-control" name="route" placeholder="Route No."  required autocomplete="off">
							</div>
						</div>



					</div>
				</div>

				<div class="panel panel-info">
					<div class="panel-body">

						<div class="col-md-6">
							<div class="form-group">
								<label for="driver">Driver Name</label>
								<input type="text" class="form-control" name="driver" placeholder= "Driver Name" required autocomplete="off" readonly value="<?php echo ucwords($vehicle_firstname) . " " . ucwords($vehicle_lastname);  ?>">
							</div>
						</div>


						<div class="col-md-6">
							<div class="form-group">
								<label for="vehicle">Vehicle No.</label>
								<input type="text" class="form-control" name="vehicle" placeholder= "Vehicle No." required autocomplete="off" readonly value="<?php echo $vehicle_id; ?>">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="plate">Plate No.</label>
								<input type="text" class="form-control" name="plate" placeholder= "Plate No." required autocomplete="off" readonly
								value="<?php echo $vehicle_plateno; ?>">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="load">Load No.</label>
								<input type="text" class="form-control" name="load" placeholder= "Plate No." required autocomplete="off">
							</div>
						</div>

					</div>
				</div>

				<div class="col-md-12">
					<div class="form-group"> 
						<input type="submit" name="submit" value="Confirmation" class="btn btn-success pull-right">
					</div>
				</div>
			</form>
		</div>

	</div>

</div>
<?php include 'includes/admin_footer.php'; ?>
</div>
</div>
</div>

