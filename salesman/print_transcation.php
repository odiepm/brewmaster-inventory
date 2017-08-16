<?php include '../includes/db.php'; ?>
<?php ob_start(); ?>
<?php session_start(); ?>
<?php 
//Prefix
$prefix = strtolower($_SESSION['branch']) .'_';
$capitalPrefix = strtoupper($_SESSION['branch']);

//Retrieve VAT%
$getVat = "SELECT * FROM {$prefix}settings;";
$getVatQ = mysqli_query($connection, $getVat);
while ($row = mysqli_fetch_array($getVatQ)) {
  $vatPercent = $row['vat_percent'];
}


$displayDate = date("m/d/Y");
//Admin Login Verify
if ($_SESSION['user_role'] != 'Salesman') {
 header("LOCATION: ../index.php");   
}

?>

<?php
$dateFrom = $_SESSION['dateFrom'];
$dateTo = $_SESSION['dateTo'];
?>

<!DOCTYPE html">
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title></title>
  <link rel="stylesheet" href="/final/admin/css/bootstrap.min.css">
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
        <div class="text-center">
          <h1>
            <img src="../images/logo.png" 
            style="-webkit-filter: grayscale(100%);
            filter: grayscale(100%);
            height: 100px; width: 140px; ">
          </h1>
        </div>

        <div class="text-center">
          <h2>Salesman Sales - Date</h2>
        </div>

      </div>
      <div class="row">
        <div class="row text-left">
          <div class="col-xs-3">
            <p>
              Date : <strong><?php echo $displayDate; ?></strong>
            </p>
          </div>
          <div class="col-xs-2">
            <strong>

            </strong>
          </div>
        </div>

      </div>
      <!-- / end client details section -->

      <hr>
      <h4>Products Sold:</h4>
      <table class="table table-hover table-condensed table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center">#</th>
            <th class="text-center">Salesman Name</th>
            <th class="text-center">Customer Name</th>
            <th class="text-center">Customer Address</th>
            <th class="text-center">Customer Contact</th>
            <th class="text-center">Date</th>
            <th class="text-center">Total Sales</th>
          </tr>
        </thead>
        <tbody>
          <?php  

          $userQuery = "SELECT * FROM {$prefix}customer 
          INNER JOIN {$prefix}sws ON {$prefix}customer.customer_sws_id = {$prefix}sws.sws_number
          WHERE date = '$displayDate'
          GROUP BY customer_distribution_id;";
          $selectQuery = mysqli_query($connection,$userQuery);

          $tableCount = 0;
          $productTableTotal = 0;
          while ($row = mysqli_fetch_array($selectQuery)) {
            $customer_name = $row['customer_name'];
            $customer_address = $row['customer_address'];
            $customer_contact = $row['customer_contact'];
            $customer_distribution_id = $row['customer_distribution_id'];
            $customer_product_qty = $row['customer_product_qty'];
            $customer_product_price = $row['customer_product_price'];
            $sws_smname = $row['sws_smname'];
            $date = $row['date'];

            $productTable = $customer_product_qty * $customer_product_price;
            $productTableTotal += $productTable;

            $tableCount++;

            ?>
            <td class="text-center"><?php echo $tableCount; ?></td>
            <td><?php echo $sws_smname; ?></td>
            <td><?php echo $customer_name; ?></td>
            <td><?php echo $customer_address; ?></td>
            <td><?php echo $customer_contact; ?></td>
            <td><?php echo $date; ?></td>
            <td><?php echo '₱ '. number_format($productTableTotal,2); ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>


      <a href="history_transaction.php" class="btn btn-default btn-lg no-print">Back</a>
      <button type="button" class="btn btn-default btn-lg pull-right no-print" onclick="window.print()"><span class="glyphicon glyphicon-print"></span> Print</button>

    </div>
    <br>
  </div>

</body>
</html>
