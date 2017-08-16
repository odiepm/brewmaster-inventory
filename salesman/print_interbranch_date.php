<?php include '../includes/db.php'; ?>
<?php ob_start(); ?>
<?php session_start(); ?>
<?php 
//Prefix
$prefix = strtolower($_SESSION['branch']) .'_';
$capitalPrefix = strtoupper($_SESSION['branch']);

//Retrieve VAT%
$getVat = "SELECT * FROM bs_settings;";
$getVatQ = mysqli_query($connection, $getVat);
while ($row = mysqli_fetch_array($getVatQ)) {
  $vatPercent = $row['vat_percent'];
}

$td_vat_value = 0;
$td_compute = 0;
$td_compute_total = 0;

$bs_vat_value = 0;
$bs_compute = 0;
$bs_compute_total = 0;

$fv_vat_value = 0;
$fv_compute = 0;
$fv_compute_total = 0;

$listDate = date("Y-m-d");
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
          <h2>Sales Report - Date</h2>
        </div>

      </div>
      <div class="row">
        <div class="row text-left">
          <div class="col-xs-3">
            <p>
              Date : <strong><?php echo $dateFrom; ?></strong> to <strong><?php echo $dateTo; ?></strong>
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
      <h3>Baesa Branch</h3>
      <h4>Products Sold:</h4>
      <table class="table table-hover table-striped table-condensed" id="orderNo">
        <thead>
          <tr>
            <th>Order #</th>
            <th>Salesman Name</th>
            <th>Date of Placement</th>
            <th>Product Code</th>
            <th>Product Name </th>
            <th>Product Description </th>
            <th>Expiry Date </th>
            <th class="text-right">Quantity </th>
            <th class="text-right">Unit Price </th>
            <th class="text-right">Total </th>
          </tr>
        </thead>
        <tbody>
          <?php 

          $cartNoVat = "SELECT DISTINCT bs_customer.*, 
          sum(customer_product_qty * customer_product_price) as TotalSales,
          sum(customer_product_qty) AS TotalQty, 
          bs_orders.*
          FROM bs_customer 
          INNER JOIN bs_orders ON bs_orders.order_num = bs_customer.customer_sws_id
          WHERE bs_orders.status = 'Completed' 
          AND bs_orders.date BETWEEN '$dateFrom' AND '$dateTo'
          GROUP BY customer_sws_id, customer_product_code";
          $cartNoVatE = mysqli_query($connection, $cartNoVat);

          $tableCount = 0;
          while ($row = mysqli_fetch_array($cartNoVatE)) {
            $customer_product_name   = $row['customer_product_name'];
            $salesman_name   = $row['salesman_name'];
            $customer_product_des   = $row['customer_product_des'];
            $customer_product_price   = $row['customer_product_price'];
            $order_num   = $row['order_num'];
            $date   = $row['date'];
            $customer_product_exp  = $row['customer_product_exp'];
            $customer_product_qty  = $row['customer_product_qty'];
            $customer_product_code  = $row['customer_product_code'];
            $TotalSales  = $row['TotalSales'];
            $TotalQty  = $row['TotalQty'];
            $tableCount++;

                                  // calculate total and vat
            $bs_compute = $customer_product_price * $TotalQty;
            $bs_compute_total += $customer_product_price * $TotalQty;

            $bs_vat_value = $bs_compute_total - ($bs_compute_total/(1+($vatPercent/100)));

            ?>

            <tr>
              <td><?php echo sprintf('%08d',$order_num); ?></td>
              <td><?php echo $salesman_name; ?></td>
              <td><?php echo $date; ?></td>
              <td><?php echo $customer_product_code; ?></td>
              <td><?php echo $customer_product_name; ?></td>
              <td><?php echo $customer_product_des; ?></td>
              <td><?php echo $customer_product_exp; ?></td>
              <td><?php echo $TotalQty; ?></td>
              <td>₱ <?php echo number_format($customer_product_price, 2); ?></td>
              <td>₱ <?php echo number_format($TotalSales, 2); ?></td>
            </tr>

            <?php }?>
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

            ₱ <?php echo number_format($bs_compute_total - $bs_vat_value,2); ?> <br>
            ₱ <?php echo number_format($bs_vat_value, 2); ?> <br> 
            <strong>
              ₱ <?php echo number_format($bs_compute_total,2); ?> <br>
            </strong>
          </div>
        </div>


        <!-- END OF BAESA -->
        <hr>


        <h3>Fairview Branch</h3>
        <h4>Products Sold:</h4>
        <table class="table table-hover table-striped table-condensed" id="orderNo">
          <thead>
            <tr>
              <th>Order #</th>
              <th>Salesman Name</th>
              <th>Date of Placement</th>
              <th>Product Code</th>
              <th>Product Name </th>
              <th>Product Description </th>
              <th>Expiry Date </th>
              <th class="text-right">Quantity </th>
              <th class="text-right">Unit Price </th>
              <th class="text-right">Total </th>
            </tr>
          </thead>
          <tbody>
            <?php 

            $cartNoVat = "SELECT DISTINCT fv_customer.*, 
            sum(customer_product_qty * customer_product_price) as TotalSales,
            sum(customer_product_qty) AS TotalQty, 
            fv_orders.*
            FROM fv_customer 
            INNER JOIN fv_orders ON fv_orders.order_num = fv_customer.customer_sws_id
            WHERE fv_orders.status = 'Completed' 
            AND fv_orders.date BETWEEN '$dateFrom' AND '$dateTo'
            GROUP BY customer_sws_id, customer_product_code";
            $cartNoVatE = mysqli_query($connection, $cartNoVat);

            $tableCount = 0;
            while ($row = mysqli_fetch_array($cartNoVatE)) {
              $customer_product_name   = $row['customer_product_name'];
              $salesman_name   = $row['salesman_name'];
              $customer_product_des   = $row['customer_product_des'];
              $customer_product_price   = $row['customer_product_price'];
              $order_num   = $row['order_num'];
              $date   = $row['date'];
              $customer_product_exp  = $row['customer_product_exp'];
              $customer_product_qty  = $row['customer_product_qty'];
              $customer_product_code  = $row['customer_product_code'];
              $TotalSales2  = $row['TotalSales'];
              $TotalQty  = $row['TotalQty'];
              $tableCount++;

                                    // calculate total and vat
              $fv_compute = $customer_product_price * $TotalQty;
              $fv_compute_total += $customer_product_price * $TotalQty;

              $fv_vat_value = $fv_compute_total - ($fv_compute_total/(1+($vatPercent/100)));

              ?>

              <tr>
                <td><?php echo sprintf('%08d',$order_num); ?></td>
                <td><?php echo $salesman_name; ?></td>
                <td><?php echo $date; ?></td>
                <td><?php echo $customer_product_code; ?></td>
                <td><?php echo $customer_product_name; ?></td>
                <td><?php echo $customer_product_des; ?></td>
                <td><?php echo $customer_product_exp; ?></td>
                <td><?php echo $TotalQty; ?></td>
                <td>₱ <?php echo number_format($customer_product_price, 2); ?></td>
                <td>₱ <?php echo number_format($TotalSales2, 2); ?></td>
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

              ₱ <?php echo number_format($fv_compute_total - $fv_vat_value,2); ?> <br>
              ₱ <?php echo number_format($fv_vat_value, 2); ?> <br> 
              <strong>
                ₱ <?php echo number_format($fv_compute_total,2); ?> <br>
              </strong>
            </div>
          </div>


          <h3>Tondo Branch</h3>
          <h4>Products Sold:</h4>
          <table class="table table-hover table-striped table-condensed" id="orderNo">
            <thead>
              <tr>
                <th>Order #</th>
                <th>Salesman Name</th>
                <th>Date of Placement</th>
                <th>Product Code</th>
                <th>Product Name </th>
                <th>Product Description </th>
                <th>Expiry Date </th>
                <th class="text-right">Quantity </th>
                <th class="text-right">Unit Price </th>
                <th class="text-right">Total </th>
              </tr>
            </thead>
            <tbody>
              <?php 

              $cartNoVat = "SELECT DISTINCT td_customer.*, 
              sum(customer_product_qty * customer_product_price) as TotalSales,
              sum(customer_product_qty) AS TotalQty, 
              td_orders.*
              FROM td_customer 
              INNER JOIN td_orders ON td_orders.order_num = td_customer.customer_sws_id
              WHERE td_orders.status = 'Completed' 
              AND td_orders.date BETWEEN '$dateFrom' AND '$dateTo'
              GROUP BY customer_sws_id, customer_product_code";
              $cartNoVatE = mysqli_query($connection, $cartNoVat);

              $tableCount = 0;
              while ($row = mysqli_fetch_array($cartNoVatE)) {
                $customer_product_name   = $row['customer_product_name'];
                $salesman_name   = $row['salesman_name'];
                $customer_product_des   = $row['customer_product_des'];
                $customer_product_price   = $row['customer_product_price'];
                $order_num   = $row['order_num'];
                $date   = $row['date'];
                $customer_product_exp  = $row['customer_product_exp'];
                $customer_product_qty  = $row['customer_product_qty'];
                $customer_product_code  = $row['customer_product_code'];
                $TotalSales3  = $row['TotalSales'];
                $TotalQty  = $row['TotalQty'];
                $tableCount++;

                                      // calculate total and vat
                $td_compute = $customer_product_price * $TotalQty;
                $td_compute_total += $customer_product_price * $TotalQty;

                $td_vat_value = $td_compute_total - ($td_compute_total/(1+($vatPercent/100)));

                ?>

                <tr>
                  <td><?php echo sprintf('%08d',$order_num); ?></td>
                  <td><?php echo $salesman_name; ?></td>
                  <td><?php echo $date; ?></td>
                  <td><?php echo $customer_product_code; ?></td>
                  <td><?php echo $customer_product_name; ?></td>
                  <td><?php echo $customer_product_des; ?></td>
                  <td><?php echo $customer_product_exp; ?></td>
                  <td><?php echo $TotalQty; ?></td>
                  <td>₱ <?php echo number_format($customer_product_price, 2); ?></td>
                  <td>₱ <?php echo number_format($TotalSales3, 2); ?></td>
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

                ₱ <?php echo number_format($td_compute - $td_vat_value,2); ?> <br>
                ₱ <?php echo number_format($td_vat_value, 2); ?> <br> 
                <strong>
                  ₱ <?php echo number_format($td_compute,2); ?> <br>
                </strong>
              </div>
            </div>


            <div class="row">
              <div class="col-xs-3">
                <p>
                  <strong>
                    Interbranch Total Sales :  <br>
                  </strong>
                </p>
              </div>
              <div class="col-xs-2">
                <strong>
                  ₱ <?php echo number_format($bs_compute_total + $fv_compute_total + $td_compute_total,2); ?> <br>
                </strong>
              </div>
            </div>

            <a href="reports.php" class="btn btn-default btn-lg no-print">Back</a>
            <button type="button" class="btn btn-default btn-lg pull-right no-print" onclick="window.print()"><span class="glyphicon glyphicon-print"></span> Print</button>

          </div>
          <br>
        </div>

      </body>
      </html>
