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


 $_SESSION['dateFrom'] = date('Y-m-d', strtotime($_SESSION['dateFrom']));
 $_SESSION['dateTo']  = date('Y-m-d', strtotime($_SESSION['dateTo']));

 $dateFrom = $_SESSION['dateFrom'];
 $dateTo = $_SESSION['dateTo'];



$displayDate = date("m/d/Y");
//Admin Login Verify
if ($_SESSION['user_role'] != 'Salesman') {
 header("LOCATION: ../index.php");   
}

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
          <h2>Stock Transfer - Date</h2>
        </div>

      </div>
      <div class="row">
        <div class="row text-left">
          <div class="col-xs-3">
            <p>
              Date : <strong><?php echo $dateFrom; ?></strong> to <strong><?php echo $dateTo ?></strong>
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
      <table class="table table-bordered table-striped table-hover table-condensed results" id="example">
        <thead>
          <tr>
            <th class="text-center">Transfer #</th>
            <th class="text-center">Branch Transferred To</th>
            <th class="text-center">Product Code</th>
            <th class="text-center">Product Name</th>
            <th class="text-center">Unit Per Case/Box</th>
            <th class="text-center">Requested</th>
            <th class="text-center">Transferred</th>
          </tr>
        </thead>
        <tbody>
          <?php  
          $branch = $_SESSION['branch'];
          $userQuery = "SELECT * FROM stock_transfer 
                        INNER JOIN {$prefix}products ON stock_transfer.transfer_product_code = {$prefix}products.product_code
          WHERE transfer_tobranch = '$branch' AND transfer_status = 'Transfer Complete'
          AND transfer_date BETWEEN '$dateFrom' AND '$dateTo'";
          $selectQuery = mysqli_query($connection,$userQuery);

          while ($row = mysqli_fetch_array($selectQuery)) {
            $transfer_number = $row['transfer_number'];
            $transfer_status = $row['transfer_status'];
            $transfer_frombranch = $row['transfer_frombranch'];
            $transfer_tobranch = $row['transfer_tobranch'];
            $transfer_product_id = $row['transfer_product_id'];
            $transfer_product_code = $row['transfer_product_code'];
            $product_name = $row['product_name'];
            $transfer_quantity = $row['transfer_quantity'];
            $stocks_transferred = $row['stocks_transferred'];
            $st_unit_per = $row['st_unit_per'];

            ?>
            <td class="text-center"><?php echo sprintf('%08d', $transfer_number); ?></td>
            <td><?php echo $transfer_frombranch; ?></td>
            <td><?php echo $transfer_product_code; ?></td>
            <td><?php echo $product_name; ?></td>
            <td><?php echo $st_unit_per; ?></td>
            <td><?php echo $transfer_quantity; ?></td>
            <td><?php echo $stocks_transferred; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>


      <a href="history_interbranch.php" class="btn btn-default btn-lg no-print">Back</a>
      <button type="button" class="btn btn-default btn-lg pull-right no-print" onclick="window.print()"><span class="glyphicon glyphicon-print"></span> Print</button>

    </div>
    <br>
  </div>

</body>
</html>
