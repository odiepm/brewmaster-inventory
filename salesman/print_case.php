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
          <h2>Case List</h2>
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
      <table class="table table-bordered table-striped table-hover table-condensed results" id="example">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Case Code</th>
                    <th class="text-center">Case Name</th>
                    <th class="text-center">Case Description</th>
                    <th class="text-center">Instock</th>
                    <th class="text-center">Selling Price</th>
                    <th class="text-center">Expiry Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php  

                  $userQuery = "SELECT * FROM {$prefix}case;";
                  $selectQuery = mysqli_query($connection,$userQuery);

                  $tableCount = 0;
                  while ($row = mysqli_fetch_array($selectQuery)) {
                    $case_id = $row['case_id'];
                    $case_product_name = $row['case_product_name'];
                    $case_desc = $row['case_desc'];
                    $case_quantity = $row['case_quantity'];
                    $case_product_code = $row['case_product_code'];
                    $case_expiry = $row['case_expiry'];
                    $case_price = $row['case_price'];

                    $tableCount++;

                    ?>

                    
                    <td class="text-center"><?php echo $tableCount; ?></td>
                    <td class="text-center"><?php echo $case_product_code; ?></td>
                    <td><?php echo $case_product_name; ?></td>
                    <td><?php echo $case_desc; ?></td>
                    <td><?php echo $case_quantity;?></td>
                    <td class="text-center">₱ <?php echo $case_price; ?></td>
                    <td class="text-center"><?php echo $case_expiry; ?></td>
                </tr>
                <?php }  ?>


              </tbody>
            </table>

  <?php if ($tableCount <= 0) {
    echo "<div class='well well-lg'>
      No Products!
    </div>";
  } else { ?>
       <button type="button" class="btn btn-default btn-lg pull-right no-print" onclick="window.print()"><span class="glyphicon glyphicon-print"></span> Print</button>
  <?php } ?>
      <a href="manage_products.php" class="btn btn-default btn-lg no-print">Back</a>
      </div>
      <br>
    </div>
  </body>
</html>
