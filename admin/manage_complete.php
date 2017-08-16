<?php include 'includes/admin_header.php'; ?>
<?php  
error_reporting(0);
if (isset($_GET['cid'])) {
  $swsID = $_GET['cid'];

  if (isset($_POST['addCart']) && $_POST['addCart']=="Confirm Damages") {

    foreach($_POST['qtyBuy1'] as $index=>$value){ 
     if($value > 0) {
      if (isset($_POST['sws_productid'])) 
      { 
        $sws_productid = $_POST['sws_productid'][$index];
        $productDamage = "UPDATE {$prefix}products SET damages = damages + $value 
        WHERE product_id = $sws_productid";
        $productDamageE = mysqli_query($connection, $productDamage);

        $minusTrueP = "UPDATE {$prefix}sws SET sws_true_quantity = sws_true_quantity - $value
        WHERE sws_productid = $sws_productid AND sws_number = $swsID";
        $minusTruePE = mysqli_query($connection, $minusTrueP);

      } 
    } 
  } 
}

if (isset($_POST['complete'])) {
  $updateComplete = "UPDATE {$prefix}orders SET status = 'Completed'
  WHERE order_num = $swsID";
  $updateCompleteE = mysqli_query($connection, $updateComplete);

  $selectProd = "SELECT * FROM {$prefix}sws WHERE sws_number = $swsID";
  $selectProdE = mysqli_query($connection, $selectProd);

  while ($row = mysqli_fetch_array($selectProdE)) {
    $sws_productid = $row['sws_productid'];
    $sws_true_quantity = $row['sws_true_quantity'];

    $updateInstockP = "UPDATE {$prefix}products SET quantity = quantity + $sws_true_quantity
    WHERE product_id = $sws_productid";
    $updateInstockPE = mysqli_query($connection, $updateInstockP);
  }

  header('Location:completed_orders.php');

}

?>


<div class="row">
  <div class="col-md-12"> <!-- Product List Info Start -->
    <h1>Manage Damages/Complete Order</h1>
    <hr>
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Manage Damages/Complete Order</span>
        </strong>
      </div>
      <div class="panel-body">
        <form action="" method="POST" onsubmit="return confirm('Are you sure?')";>
          <h4>Product List:</h4>
          <table class="table table-striped table-bordered table-hover results table-fixed table-condensed" id="tae">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Ordered</th>
                <th>Damage Qty</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $query = "SELECT * FROM {$prefix}sws WHERE sws_number = $swsID AND sws_true_quantity > 0";
              $exec = mysqli_query($connection, $query);

              while ($row = mysqli_fetch_array($exec)) {
                $sws_id = $row['sws_id'];
                $sws_productid = $row['sws_productid'];
                $sws_procode = $row['sws_procode'];
                $sws_proname = $row['sws_proname'];
                $sws_unitprice = $row['sws_unitprice'];
                $sws_prodesc = $row['sws_prodesc'];
                $sws_proexp = $row['sws_proexp'];
                $sws_true_quantity = $row['sws_true_quantity'];
                $sws_isEmpty = $row['sws_isEmpty'];

                ?>
                <tr>
                  <td class="text-center"><?php echo $sws_productid; ?>
                    <input type="hidden" name="sws_productid[]" value="<?php echo $sws_productid; ?>">
                    <input type="hidden" name="sws_proexp[]" value="<?php echo $sws_proexp; ?>">
                  </td>

                  <td>
                    <?php echo $sws_procode; ?>
                    <input type="hidden" name="sws_procode[]" value="<?php echo $sws_procode; ?>">
                  </td>

                  <td>
                    <?php echo $sws_proname; ?>
                    <input type="hidden" name="sws_proname[]" value="<?php echo $sws_proname; ?>">
                  </td>

                  <td>
                    <?php echo $sws_prodesc; ?>
                    <input type="hidden" name="sws_prodesc[]" value="<?php echo $sws_prodesc; ?>">
                  </td>

                  <td>₱ <?php echo number_format($sws_unitprice, 2); ?>
                    <input type="hidden" name="sws_unitprice[]" value="<?php echo $sws_unitprice; ?>">
                  </td>
                  <td><strong><?php echo $sws_true_quantity; ?></strong></td>
                  <td><input type="number" class="form-control errorM" name="qtyBuy1[]" id="<?php echo "qtyBuy1" . $a++; ?>" min="1" max="<?php echo $sws_true_quantity; ?>"></td>
                  <?php } } ?>
                </tr>
              </tbody>
            </table>
            <!-- END OF PRODUCT LIST -->
            <p class="text-muted pull-right">* All unassigned products will be RETURNED to your stock</p>
            <hr>
            <div class="col-md-4">
              <a href="outfordel_order.php" class="btn btn-default">Back</a>
            </div>

            <div class="col-md-4">
              <input type="submit" name="addCart" value="Confirm Damages" class="btn btn-danger">
            </div>


            <div class="col-md-4">
              <input type="submit" name="complete" value="Complete Order" class="btn btn-success pull-right">
            </div>

          </div>

        </div>

      </form>
    </div>
  </div>
</div>
</div> <!-- End of Product List -->


<?php include 'includes/admin_footer.php'; ?>