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
          <h2>Stock Transfer</h2>
        </div>

      </div>
      <div class="row">
        <div class="row text-left">
          <div class="col-xs-3">
            <p>
                Date : <strong><?php echo $listDate; ?></strong>
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
     <th>Requested by Branch</th>
     <th>Product Name</th>
     <th>Quantity</th>
     <th>To Branch</th>
     <th>Date of Placement</th>
     </tr>
   </thead>
   <tbody>
    <?php 

      if (isset($_GET['id'])) {
          
          $id = $_GET['id'];
          $to = $_GET['to'];
      }

      $sql = "SELECT * FROM stock_transfer INNER JOIN {$to}_products ON transfer_product_id = product_id 
            WHERE transfer_frombranch = '$capitalPrefix' AND transfer_number = $id;";
      $sqlE = mysqli_query($connection, $sql);

      $tableCount = 0;
       while ($row = mysqli_fetch_array($sqlE)) {
         $transfer_id = $row['transfer_id'];
         $from = $row['transfer_frombranch'];
         $product_name = $row['product_name'];
         $quantity = $row['transfer_quantity'];
         $to = $row['transfer_tobranch'];
         $date = $row['transfer_date'];

         $tableCount++;
      ?>
      <tr>
        <td><?php echo $tableCount; ?></td>
        <td><?php echo $from; ?></td>
        <td><?php echo $product_name; ?></td>
        <td><?php echo $quantity; ?></td>
        <td><?php echo $to; ?></td>
        <td><?php echo $date; ?></td>
      </tr>
      <?php } ?>
   </tbody>
 </table>
 <hr>

      <a href="javascript:history.back()" class="btn btn-default btn-lg no-print">Back</a>
       <button type="button" class="btn btn-default btn-lg pull-right no-print" onclick="window.print()"><span class="glyphicon glyphicon-print"></span> Print</button>
      </div>
      <br>
    </div>
  
  </body>
</html>
