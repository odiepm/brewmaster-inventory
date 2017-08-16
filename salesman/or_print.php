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
//Admin Login Verify
if ($_SESSION['user_role'] != 'Salesman') {
 header("LOCATION: ../index.php");   
}


//extra
         $cartCount = 0;
         $computeVATValue = 0;
         $cartCount = 0;
         $compute1 = 0;
         $totalAmountCase = 0;
         $totalAmountCase1 = 0;
         $totalAmountCaseVATValue = 0;
         $totalAmountCaseVAT = 0;


//SELECT ID VIA GET
if (isset($_GET['id'])) {
  $id = $_GET['id'];

//GET SWS INFO VIA customer_distribution_id 
  $getSWS = "SELECT * FROM {$prefix}customer WHERE customer_distribution_id = $id";
  $getSWSE = mysqli_query($connection, $getSWS);

  while ($row = mysqli_fetch_array($getSWSE)) {
    $customer_sws_id = $row['customer_sws_id'];
  }

  $getSWSInfo = "SELECT * FROM {$prefix}sws WHERE sws_number = $customer_sws_id";
  $getSWSInfoE = mysqli_query($connection, $getSWSInfo);

  while ($row = mysqli_fetch_array($getSWSInfoE)) {
    $date       = $row['date'];
    $sws_smname = $row['sws_smname'];

  }

//******END OF GET SWS INFO***********

//Initialize sws_number
  $init = mysqli_query($connection, "SELECT * FROM {$prefix}sws WHERE sws_number = $id;");
  while ($row = mysqli_fetch_array($init)) {
    $swsNumber = $row['sws_number'];
  }

  //ROW COUNT IF DISPLAY
  $countProduct = "SELECT COUNT(*) rowCount FROM {$prefix}customer WHERE customer_distribution_id = $id 
  AND customer_product_id >=1 AND customer_product_qty >= 1";
  $countProductE = mysqli_query($connection, $countProduct);


  while ($row = mysqli_fetch_array($countProductE)) {
    $count_product = $row['rowCount']; #CHECK IF PRODUCT HAS COUNT
  }

  //ROW COUNT IF display(CASE)
  $countCase = "SELECT COUNT(*) rowCountC FROM {$prefix}customer WHERE customer_distribution_id = $id
  AND customer_case_id >=1  AND customer_product_qty >= 1";
  $countCaseE = mysqli_query($connection, $countCase);

  while ($row = mysqli_fetch_array($countCaseE)) {
    $count_case = $row['rowCountC']; #CHECK IF PRODUCT HAS COUNT
  }


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
          <h2>Official Receipt</h2>
        </div>

        <div class="text-right">
          <h4>OR <strong>NO.</strong> <?php echo sprintf('%08d', $id); ?></h4>
        </div>
      </div>
      <div class="row">
        <div class="row text-left">
          <div class="col-xs-2">
            <p>
              Salesman (Full Name) : <br>
              Date :
            </p>
          </div>
          <div class="col-xs-2">
            <strong>
             <?php echo ucwords($sws_smname); ?> <br>
             <?php echo $date; ?>
           </strong>
         </div>
       </div>

     </div>
     <?php if ($count_case >= 1) { ?>
      
     <h4>Case List:</h4>
     <!-- / end client details section -->
     <table class="table table-hover" id="tae">
      <thead>
        <tr>
          <th>Case Name</th>
          <th>Case Description</th>
          <th>Case Expiry Date</th>
          <th>Case Quantity</th>
          <th>Case Price</th>
          <th>Total Amount</th>
          <th>Empty Quantity</th>
        </tr>
      </thead>
      <tbody>


        <?php 

        $selectCart = "SELECT * FROM {$prefix}customer WHERE customer_distribution_id = $id AND customer_case_id >= 1";
        $execSelectCart = mysqli_query($connection, $selectCart);
        while ($row = mysqli_fetch_array($execSelectCart)) {

          $customer_product_name = $row['customer_product_name'];
          $customer_product_des = $row['customer_product_des'];
          $customer_product_code = $row['customer_product_code'];
          $customer_product_exp = $row['customer_product_exp'];
          $customer_product_qty = $row['customer_product_qty'];
          $customer_product_price = $row['customer_product_price'];

          $totalAmountCase = $customer_product_price * $customer_product_qty;
          $totalAmountCase1 += $customer_product_price * $customer_product_qty;

          $totalAmountCaseVAT = ($totalAmountCase1*(1+($vatPercent/100)));
          $totalAmountCaseVATValue = $totalAmountCase1 - ($totalAmountCase1/(1+($vatPercent/100)));


          $cartCount++;
          ?>

          <tr>
            <td><?php echo $customer_product_name; ?></td>
            <td><?php echo $customer_product_des; ?></td>
            <td><?php echo $customer_product_exp; ?></td>
            <td><?php echo $customer_product_qty; ?></td>
            <td>₱ <?php echo $customer_product_price; ?></td>
            <td>₱ <?php echo number_format($totalAmountCase, 2); ?></td>
          </tr>

          <?php } ?>
        </tbody>
      </table>
      <hr>
      <!-- ***********************CASE********************** -->
      <?php } ?>

      <?php if ($count_product >= 1) { ?>
      <h4>Product List:</h4>
      <table class="table table-hover" id="tae">
        <thead>
          <tr>
            <th>Product Name</th>
            <th>Description</th>
            <th>Expiry Date</th>
            <th>Quantity</th>
            <th>Price per Unit</th>
            <th>Total Amount</th>
            <th>Empty Quantity</th>
          </tr>
        </thead>
        <tbody>


         <?php 

         $selectCart = "SELECT * FROM {$prefix}customer WHERE customer_distribution_id = $id 
                        AND customer_product_id >= 1 ";
         $execSelectCart = mysqli_query($connection, $selectCart);

         while ($row = mysqli_fetch_array($execSelectCart)) {

          $customer_product_name = $row['customer_product_name'];
          $customer_product_des = $row['customer_product_des'];
          $customer_product_code = $row['customer_product_code'];
          $customer_product_exp = $row['customer_product_exp'];
          $customer_product_qty = $row['customer_product_qty'];
          $customer_product_price = $row['customer_product_price'];
          $customer_empty_qty = $row['customer_empty_qty'];

           $compute = $customer_product_price * $customer_product_qty;
           $compute1 += $customer_product_price * $customer_product_qty;
           $totalAmount = number_format((float)$compute, 2, '.', '');

           $computeVATValue = $compute1 - ($compute1/(1+($vatPercent/100)));

           $cartCount++;
           ?>

           <tr>
             <td><?php echo $customer_product_name; ?></td>
             <td><?php echo $customer_product_des; ?></td>
             <td><?php echo $customer_product_exp; ?></td>
             <td><?php echo $customer_product_qty; ?></td>
             <td>₱ <?php echo number_format($customer_product_price, 2); ?></td>
             <td>₱ <?php echo number_format($compute, 2); ?></td>
             <td> <?php echo $customer_empty_qty; ?></td>
           </tr>

           <?php }  ?>
         </tbody>
       </table>

       <hr>
       <?php } ?>
       <div class="row text-right">
        <div class="col-xs-2 col-xs-offset-8">
          <p>
            <strong>
              Sub Total : <br>
              VAT <?php echo $vatPercent; ?>% : <br>
              Total : <br>
            </strong>
          </p>
        </div>
        <div class="col-xs-2">

          ₱ <?php echo number_format($compute1 + $totalAmountCaseVAT-($totalAmountCaseVATValue + $computeVATValue),2); ?> <br>
          ₱ <?php echo number_format($totalAmountCaseVATValue + $computeVATValue, 2); ?> <br> 
          <strong>
            ₱ <?php echo number_format($compute1 + $totalAmountCaseVAT,2); ?> <br>
          </strong>
        </div>
      </div>

      <hr>
      <div class="row">
        <div class="row text-left">
          <div class="col-xs-2">
            <p>
              Customer (Full Name) : <br>
              Address : <br>
              Contact No : <br>
            </p>
          </div>
          
          <?php 

            //GET CUSTOMER INFO
          $getCustomerInfo = "SELECT customer_name, customer_address, customer_contact 
          FROM {$prefix}customer WHERE customer_distribution_id = $id";
          $getCustomerInfoE = mysqli_query($connection, $getCustomerInfo);

          while ($row = mysqli_fetch_array($getCustomerInfoE)) {
            $customer_name = $row['customer_name'];
            $customer_address = $row['customer_address'];
            $customer_contact = $row['customer_contact'];
          }

          ?>


          <div class="col-xs-2">
            <strong>
             <?php echo ucwords($customer_name); ?> <br>
             <?php echo $customer_address; ?>         <br>
             <?php echo $customer_contact; ?>              <br> 
           </strong>
         </div>

         <div class="row">
          <div class="col-xs-6 col-xs-offset-1">

            <br>

            <div class="col-xs-offset-4">
              <u style="font-size:12px;">(SIGNATURE OVER PRINTED NAME)</u>
              <p style="font-size:12px; margin-left: 78px;">Customer</p>
            </div>

          </div>
        </div>

      </div>

      <div class="col-xs-3">
        <u style="font-size:12px;">(SIGNATURE OVER PRINTED NAME)</u>
        <p style="font-size:12px; margin-left: 64px;">SALESMAN</p>
      </div>

    </div>


    <a href="javascript:history.back()" class="btn btn-default btn-lg no-print">Back to OR List</a>
    <button type="button" class="btn btn-default btn-lg pull-right no-print" onclick="window.print()"><span class="glyphicon glyphicon-print"></span> Print</button>


  </div>
  <br>
</div>

</body>
</html>
