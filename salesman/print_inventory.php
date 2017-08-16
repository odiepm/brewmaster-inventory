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
    <link rel="stylesheet" href="href="/final/admin/css/bootstrap.min.css"">
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
          <h2>Inventory</h2>
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
            <th>Product Name </th>
            <th>Description </th>
            <th>Quantity </th>
          </tr>
        </thead>
        <tbody>
                    <?php  

                    $userQuery = "SELECT sum(quantity) as sumQuantity, p.* FROM {$prefix}products AS p GROUP BY product_name, description;";
                    $selectQuery = mysqli_query($connection,$userQuery);

                    $tableCount = 0;
                    while ($row = mysqli_fetch_array($selectQuery)) {
                      $product_id = $row['product_id'];
                      $product_name = $row['product_name'];
                      $description = $row['description'];
                      $sumQuantity = $row['sumQuantity'];
                      $sell_price = $row['sell_price'];
                      $category_id = $row['category_id'];
                      $expiry_date = $row['expiry_date'];
                      $isEmpty = $row['isEmpty'];
                      $VATableString = '';

                      ($isEmpty == 1 ? $isEmptyString = 'Yes' : $isEmptyString = 'No'); 

                      $sell_price_formatted = number_format($sell_price, 2);
                      $tableCount++;

                      ?>
           
                      <td class="text-center"><?php echo $tableCount; ?></td>
                      <td><?php echo $product_name; ?></td>
                      <td><?php echo $description; ?></td>
                      <td><?php echo $sumQuantity;?></td>

                  </tr>
                        <?php } ?>
                </tbody>
      </table>

  <?php if ($tableCount <= 0) {
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
