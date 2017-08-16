<?php include 'includes/admin_header.php'; ?>

<div class="row">
  <div class="col-md-12">
    <h1> Select Desired Branch </h1>
    <hr>
    <div class="panel panel-default">
      <div class="panel-body">


       <?php if ($capitalPrefix == 'bs') { #IF CURRENT ADMIN IS ON BAESA BRANCH ?> 
       <section class="col-md-6">
        <h3>Fairview Branch</h3>
        <p class="text-muted">Request Stock Transfer to <strong>Fairview Branch</strong></p><br>
        <a href="stock_select.php?branch=fv" class="btn btn-warning btn-block">Select</a>
        <hr>
      </section>

      <section class="col-md-6">
        <h3>Tondo Branch</h3>
        <p class="text-muted">Request Stock Transfer to <strong>Tondo Branch</strong></p><br>
        <a href="stock_select.php?branch=td" class="btn btn-danger btn-block">Select</a>
        <hr>
      </section>
      <?php } elseif ($capitalPrefix == 'td') { #IF CURRENT ADMIN IS ON TONDO BRANCH ?>
      <section class="col-md-6">
        <h3>Baesa Branch</h3>
        <p class="text-muted">Request Stock Transfer to <strong>Baesa Branch</strong></p><br>
        <a href="stock_select.php?branch=bs" class="btn btn-primary btn-block">Select</a>
        <hr>
      </section>

      <section class="col-md-6">
        <h3>Fairview Branch</h3>
        <p class="text-muted">Request Stock Transfer to <strong>Fairview Branch</strong></p><br>
        <a href="stock_select.php?branch=fv" class="btn btn-warning btn-block">Select</a>
        <hr>
      </section>
      <?php } elseif ($capitalPrefix == 'fv') { ?>
      <section class="col-md-6">
        <h3>Baesa Branch</h3>
        <p class="text-muted">Request Stock Transfer to <strong>Baesa Branch</strong></p><br>
        <a href="stock_select.php?branch=bs" class="btn btn-primary btn-block">Select</a>
        <hr>
      </section>

      <section class="col-md-6">
        <h3>Tondo Branch</h3>
        <p class="text-muted">Request Stock Transfer to <strong>Tondo Branch</strong></p><br>
        <a href="stock_select.php?branch=td" class="btn btn-danger btn-block">Select</a>
        <hr>
      </section>
      <?php } ?>
      
      <div class="col-md-6">
        <a href="stock_transfer.php" class="btn btn-default">Back</a>
      </div>
    </div>
  </div>
</div>

</div>

<?php 

$checkStock = "SELECT * FROM stock_transfer;";
$checkQ = mysqli_query($connection, $checkStock);

$currentON = 0;
$count = 0;

while ($row = mysqli_fetch_array($checkQ)) {
  $currentON = $row['transfer_number'];
}

while ($count <= $currentON) {
  $count++;
}

if (isset($_GET['branch']) && $_GET['branch'] == 'bs' || $_GET['branch'] == 'fv' || $_GET['branch'] == 'td')  {
  $branch = $_GET['branch'];
  $branchPref = $branch.'_';

  if (isset($_POST['addReq']) && $_POST['addReq']=="Confirm Request") {

   foreach($_POST['qtyBuy'] as $index=>$value) {
     if ($value > 0) {

      $cartProd_id = $_POST['product_id'][$index];
      $product_code = $_POST['product_code'][$index];
      $unit_per = $_POST['unit_per'][$index];

      $addQuery = "INSERT INTO stock_transfer (transfer_number, transfer_product_code, transfer_frombranch, transfer_tobranch, transfer_product_id, transfer_quantity, transfer_date, transfer_status, st_unit_per) 
      VALUES ($count, '$product_code', '$capitalPrefix', '$branch', $cartProd_id, $value, '$expiryDateMin', 'Pending', $unit_per);";

      $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername requested a stock transfer to branch: $branch', '$activityDate');";
      $execLog = mysqli_query($connection, $queryLog);

      $execQuery  = mysqli_query($connection, $addQuery);
      // header("Refresh: 0; url=stock_select.php?branch=");

    }  

  }

  if(!$execQuery) {
   die(mysqli_error($connection));
 } else {
  $msg ="<div class='alert alert-success'><strong>Request</strong> is succesful. You request has been added to <a href='stock_manage.php'>Manage Stock Requests</a></div>";
  echo $msg;
}

}
?>
<?php if ($branch == 'bs') { 
  echo '<div class="panel panel-primary">';
} elseif ($branch == 'fv') {
  echo '<div class="panel panel-warning">';
} elseif ($branch == 'td') {
  echo '<div class="panel panel-danger">';
}
?>

<div class="panel-heading">
  <strong>
    <span class="glyphicon glyphicon-th"></span>
    <span>Receive Order</span>
  </strong>
</div>

<div class="panel-body">
  <form action="" method="POST">

    <div class="col-md-6">
      <div class="form-group">
        <label for="">Branch Name:</label>

        <?php if ($branch == 'bs') { ?>
        <input type="text" name="report_supplier" class="form-control" value="Baesa" required readonly>
        <?php } ?>

        <?php if ($branch == 'fv') { ?>
        <input type="text" name="report_supplier" class="form-control" value="Fairview" required readonly>
        <?php } ?>

        <?php if ($branch == 'td') { ?>
        <input type="text" name="report_supplier" class="form-control" value="Tondo" required readonly>
        <?php } ?>

      </div>
    </div>
    <div class="col-md-12">
      <h3>Available Stocks</h3>
      <hr>
      <!-- Product Table Start -->
      <table class="table table-striped table-bordered table-hover table-condensed" id="example">
       <thead>
         <tr>
           <th class="text-center">#</th>
           <th>Product Code</th>
           <th>Product Name</th>
           <th>Description</th>
           <th>Expiry Date</th>
           <th>Price</th>
           <th>In Stock</th>
           <th style="width: 20%">Request Quantity</th>
         </tr>
       </thead>


       <tbody>
         <?php 
         $query = "SELECT * FROM {$branchPref}products WHERE quantity > 0;";
         $exec = mysqli_query($connection, $query);
         $a = 1;
         $b = 1;

         $count = 0;
         while ($row = mysqli_fetch_array($exec)) {
           $product_id = $row['product_id'];
           $product_name = $row['product_name'];
           $product_code = $row['product_code'];
           $product_price = $row['sell_price'];
           $description = $row['description'];
           $product_quantity = $row['quantity'];
           $expiry_date = $row['expiry_date'];
           $unit_per = $row['unit_per'];
           $count++;
           
           ?>
           <tr>
             <td class="text-center"><?php echo $product_id; ?>
               <input type="hidden" name="product_id[]" value="<?php echo $product_id; ?>">
             </td>
             <td>
              <?php echo $product_code; ?>
              <input type="hidden" name="product_code[]" value="<?php echo $product_code; ?>">
              </td>
             <td><?php echo $product_name; ?></td>
             <td><?php echo $description; ?></td>
              <input type="hidden" name="unit_per[]" value="<?php echo $unit_per; ?>">
             <td><?php echo $expiry_date; ?></td>
             <td>₱ <?php echo number_format($product_price, 2); ?></td>
             <td><?php echo $product_quantity; ?></td>
             <td><input type="number" name="qtyBuy[]" id="<?php echo "qtyBuy" . $b++; ?>" min="1" max="<?php echo $product_quantity; ?>"></td>
           </tr>
           <?php } ?>
         </tbody>
       </table>
       <div class="form-group">
         <?php if ($count <= 0) { ?>
         <button type="button" class="btn btn-success pull-right disabled">Confirm Request</button>
         <?php } else { ?>
         <a class="btn btn-success btn-ok" data-toggle="modal" data-target="#confirm-add">Confirm Request</a>
         <?php } ?>
       </div>

       <!-- MODAL FOR UPDATE -->
       <div class="modal fade" id="confirm-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h3>Confirm Request</h3>
            </div>
            <div class="modal-body">
              Are you sure you want to confirm request?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <input type="submit" name="addReq" value="Confirm Request" class="btn btn-info btn-ok">
            </div>
          </div>
        </div>
      </div>
      <?php } ?> 
      <?php include 'includes/admin_footer.php'; ?>
