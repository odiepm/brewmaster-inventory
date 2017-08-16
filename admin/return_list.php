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
          <h2>Return List</h2>
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

     <h4>Product List:</h4>
     <table class="table table-hover" id="tae">
      <thead>
        <tr>
          <th>Product Code</th>
          <th>Product Name</th>
          <th>Description</th>
          <th>Expiration Date</th>
          <th>Remaining Quantity</th>
        </tr>
      </thead>
      <tbody>


       <?php 

       $selectCart = "SELECT * FROM {$prefix}sws WHERE sws_number = $id";
       $execSelectCart = mysqli_query($connection, $selectCart);

       $cartCount = 0;
       $computeVATValue = 0;
       while ($row = mysqli_fetch_array($execSelectCart)) {

         $sws_productid = $row['sws_productid'];
         $sws_proname = $row['sws_proname'];
         $sws_prodesc = $row['sws_prodesc'];
         $sws_proexp = $row['sws_proexp'];
         $sws_true_quantity = $row['sws_true_quantity'];

         ?>

         <tr>
           <td><?php echo $sws_productid; ?></td>
           <td><?php echo $sws_proname; ?></td>
           <td><?php echo $sws_prodesc; ?></td>
           <td><?php echo $sws_proexp; ?></td>
           <td><?php echo $sws_true_quantity; ?></td>
         </tr>

         <?php }  ?>
       </tbody>
     </table>

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



     </div>



   </div>


   <a href="completed_orders.php" class="btn btn-default btn-lg no-print">Back to Withdrawal</a>
   <button type="button" class="btn btn-default btn-lg pull-right no-print" onclick="window.print()"><span class="glyphicon glyphicon-print"></span> Print</button>


 </div>
 <br>
</div>

</body>
</html>
