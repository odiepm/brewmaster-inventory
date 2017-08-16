<?php include '../includes/db.php'; ?>
<?php ob_start(); ?>
<?php session_start(); ?>
<?php 

if ($_SESSION['user_role'] != 'Admin') {
 header("LOCATION: ../index.php");   
}


//SELECT ID VIA GET
if (isset($_GET['id'])) {
  $id = $_GET['id'];
   $order_number = $_GET['order_num'];
  
//SELECT CUSTOMER
  $sqlSelect = "SELECT * FROM {$prefix}sws where sws_number = $order_number";
  $sqlExec = mysqli_query($connection, $sqlSelect);
  $row = mysqli_fetch_array($sqlExec);
  $salesman = $row['sws_salesman'];
  $route = $row['sws_route'];
  $plate = $row['sws_plate'];
  $load = $row['sws_load'];
  $vehicle = $row['sws_vehicle'];
  $driver = $row['sws_driver'];
  $employee = $row['sws_employee'];
   $order_num = $row['sws_number'];
   $date = $row['date'];
  
} 
 ?>

<!DOCTYPE html">
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="css/bootstrap.css">
        <style>

          @media print {    
            .no-print, .no-print * {
                display: none !important;
            }
          }

        @media print { 
          @page {margin: 0;}
           body {margin: 1.6cm;} 
         }
        </style>

  </head>
  <div id="printableArea">
  <body>
    <div class="container">
      <div class="row">
        <div class="col-xs-6">
          <h1>
            <img src="../images/logo.png" 
            style="-webkit-filter: grayscale(100%);
            filter: grayscale(100%);
            height: 100px; width: 140px; ">
          </h1>
        </div>

        <div class="col-xs-6 text-right">
          <h1>INVOICE</h1>
          <h1><small>Invoice #<?php echo $order_num; ?></small></h1>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-5">

              <p>
                <strong>www.brewmaster.co.ph</strong> <br>
                <strong>114 Legaspi Street, Makati City, Metro Manila</strong> <br>
                <strong>TEL: 01234 567-8910</strong> <br>
                <strong>admin@brewmaster.co.ph</strong> <br>
              </p><br><br>
              <strong>Date of Delivery: <?php echo $date; ?> </strong><br>
            </div>
        
        <div class="col-xs-5 col-xs-offset-2 text-left">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="text-center">SALESMAN: <?php echo $salesman ?> </h4>
            </div>
            <div class="panel-body">
              <p>
                  
				 <div class="pull-left">
						Employee No.: <?php echo $employee; ?>
				 </div>			  
				<div class="text-center"> 
						Route No. : <?php echo $route; ?>
				</div>
                 <div class="pull-left">
						Driver: <?php echo $driver; ?>
				 </div>
                 <div class="text-center">
						Plate No. : <?php echo $plate; ?>
				 </div>	 
				 <div class="pull-left">
						Vehicle No.:  <?php echo $vehicle; ?>
				</div>
				<div class="text-center">
						Load No. : <?php echo $load; ?>
				</div>
					
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- / end client details section -->
      <table class="table table-bordered table-condensed">
        <thead>
          <tr>
            <th class="text-center">Product Name </th>
            <th class="text-center">Description </th>
            <th class="text-center">Qty </th>
            <th class="text-center">Price </th>
            <th class="text-center">Sub Total </th>
          </tr>
        </thead>
        <tbody>
	
      
        <?php 

      /*
          $sqlSelect2 =  "SELECT s.product_id, s.product_name, s.sell_price, s.quantity, s.date, p.product_quantitiy
              FROM products AS s 
			  
			  INNER JOIN sales AS p ON p.product_id = s.product_id WHERE customer_id = $id;";
          $sqlExec2 = mysqli_query($connection, $sqlSelect2);

          $total_amount = 0;
          while ( $row = mysqli_fetch_array($sqlExec2)) {
            $product_id = $row['product_id'];
            $quantityCart = $row['product_quantitiy'];
            $product_name = $row['product_name'];
            $product_price = $row['sell_price'];
            $date = $row['date'];

            $compute = $product_price * $quantityCart;
            $cartAmount = number_format((float)$compute, 2, '.', '');
            $total_amount += number_format((float)$compute, 2, '.', '');
            $vat = $total_amount * 0.12;
            $vatTotal = $vat + $total_amount;
			*/
         ?>
		 
		 <?php
		
		 
		 $selectQuery = "SELECT s.sws_productid, s.sws_quantity, s.sws_salesman,s.sws_number, p.product_name,p.description, p.sell_price FROM {$prefix}products AS p
		 INNER JOIN {$prefix}sws AS s ON p.product_id = s.sws_productid
		 where sws_number= '$order_number'" ;
		 
		 $query1 = mysqli_query($connection,$selectQuery);
		 while($row = mysqli_fetch_array($query1))
		 {
			 $pname = $row['product_name'];
			 $quantity = $row['sws_quantity'];
			 $description = $row['description'];
			 $sell_price = $row['sell_price'];
			
		 ?>
          

          <tr>
            <td><?php echo $pname; ?></td>
            <td><?php echo $description; ?></td>
            <td><?php echo $quantity; ?></td>
            <td><?php echo $sell_price; ?></td>
            <td></td>
          </tr>
		 <?php } ?>
        </tbody>
		
      </table>
      <div class="row text-right">
        <div class="col-xs-2 col-xs-offset-8">
          <p>
            <strong>
            Sub Total : <br>
            TAX : <br>
            Total : <br>
            </strong>
          </p>
        </div>
        <div class="col-xs-2">
          <strong>
          ₱ Amount<br>
          ₱ Vat<br>
          ₱ VatTotal <br>
          </strong>
        </div>
      </div>
  <a href="pending_order.php" class="btn btn-default btn-lg no-print">Back </a>

      <button type="button" class="btn btn-default btn-lg pull-right no-print" onclick="window.print()"><span class="glyphicon glyphicon-print"></span> Print</button>
      </div>
<br>
    </div>
  
  </body>
</html>
