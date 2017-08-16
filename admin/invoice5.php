<?php include '../includes/db.php'; ?>
<?php ob_start(); ?>
<?php session_start(); ?>
<?php 
//Prefix
$prefix = strtolower($_SESSION['branch']) .'_';
$capitalPrefix = strtoupper($_SESSION['branch']);

//Admin Login Verify
if ($_SESSION['user_role'] != 'Admin') {
 header("LOCATION: ../index.php");   
}


//SELECT ID VIA GET
if (isset($_GET['id'])) {
  $id = $_GET['id'];

//Initialize sws_number
  $init = mysqli_query($connection, "SELECT * FROM {$prefix}sws WHERE sws_number = $id;");
  while ($row = mysqli_fetch_array($init)) {
    $swsNumber = $row['sws_number'];
  }

//SELECT CUSTOMER
  $sqlSelect = "SELECT * FROM {$prefix}sws WHERE sws_number = $id";
  $sqlExec = mysqli_query($connection, $sqlSelect);


  while ( $row = mysqli_fetch_array($sqlExec)) {

    $sws_number = $row['sws_number'];
    $date       = $row['date'];
    $sws_smname = $row['sws_smname'];
    $sws_salesman = $row['sws_salesman'];
    $sws_route   = $row['sws_route'];
    $sws_driver  = $row['sws_driver'];
    $sws_plate   = $row['sws_plate'];
    $sws_vehicle = $row['sws_vehicle'];
    $sws_load    = $row['sws_load'];
    $sws_productid = $row['sws_productid'];
    $sws_quantity  = $row['sws_quantity'];
  }

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
          <h2>SALESMAN'S WITHDRAWAL SLIP</h2>
        </div>

        <div class="text-right">
          <h4>C <strong>NO.</strong> <?php echo sprintf('%08d', $sws_number); ?></h4>
        </div>
      </div>
      <div class="row">
        <div class="row text-left">
          <div class="col-xs-2">
            <p>
                Salesman (Full Name) : <br>
                Employee No. : <br>
                Route No. : <br><br>
                Date :
            </p>
          </div>
          <div class="col-xs-2">
            <strong>
             <?php echo ucwords($sws_smname); ?> <br>
             <?php echo sprintf('%08d', $sws_salesman); ?> <br>
             <?php echo $sws_route; ?><br> 
             <br>
             <?php echo $date; ?>
             </strong>
          </div>
        </div>

      </div>
      <!-- / end client details section -->
      <table class="table table-bordered table-condensed">
        <thead>
          <tr>
            <th width="20%">Product Name </th>
            <th width="25%">Description </th>
            <th>Quantity </th>
            <th>Price </th>
            <th>Sub Total </th>
          </tr>
        </thead>
        <tbody>
          <?php 

          $cartTotal = 0;
          $cartTotal2 = 0;
          $cartFinal = 0;
          $cartVat = 0;
          $subTotal = 0;

          $invoiceList = "SELECT s.*, sws.* FROM {$prefix}sws as sws INNER JOIN {$prefix}settings as s WHERE sws_number = $id;";
          $cartNoVatE = mysqli_query($connection, $invoiceList);

          while ($row = mysqli_fetch_array($cartNoVatE)) {
            $cartpro_name   = $row['sws_proname'];
            $cartpro_desc   = $row['sws_prodesc'];
            $cartpro_sell   = $row['sws_unitprice'];
            $cartpro_exp  = $row['sws_proexp'];
            $cartpro_qty  = $row['sws_quantity'];
            $cartpro_exp  = $row['sws_proexp'];
            $vat_percent  = $row['vat_percent'];   

            $cartTotal = $cartpro_qty * $cartpro_sell;
            $cartTotal2 += $cartpro_qty * $cartpro_sell;

            $cartVat = $cartTotal2 - ($cartTotal2 / (1+($vat_percent/100)));
            $subTotal = $cartTotal2 - $cartVat;

            ?>

            <tr>
              <td><?php echo $cartpro_name; ?></td>
              <td><?php echo $cartpro_name; ?></td>
              <td><?php echo $cartpro_desc; ?></td>
              <td><?php echo $cartpro_exp; ?></td>
              <td><?php echo $cartpro_qty; ?></td>
              <td>₱ <?php echo number_format($cartpro_sell, 2); ?></td>
              <td>₱ <?php echo number_format($cartTotal, 2); ?></td>
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
          
          ₱ <?php echo number_format($subTotal,2); ?> <br>
          ₱ <?php echo number_format($cartVat, 2); ?> <br>
          <strong>
            ₱ <?php echo number_format($cartTotal2,2); ?> <br>
          </strong>
        </div>
      </div>

      <hr>
      <div class="row">
        <div class="row text-left">
          <div class="col-xs-2">
            <p>
                Driver (Full Name) : <br>
                Vehicle No. : <br>
                Plate No. : <br>
                Load No :
            </p>
          </div>

          <div class="col-xs-2">
            <strong>
             <?php echo ucwords($sws_driver); ?> <br>
             <?php echo $sws_vehicle; ?>         <br>
             <?php echo $sws_route; ?>              <br> 
             <?php echo $sws_load; ?>
             </strong>
          </div>

          <div class="row">
            <div class="col-xs-6 col-xs-offset-1">
              <p class="text-center">
                  Received above goods for sales on comission proceeds of sales to be remitted to the sales office or goods to be returned if not sold.
              </p>

                  <br>

              <div class="col-xs-offset-4">
                <u style="font-size:12px;">(SIGNATURE OVER PRINTED NAME)</u>
                <p style="font-size:12px; margin-left: 78px;">DRIVER</p>
              </div>

            </div>
          </div>

        </div>

        <div class="col-xs-3">
          <u style="font-size:12px;">(SIGNATURE OVER PRINTED NAME)</u>
          <p style="font-size:12px; margin-left: 64px;">SALESMAN</p>
        </div>

      </div>


     <a href="javascript:history.back()" class="btn btn-default btn-lg no-print">Back</a>
      <button type="button" class="btn btn-default btn-lg pull-right no-print" onclick="window.print()"><span class="glyphicon glyphicon-print"></span> Print</button>
      

      </div>
      <br>
    </div>
  
  </body>
</html>
