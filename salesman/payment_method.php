<?php include 'includes/salesman_header.php'; ?>

<?php 
//Get POST and SESSION from checkout.php


$_SESSION['payment_route']     = $_POST['route'];
$_SESSION['payment_date'] 	   = $_POST['date'];


$_SESSION['payment_driver']   = $_POST['driver'];
$_SESSION['payment_load']     = $_POST['load'];
$_SESSION['payment_plate']    = $_POST['plate']; 
$_SESSION['payment_vehicle']  = $_POST['vehicle'];
$salesmanID = $_SESSION['user_id'];


//Retrieve VAT%
$getVat = "SELECT * FROM {$prefix}settings;";
$getVatQ = mysqli_query($connection, $getVat);
while ($row = mysqli_fetch_array($getVatQ)) {
	$vatPercent = $row['vat_percent'];
}

?>




<div class="row">
	<div class="col-md-12">
		<div class="well well-sm">
			<ol class="breadcrumb" style="margin-bottom: -3px;">
				<li class="active">Select Salesman</li>
				<li class="active">Add Products to Cart</li>
				<li class="active">Delivery Info</li>
				<li><strong>Confirm Order</strong></li>
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
				<hr>
				<!-- ***********************CASE********************** -->
				<h4>Product List:</h4>
				<table class="table table-hover" id="tae">
					<thead>
						<tr>
							<th class="text-center">Product ID</th>
							<th class="text-center">Product Name</th>
							<th class="text-center">Description</th>
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


			<br>

			<form action="save_sws.php" method="post">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<strong>
							<span class="glyphicon glyphicon-th"></span>
							<span>Billing Info</span>
						</strong>
					</div>
					<div class="panel-body">

						<?php 

 						//Retrieve Salesman name from database
						$selectSM = "SELECT * FROM users WHERE user_id = $salesmanID AND branch = '$capitalPrefix'";
						$QselectSM = mysqli_query($connection, $selectSM);

						while ($row = mysqli_fetch_array($QselectSM)) {
							$sm_fname = $row['firstname'];
							$sm_lname = $row['lastname'];
						}

						$smFullname = $sm_fname." ".$sm_lname;
						$_SESSION['salesmanFull'] = $smFullname;

						?>	

						<div class="form-group">
							<label class="col-sm-2 control-label">Salesman:</label>
							<p><strong><?php echo ucwords($_SESSION['salesmanFull']); ?></strong></p>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Employee Number:</label>
							<p><strong><?php echo sprintf('%08d',$_SESSION['user_id']); ?></strong></p>
						</div>



						<div class="form-group">
							<label class="col-sm-2 control-label">Route No.:</label>
							<p><strong><?php echo $_SESSION['payment_route']; ?></strong></p>
						</div>



						<div class="form-group">
							<label class="col-sm-2 control-label">Date:</label>
							<p><strong><?php echo $_SESSION['payment_date']; ?></strong></p>
						</div>

						<hr>
						<div class="form-group">
							<label class="col-sm-2 control-label">Driver:</label>
							<p><strong><?php echo $_SESSION['payment_driver']; ?></strong></p>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Vehicle No.:</label>
							<p><strong><?php echo $_SESSION['payment_vehicle']; ?></p></strong></p>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Plate No.:</label>
							<p><strong><?php echo $_SESSION['payment_plate']; ?></strong></p>
						</div>


						<div class="form-group">
							<label class="col-sm-2 control-label">Load No.:</label>
							<p><strong><?php echo $_SESSION['payment_load']; ?></strong></p>
						</div>




						<input type="submit" name="confirm" value="Confirm Order" class="btn btn-success btn-md pull-right">

					</div>
				</div>
			</form>
		</div> 

	</div>


	<?php include 'includes/salesman_footer.php'; ?>