<?php include 'includes/admin_header.php'; ?>
<?php  

if (isset($_GET['id'])) {
  $id = $_GET['id'];
}
?>

<?php
$getReq = "SELECT * FROM stock_transfer WHERE transfer_frombranch = '$capitalPrefix';";
$getReqE = mysqli_query($connection, $getReq);

while ($row = mysqli_fetch_array($getReqE)) {
  $transfer_id = $row['transfer_id'];
  $transfer_number = $row['transfer_number'];
  $transfer_status = $row['transfer_status'];
  $transfer_frombranch = $row['transfer_frombranch'];
  $transfer_tobranch = $row['transfer_tobranch'];
  $transfer_product_id = $row['transfer_product_id'];
  $transfer_quantity = $row['transfer_quantity'];
  $transfer_date = $row['transfer_date'];
  $stocks_transferred = $row['stocks_transferred'];
}


?>


<div class="row">
  <div class="col-md-12"> <!-- Product List Info Start -->
    <h1>Manage Stock to Transfer</h1>
    <hr>
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Stock Transfer</span>
        </strong>
      </div>

      <div class="panel-body">
        <form action="" method="POST" onsubmit="return confirm('Are you sure?')";>
          <!-- Product Table Start -->
          <table class="table table-striped table-bordered table-hover results table-fixed table-condensed" id="example">
            <thead>
              <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Sell Price</th>
                <th>Expiry Date</th>
                <th>Instock</th>
                <th>Stocks Requested Remaining</th>
                <th>Stocks Transferred</th>
              </tr>
            </thead>
            <tbody>
              <?php 

              $getReq = "SELECT * FROM stock_transfer INNER JOIN {$transfer_tobranch}_products 
              ON stock_transfer.transfer_product_id = {$transfer_tobranch}_products.product_id WHERE stock_transfer.transfer_number = $id 
              AND stock_transfer.transfer_frombranch = '$transfer_frombranch'";
              $getReqE = mysqli_query($connection, $getReq);
              $a = 1;
              $b = 1;

              while ($row = mysqli_fetch_array($getReqE)) {
                $transfer_id = $row['transfer_id'];
                $transfer_number = $row['transfer_number'];
                $transfer_status = $row['transfer_status'];
                $transfer_frombranch = $row['transfer_frombranch'];
                $transfer_tobranch = $row['transfer_tobranch'];
                $transfer_product_id = $row['transfer_product_id'];
                $transfer_quantity = $row['transfer_quantity'];
                $transfer_date = $row['transfer_date'];
                $stocks_transferred = $row['stocks_transferred'];

                $remainingStocks = $transfer_quantity - $stocks_transferred;

                $product_id = $row['product_id'];
                $product_name = $row['product_name'];
                $product_price = $row['sell_price'];
                $description = $row['description'];
                $quantity = $row['quantity'];
                $expiry_date = $row['expiry_date'];

                ?>
                <tr>
                  <td class="text-center"><?php echo $product_id; ?></td>
                  <td><?php echo $product_name; ?></td>
                  <td><?php echo $description; ?></td>
                  <td>₱ <?php echo number_format($product_price, 2); ?></td>
                  <td><?php echo $expiry_date; ?></td>
                  <td><strong><?php echo $quantity; ?></strong></td>
                  <td><?php echo $remainingStocks; ?></td>
                  <td><strong><?php echo $stocks_transferred; ?></strong></td>
                </tr>
                <?php }?>
              </tbody>
            </table>

            <div class="form-group">
              <a href="stock_manage_partial.php" class="btn btn-warning pull-left">Back</a>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div> <!-- End of Product List -->

  <?php include 'includes/admin_footer.php'; ?>