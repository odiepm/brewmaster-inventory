<?php include '../includes/db.php'; ?>
<?php ob_start(); ?>
<?php session_start(); ?>
<?php 
//Prefix
$prefix = strtolower($_SESSION['branch']) .'_';
$capitalPrefix = strtoupper($_SESSION['branch']);

$listDate = date("Y-m-d");
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
          <h2>Product List</h2>
        </div>

      </div>
      <div class="row">
        <div class="row text-left">
          <div class="col-xs-2">
            <p>
                Date : <strong><?php echo $listDate; ?></strong><br>
                Branch : <strong><?php echo $capitalPrefix; ?></strong>
            </p>
          </div>
          <div class="col-xs-2">
            <strong>
             
             </strong>
          </div>
        </div>

      </div>
      <!-- / end client details section -->
      <table class="table table-bordered table-condensed">
        <thead>
          <tr>
            <th>#</th>
            <th>Product Code</th>
            <th width="20%">Product Name </th>
            <th width="25%">Description </th>
            <th>Quantity </th>
            <th>Price </th>
            <th>Expiry Date </th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $tableCount = 0;
          $query = "SELECT * FROM {$prefix}products ORDER BY product_id;";
          $exec = mysqli_query($connection, $query);

          $validPrint = 0;

          while ($row = mysqli_fetch_array($exec)) {
            $product_id = $row['product_id'];
            $product_code = $row['product_code'];
            $product_name = $row['product_name'];
            $sell_price = $row['sell_price'];
            $description = $row['description'];
            $quantity = $row['quantity'];
            $expiry_date = $row['expiry_date'];
            $validPrint++;
            $tableCount++;
          ?>
          <tr>
            <td><?php echo $tableCount; ?></td>
            <td><?php echo $product_code; ?></td>
            <td><?php echo $product_name; ?></td>
            <td><?php echo $description; ?></td>
            <td><?php echo $quantity; ?></td>
            <td>₱ <?php echo number_format($sell_price, 2); ?></td>
            <td><?php echo $expiry_date; ?></td>
          </tr>
          <?php } ?>
          
        </tbody>
      </table>

  <?php if ($validPrint <= 0) {
    echo "<div class='well well-lg'>
      No Products!
    </div>";
  } else { ?>
       <button type="button" class="btn btn-default btn-lg pull-right no-print" onclick="window.print()"><span class="glyphicon glyphicon-print"></span> Print</button>
  <?php } ?>
      <a href="view_inventory.php" class="btn btn-default btn-lg no-print">Back</a>
      </div>
      <br>
    </div>
  </body>
</html>
