<?php include 'includes/admin_header.php'; ?>

<?php
//Check if salesman is in session
if(!isset($_SESSION['salesman'])){
	header("Location:select_salesman.php");
}



//assign variables to session
$salesman = $_SESSION['salesman'];
$salesmanFull = $_SESSION['salesmanFull'];
$route 	  = $_SESSION['payment_route']; 
$date 	  = $_SESSION['payment_date'];	
$driver   = $_SESSION['payment_driver'];
$load     = $_SESSION['payment_load'];
$plate    = $_SESSION['payment_plate']; 
$vehicle  = $_SESSION['payment_vehicle'];
$count = $_SESSION['count_sws_ordernum'];


//Insert into 'SWS' table
$insert = "INSERT INTO {$prefix}sws 
(sws_number, sws_productid, sws_procode, sws_quantity, date, sws_salesman, sws_smname, sws_route,sws_driver, 
	sws_plate, sws_vehicle, sws_load, sws_proname, sws_unitprice, sws_prodesc, sws_proexp, sws_category, sws_isEmpty, sws_true_quantity, sws_unit_per) 
	
	SELECT $count, product_id, cartProdcode, quantityCart,'$date','$salesman',
	'$salesmanFull','$route','$driver','$plate','$vehicle','$load', 
	cartProdname, cartProdsell, cartProdesc, cartProdexp, cartProdcat, cartProdempty, quantityCart, cartUnitper FROM {$prefix}cart;";			
	$exec = mysqli_query($connection, $insert);
	
//STORE LAST ID INSERTED TO SESSION
$_SESSION['lastInsert'] = mysqli_insert_id($connection); //should be after mysqli_query

 //Insert to activity log
$queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername made a withdrawal with salesman: $salesmanFull', '$activityDate');";
$execLog = mysqli_query($connection, $queryLog);


//Insert into 'orders' table 
$insertOrder = "INSERT INTO {$prefix}orders (order_num, Salesman, salesman_name, date, status)
VALUES($count,'$salesman', '$salesmanFull', '$date','Pending')";					
$exec = mysqli_query($connection, $insertOrder);


//ASSIGN LAST ID INSERTED TO A VARIABLE
$lastInsert = $_SESSION['lastInsert'];

//UNSET SESSIONS
unset($_SESSION['salesman']);
unset($_SESSION['salesmanFull']);
unset($_SESSION['payment_route']);
unset($_SESSION['payment_employee']);
unset($_SESSION['payment_date']);
unset($_SESSION['payment_driver']);
unset($_SESSION['payment_load']);
unset($_SESSION['payment_plate']);
unset($_SESSION['payment_vehicle']);

$deletecart = "TRUNCATE TABLE {$prefix}cart;";
$deletecart .= "TRUNCATE TABLE {$prefix}case_cart;";

mysqli_multi_query($connection, $deletecart);

?> 

<div class="row">
	<div class="col-md-12">
		<div class="well well-sm">
			<ol class="breadcrumb" style="margin-bottom: -3px;">
				<li class="active">Select Salesman</li>
				<li class="active">Add Products to Cart</li>
				<li class="active">Delivery Info</li>
				<li class="active">Confirm Order</li>
				<li><strong>Success</strong></li>
			</ol>
		</div>

		<div class="panel panel-default">
			<div class="panel-body">
				<img class="center-block image-responsive" src="../images/check.png" width="100px;" height="90px;">
				<h2 class="text-center text-success">Order Successful</h2>
				<h4 class="text-center">Order is placed in Pending Orders to be confirmed</h4>
				<hr>
				<div class="col-md-4 col-md-offset-2">
					<a href="select_salesman.php" class="btn btn-warning center-block"><i class="fa fa-shopping-cart"></i> Make Another Withdrawal</a>
				</div>

				<div class="col-md-4">
					<a class="btn btn-success center-block" href="pending_order.php" role="button"><i class="glyphicon glyphicon-list"></i> Go to Pending Orders</a>
				</div>


			</div>
		</div>


	</div>





</div>


<?php include 'includes/admin_footer.php'; ?>