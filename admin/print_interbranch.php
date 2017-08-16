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
$displayDate = date('m/d/Y');

//Retrieve VAT%
$getVat = "SELECT * FROM bs_settings;";
$getVatQ = mysqli_query($connection, $getVat);
while ($row = mysqli_fetch_array($getVatQ)) {
  $vatPercent = $row['vat_percent'];
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
          <h2>Interbranch Sales Report</h2>
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
          $compute1 = 0;
          $cartNoVat = "SELECT DISTINCT bs_customer.*, 
          sum(customer_product_qty * customer_product_price) as TotalSales,
          sum(customer_product_qty) AS TotalQty, 
          bs_orders.*
          FROM bs_customer 
          INNER JOIN bs_orders ON bs_orders.order_num = bs_customer.customer_sws_id
          WHERE bs_orders.status = 'Completed' 
          AND bs_orders.date = '03/13/2017'
          GROUP BY customer_sws_id, customer_product_code";
          $cartNoVatE = mysqli_query($connection, $cartNoVat);
          $computeVATValue = 0;
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
            $compute = $customer_product_price * $TotalQty;
            $compute1 += $customer_product_price * $TotalQty;
            $totalAmount = number_format((float)$compute, 2, '.', '');

            $computeVATValue = $compute1 - ($compute1/(1+($vatPercent/100)));

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

            ₱ <?php echo number_format($compute1 - $computeVATValue,2); ?> <br>
            ₱ <?php echo number_format($computeVATValue, 2); ?> <br> 
            <strong>
              ₱ <?php echo number_format($compute1,2); ?> <br>
            </strong>
          </div>
        </div>

        <hr>

        <!-- Fairview Branch Table -->
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
            AND fv_orders.date = '$displayDate'
            GROUP BY customer_sws_id, customer_product_code";
            $cartNoVatE = mysqli_query($connection, $cartNoVat);
            $computeVATValuebs = 0;
            $tableCount = 0;
            $compute1bs = 0;
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
              $TotalSalesBs  = $row['TotalSales'];
              $TotalQtyBs  = $row['TotalQty'];
              $tableCount++;

                                    // calculate total and vat
              $computebs = $customer_product_price * $TotalQtyBs;
              $compute1bs += $customer_product_price * $TotalQtyBs;
              $totalAmountbs = number_format((float)$compute1bs, 2, '.', '');

              $computeVATValuebs = $compute1bs - ($compute1bs/(1+($vatPercent/100)));

              ?>

              <tr>
                <td><?php echo sprintf('%08d',$order_num); ?></td>
                <td><?php echo $salesman_name; ?></td>
                <td><?php echo $date; ?></td>
                <td><?php echo $customer_product_code; ?></td>
                <td><?php echo $customer_product_name; ?></td>
                <td><?php echo $customer_product_des; ?></td>
                <td><?php echo $customer_product_exp; ?></td>
                <td><?php echo $TotalQtyBs; ?></td>
                <td>₱ <?php echo number_format($customer_product_price, 2); ?></td>
                <td>₱ <?php echo number_format($TotalSalesBs, 2); ?></td>
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

              ₱ <?php echo number_format($compute1bs - $computeVATValuebs,2); ?> <br>
              ₱ <?php echo number_format($computeVATValuebs, 2); ?> <br> 
              <strong>
                ₱ <?php echo number_format($compute1bs,2); ?> <br>
              </strong>
            </div>
          </div>

          <hr>

          <!-- Tondo Branch Table -->
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
              AND td_orders.date = '$displayDate'
              GROUP BY customer_sws_id, customer_product_code";
              $cartNoVatE = mysqli_query($connection, $cartNoVat);

              $tableCount = 0;
              $compute1td = 0;
              $computeVATValuetd = 0;
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
                $TotalSalestd  = $row['TotalSales'];
                $TotalQtytd  = $row['TotalQty'];
                $tableCount++;

                                    // calculate total and vat
                $computetd = $customer_product_price * $TotalQtytd;
                $compute1td += $customer_product_price * $TotalQtytd;
                $totalAmounttd = number_format((float)$compute, 2, '.', '');

                $computeVATValuetd = $compute1td - ($compute1td/(1+($vatPercent/100)));

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
                  <td>₱ <?php echo number_format($TotalSalestd, 2); ?></td>
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

                ₱ <?php echo number_format($compute1td - $computeVATValuetd,2); ?> <br>
                ₱ <?php echo number_format($computeVATValuetd, 2); ?> <br> 
                <strong>
                  ₱ <?php echo number_format($compute1td,2); ?> <br>
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
                  ₱ <?php echo number_format($compute1 + $compute1bs + $compute1td,2); ?> <br>
                </strong>
              </div>
            </div>

            <a href="javascript:history.back()" class="btn btn-default btn-lg no-print">Back</a>
            <button type="button" class="btn btn-default btn-lg pull-right no-print" onclick="window.print()"><span class="glyphicon glyphicon-print"></span> Print</button>
          </div>
          <br>
        </div>

      </body>
      </html>
