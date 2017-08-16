<?php include '../includes/db.php'; ?>
<?php ob_start(); ?>
<?php session_start(); ?>
<?php 
//Prefix
$prefix = strtolower($_SESSION['branch']) .'_';
$capitalPrefix = strtoupper($_SESSION['branch']);

$listDate = date("Y-m-d");
//Admin Login Verify
if ($_SESSION['user_role'] != 'Admin') {
 header("LOCATION: ../index.php");   
}

if (isset($_GET['dateFrom'])) {
    $dateFrom = $_GET['dateFrom'];
    $dateTo = $_GET['dateTo'];
 } 

?>

<!DOCTYPE html">
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title></title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
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
          <h2>Order Report by Date</h2>
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
      <table class="table table-hover table-striped table-condensed">
       <thead>
         <tr>
           <th>#</th>
           <th>Supplier/Salesman</th>
           <th>Date Added</th>
           <th>Order Type</th>
           <th>Product Name </th>
           <th>Product Description </th>
           <th>Product Expiry </th>
           <th>Quantity </th>
         </tr>
       </thead>
       <tbody>
         <?php 

         $sqlSelect2 =  "SELECT * FROM {$prefix}reports WHERE report_date BETWEEN '$dateFrom' AND '$dateTo' ORDER BY report_id desc;";
         $sqlExec2 = mysqli_query($connection, $sqlSelect2);
         $tableCount = 0;
         while ($row = mysqli_fetch_array($sqlExec2)) {

          $report_id = $row['report_id'];
          $report_type = $row['report_type'];
          $report_supplier = $row['report_supplier'];
          $report_product = $row['report_product'];
          $report_description = $row['report_description'];
          $report_quantity = $row['report_quantity'];
          $report_date = $row['report_date'];
          $report_expiry = $row['report_expiry'];
          $tableCount++;
          ?>

          <tr>
            <td><?php echo $tableCount; ?></td>
            <td><?php echo $report_supplier; ?></td>
            <td><?php echo $report_date; ?></td>
            <td><?php echo $report_type; ?></td>
            <td><?php echo $report_product; ?></td>
            <td><?php echo $report_description; ?></td>
            <td><?php echo $report_expiry; ?></td>
            <td><?php echo $report_quantity; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <hr>
     <a href="orders.php" class="btn btn-default btn-lg no-print">Back</a>
     <button type="button" class="btn btn-default btn-lg pull-right no-print" onclick="window.print()"><span class="glyphicon glyphicon-print"></span> Print</button>
   </div>
   <br>
 </div>

</body>
</html>
