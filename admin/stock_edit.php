<?php include 'includes/admin_header.php'; ?>
<?php 

if (isset($_GET['id'])) {
  $editID = $_GET['id'];
}


 ?>
<div class="row">
  <div class="col-md-12">
    <h1> Select Desired Branch (Edit) </h1>
    <hr>
    <div class="panel panel-default">
      <div class="panel-body">


       <?php if ($capitalPrefix == 'BS') { #IF CURRENT ADMIN IS ON BAESA BRANCH ?> 
       <section class="col-md-6">
        <h3>Fairview Branch</h3>
        <p class="text-muted">Request Stock Transfer to <strong>Fairview Branch</strong></p><br>
        <a href="stock_edit.php?branch=FV&id=<?php echo $editID; ?>" class="btn btn-warning btn-block">Select</a>
        <hr>
      </section>

      <section class="col-md-6">
        <h3>Tondo Branch</h3>
        <p class="text-muted">Request Stock Transfer to <strong>Tondo Branch</strong></p><br>
        <a href="stock_edit.php?branch=TD&id=<?php echo $editID;?>" class="btn btn-danger btn-block">Select</a>
        <hr>
      </section>
      <?php } elseif ($capitalPrefix == 'TD') { #IF CURRENT ADMIN IS ON TONDO BRANCH ?>
      <section class="col-md-6">
        <h3>Baesa Branch</h3>
        <p class="text-muted">Request Stock Transfer to <strong>Baesa Branch</strong></p><br>
        <a href="stock_edit.php?branch=BS&id=<?php echo $editID;?>" class="btn btn-primary btn-block">Select</a>
        <hr>
      </section>

      <section class="col-md-6">
        <h3>Fairview Branch</h3>
        <p class="text-muted">Request Stock Transfer to <strong>Fairview Branch</strong></p><br>
        <a href="stock_edit.php?branch=FV&id=<?php echo $editID;?>" class="btn btn-warning btn-block">Select</a>
        <hr>
      </section>
      <?php } elseif ($capitalPrefix == 'FV') { ?>
      <section class="col-md-6">
        <h3>Baesa Branch</h3>
        <p class="text-muted">Request Stock Transfer to <strong>Baesa Branch</strong></p><br>
        <a href="stock_edit.php?branch=BS" class="btn btn-primary btn-block">Select</a>
        <hr>
      </section>

      <section class="col-md-6">
        <h3>Tondo Branch</h3>
        <p class="text-muted">Request Stock Transfer to <strong>Tondo Branch</strong></p><br>
        <a href="stock_edit.php?branch=TD&id=<?php echo $editID;?>" class="btn btn-danger btn-block">Select</a>
        <hr>
      </section>
      <?php } ?>
      
      <div class="col-md-6">
        <a href="stock_manage.php" class="btn btn-default">Back</a>
      </div>
    </div>
  </div>
</div>

</div>

<?php 


$checkStock = "SELECT * FROM stock_transfer;";
$checkQ = mysqli_query($connection, $checkStock);

if (isset($_GET['branch']) && $_GET['branch'] == 'BS' || $_GET['branch'] == 'FV' || $_GET['branch'] == 'TD')  {
  $branch = $_GET['branch'];
  $branchPref = $branch.'_';

  if (isset($_POST['addReq']) && $_POST['addReq']=="Confirm Request") {
      $deleteQuery = "DELETE FROM stock_transfer WHERE transfer_number = $editID;";
      $deleteEx  = mysqli_query($connection, $deleteQuery);

   foreach($_POST['qtyBuy'] as $index=>$value) {
     if ($value > 0) {

      $cartProd_id = $_POST['product_id'][$index];


      $addQuery = "INSERT INTO stock_transfer (transfer_number, transfer_frombranch, transfer_tobranch, transfer_product_id, transfer_quantity, transfer_date, transfer_status) 
      VALUES ($editID, '$capitalPrefix', '$branch', $cartProd_id, $value, '$expiryDateMin', 'Pending');";
      $execQuery  = mysqli_query($connection, $addQuery);

      echo $addQuery;


      $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername edit a stock transfer to branch: $branch', '$activityDate');";
      $execLog = mysqli_query($connection, $queryLog);

      header("Refresh: 0; url=stock_manage.php");

    }  

  }

  if(!$execQuery) {
   die(mysqli_error($connection));
 } else {
  $msg ="<div class='alert alert-success'><strong>Request</strong> is succesful. You request has been added to <a href='#'>Requests</a></div>";
  echo $msg;
}

}
?>
<?php if ($branch == 'BS') { 
  echo '<div class="panel panel-primary">';
} elseif ($branch == 'FV') {
  echo '<div class="panel panel-warning">';
} elseif ($branch == 'TD') {
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

        <?php if ($branch == 'BS') { ?>
        <input type="text" name="report_supplier" class="form-control" value="Baesa" required readonly>
        <?php } ?>

        <?php if ($branch == 'FV') { ?>
        <input type="text" name="report_supplier" class="form-control" value="Fairview" required readonly>
        <?php } ?>

        <?php if ($branch == 'TD') { ?>
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
           $product_vatable = $row['vatable'];
           $product_price = $row['sell_price'];
           $description = $row['description'];
           $product_quantity = $row['quantity'];
           $expiry_date = $row['expiry_date'];
           $count++;

           ?>
           <tr>
             <td class="text-center"><?php echo $product_id; ?>
               <input type="hidden" name="product_id[]" value="<?php echo $product_id; ?>">
             </td>
             <input type="hidden" name="product_vatable[]" value="<?php echo $product_vatable; ?>">
             <td><?php echo $product_name; ?></td>
             <td><?php echo $description; ?></td>
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
              <h3>Confirm Receive</h3>
            </div>
            <div class="modal-body">
              Are you sure you want to confirm receive?
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
