s<?php include '../includes/db.php'; ?>
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

//CHECK IF CASE & PRODUCTS RETURNS A ROW
$checkCase = "SELECT * FROM {$prefix}case WHERE case_empties > 0";
$checkCaseE = mysqli_query($connection, $checkCase);

if (mysqli_num_rows($checkCaseE) > 0) {
  $caseIs = 1;
} else {
  $caseIs = 0;
}

$checkProd = "SELECT * FROM {$prefix}products WHERE empties > 0";
$checkProdE = mysqli_query($connection, $checkProd);

if (mysqli_num_rows($checkProdE) > 0) {
  $prodIs = 1;
} else {
  $prodIs = 0;
}
//**************************END*******************************


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
          <h2>Empties</h2>
        </div>


      </div>
      <?php 
          if ($caseIs == 1) { 
      ?>
      <h4>Case List:</h4>
      <!-- / end client details section -->
      <table class="table table-hover" id="tae">
        <thead>
          <tr>
            <th class="text-center">Case ID</th>
            <th class="text-center">Case Name</th>
            <th class="text-center">Case Description</th>
            <th class="text-center">Case Empties</th>
          </tr>
        </thead>
        <tbody>


          <?php 

          $selectCart = "SELECT * FROM {$prefix}case";
          $execSelectCart = mysqli_query($connection, $selectCart);

          while ($row = mysqli_fetch_array($execSelectCart)) {

            $case_product_code = $row['case_product_code'];
            $case_product_name  = $row['case_product_name'];
            $case_expiry = $row['case_expiry'];
            $case_desc = $row['case_desc'];
            $case_empties = $row['case_empties'];


            ?>

            <tr>
              <td class="text-center"><?php echo $case_product_code; ?></td>
              <td class="text-center"><?php echo $case_product_name ; ?></td>
              <td class="text-center"><?php echo $case_desc; ?></td>
              <td class="text-center"><?php echo $case_empties; ?></td>
            </tr>

            <?php } ?>
          </tbody>
        </table>
        <hr>
        <!-- ***********************CASE********************** -->
        <?php } ?>
        
        <?php 
          if ($prodIs == 1) {
         ?>
        <!-- START OF PRODUCT LIST h4 -->
        <h4>Product List:</h4>
        <table class="table table-hover" id="tae">
         <thead>
           <tr>
             <th class="text-center">Product ID</th>
             <th class="text-center">Product Name</th>
             <th class="text-center">Product Description</th>
             <th class="text-center">Product Empties</th>
           </tr>
         </thead>
         <tbody>


           <?php 

           $selectCart = "SELECT * FROM {$prefix}products";
           $execSelectCart = mysqli_query($connection, $selectCart);

           while ($row = mysqli_fetch_array($execSelectCart)) {

             $product_code = $row['product_code'];
             $product_name  = $row['product_name'];
             $description = $row['description'];
             $empties = $row['empties'];


             ?>

             <tr>
               <td class="text-center"><?php echo $product_code; ?></td>
               <td class="text-center"><?php echo $product_name ; ?></td>
               <td class="text-center"><?php echo $description; ?></td>
               <td class="text-center"><?php echo $empties; ?></td>
             </tr>

             <?php } ?>
           </tbody>
         </table>
         <?php } ?>
         <hr>

      <a href="javascript:history.back()" class="btn btn-default btn-lg no-print">Back to Withdrawal</a>
      <button type="button" class="btn btn-default btn-lg pull-right no-print" onclick="window.print()"><span class="glyphicon glyphicon-print"></span> Print</button>


    </div>
    <br>
  </div>

</body>
</html>
