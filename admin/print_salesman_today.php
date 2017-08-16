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
if ($_SESSION['user_role'] != 'Admin') {
 header("LOCATION: ../index.php");   
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
          <h2>Salesman Sales - Today</h2>
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
      <h4>Salesman Sales:</h4>
      <table class="table table-hover table-condensed table-bordered table-striped">
        <thead>
          <tr>
            <th>Top #</th>
            <th>Employee No.</th>
            <th>Salesman Name</th>
            <th>Total Sales</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $top = 0;
          $top5salesman = "SELECT sws_salesman, sws_smname, SUM(sws_unitprice * sws_quantity) AS TotalSales
          FROM {$prefix}sws WHERE date = '$displayDate'
          GROUP BY sws_salesman
          ORDER BY SUM(sws_unitprice * sws_quantity) DESC";
          $top5salesmanE = mysqli_query($connection, $top5salesman);

          while ($row = mysqli_fetch_array($top5salesmanE)) {
            $sws_salesman = $row['sws_salesman'];
            $sws_smname = $row['sws_smname'];
            $TotalSales = $row['TotalSales'];
            $top++;
            ?>
            <tr>
              <td><?php echo $top; ?></td>
              <td><?php echo sprintf('%08d', $sws_salesman); ?></td>
              <td><?php echo $sws_smname; ?></td>
              <td><?php echo '₱ '. number_format($TotalSales, 2); ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>


        <a href="history_sales.php" class="btn btn-default btn-lg no-print">Back</a>
        <button type="button" class="btn btn-default btn-lg pull-right no-print" onclick="window.print()"><span class="glyphicon glyphicon-print"></span> Print</button>

      </div>
      <br>
    </div>

  </body>
  </html>
