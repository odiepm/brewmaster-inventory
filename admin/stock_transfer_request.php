<?php include 'includes/admin_header.php'; ?>
<?php  

if (isset($_GET['tid'])) {
  $tid = $_GET['tid'];
}
?>


<?php

$getReq = "SELECT * FROM stock_transfer INNER JOIN {$prefix}products ON stock_transfer.transfer_product_id = {$prefix}products.product_id WHERE stock_transfer.transfer_number = $tid AND stock_transfer.transfer_tobranch = '$capitalPrefix';";
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


  $product_id = $row['product_id'];
  $product_name = $row['product_name'];
  $product_price = $row['sell_price'];
  $description = $row['description'];
  $quantity = $row['quantity'];
  $expiry_date = $row['expiry_date'];
  $st_unit_per = $row['st_unit_per'];

  $transfer_frombranch = strtolower($transfer_frombranch);
  $transfer_tobranch = strtolower($transfer_tobranch);
}

if (isset($_POST['addCart']) && $_POST['addCart']=="Confirm Stock Transfer") {
 foreach($_POST['qtyBuy'] as $index=>$value){
   if($value > 0){

    $cartProd_id = $_POST['product_id'][$index];
    $cartProd_name = $_POST['product_name'][$index];
    $cartProd_date = $_POST['product_exp'][$index];
    $cartProd_desc = $_POST['product_desc'][$index];
    $cartProd_transid = $_POST['transfer_id'][$index];
    $cartProd_price = $_POST['product_price'][$index]; 
    $unit_per = $_POST['unit_per'][$index]; 


    //CHECK IF PRODUCT IS EXISTING IN ANOTHER BRANCH
    $checkSame = "SELECT a.*, b.* FROM {$transfer_frombranch}_products as a 
    INNER JOIN {$prefix}products as b ON a.product_name = b.product_name 
    AND a.expiry_date = b.expiry_date AND a.description = b.description WHERE b.product_id = $cartProd_id;";
    $checkSameE = mysqli_query($connection, $checkSame);

    if (mysqli_num_rows($checkSameE) < 1) { #IF NO PRODUCT IS DETECTED

      $insert_branch_stock = 
      "INSERT INTO {$transfer_frombranch}_products 
      (product_branch, product_code, category_id, product_name, description, 
      isEmpty, sell_price, expiry_date, quantity, date, unit_per)

      SELECT '$transfer_frombranch', product_code, category_id, product_name, description, 
      isEmpty, sell_price, expiry_date, $value, now(), $unit_per FROM {$prefix}products
      WHERE product_id = $cartProd_id;";
      $insert_branch_stockE = mysqli_query($connection, $insert_branch_stock);

      //MINUS STOCK IN THE TO BRANCH
      $lessStock = "UPDATE {$prefix}products SET quantity = quantity - $value WHERE product_id = $cartProd_id;";
      $lessStockE = mysqli_query($connection, $lessStock);

      //MINUS transfer_quantity
      $lessStockQuantity = "UPDATE stock_transfer SET transfer_quantity = transfer_quantity - $value 
      WHERE transfer_number = $tid AND transfer_product_id = $cartProd_id";
      $lessStockQuantityE = mysqli_query($connection, $lessStockQuantity);

      //ADD TO STOCKS TRANSFERRED
      $addStocks = "UPDATE stock_transfer SET stocks_transferred = stocks_transferred + $value
                    WHERE transfer_number = $tid AND transfer_product_id = $cartProd_id";
      $addStocksE = mysqli_query($connection, $addStocks);


      //Get sum of transferred
      $getSum = "SELECT sum(stocks_transferred) AS stockSum, sum(transfer_quantity) AS stockTrans FROM stock_transfer WHERE transfer_number = $tid AND transfer_tobranch = '$capitalPrefix';";
      $getSumE = mysqli_query($connection, $getSum); 


      while ($rowSum = mysqli_fetch_array($getSumE)) {
        $stockSum = $rowSum['stockSum'];
        $stockTrans = $rowSum['stockTrans'];

        if($stockSum == 0) {
          $update_status = "UPDATE stock_transfer SET transfer_status = 'Pending' WHERE transfer_number = $tid;";
          $update_statusE = mysqli_query($connection, $update_status);
        }

        if ($stockSum > 0)  {

          $update_status1 = "UPDATE stock_transfer SET transfer_status = 'In Progress' WHERE transfer_number = $tid;";
          $update_status1E = mysqli_query($connection, $update_status1);

        } 

        if ($stockTrans == 0)  {

          $update_status2 = "UPDATE stock_transfer SET transfer_status = 'Transfer Complete' WHERE transfer_number = $tid;";
          $update_status2E = mysqli_query($connection, $update_status2);

        }

      }

     
    } elseif (mysqli_num_rows($checkSameE) >= 1) {
      $update_branch_stock = 
      "UPDATE {$transfer_frombranch}_products SET quantity = quantity + $value 
      WHERE product_name = '$cartProd_name' 
      AND description = '$cartProd_desc'
      AND expiry_date = '$cartProd_date'";
      $update_branch_stockE = mysqli_query($connection, $update_branch_stock);


      $lessStock = "UPDATE {$prefix}products SET quantity = quantity - $value WHERE product_id = $cartProd_id;";
      $lessStockE = mysqli_query($connection, $lessStock);

      //MINUS transfer_quantity
      $lessStockQuantity = "UPDATE stock_transfer SET transfer_quantity = transfer_quantity - $value 
      WHERE transfer_number = $tid AND transfer_product_id = $cartProd_id";
      $lessStockQuantityE = mysqli_query($connection, $lessStockQuantity);


      //ADD TO STOCKS TRANSFERRED
      $addStocks = "UPDATE stock_transfer SET stocks_transferred = stocks_transferred + $value
                    WHERE transfer_number = $tid AND transfer_product_id = $cartProd_id";
      $addStocksE = mysqli_query($connection, $addStocks);
      //Get sum of transferred
      $getSum = "SELECT sum(stocks_transferred) AS stockSum, sum(transfer_quantity) AS stockTrans FROM stock_transfer WHERE transfer_number = $tid AND transfer_tobranch = '$capitalPrefix';";
      $getSumE = mysqli_query($connection, $getSum); 


      while ($rowSum = mysqli_fetch_array($getSumE)) {
        $stockSum = $rowSum['stockSum'];
        $stockTrans = $rowSum['stockTrans'];

        if($stockSum == 0) {
          $update_status = "UPDATE stock_transfer SET transfer_status = 'Pending' WHERE transfer_number = $tid;";
          $update_statusE = mysqli_query($connection, $update_status);
        }

        if ($stockSum > 0)  {

          $update_status1 = "UPDATE stock_transfer SET transfer_status = 'In Progress' WHERE transfer_number = $tid;";
          $update_status1E = mysqli_query($connection, $update_status1);

        } 

        if ($stockTrans == 0)  {

          $update_status2 = "UPDATE stock_transfer SET transfer_status = 'Transfer Complete' WHERE transfer_number = $tid;";
          $update_status2E = mysqli_query($connection, $update_status2);

        }

      }


    }
  }  
}

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
                <th>Quantity to Transfer</th>
              </tr>
            </thead>
            <tbody>
              <?php 

              $getReq = "SELECT * FROM stock_transfer INNER JOIN {$prefix}products 
              ON stock_transfer.transfer_product_id = {$prefix}products.product_id WHERE stock_transfer.transfer_number = $tid 
              AND stock_transfer.transfer_tobranch = '$capitalPrefix' 
              AND stock_transfer.stocks_transferred < stock_transfer.transfer_quantity;";
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

                $product_id = $row['product_id'];
                $product_name = $row['product_name'];
                $product_price = $row['sell_price'];
                $description = $row['description'];
                $quantity = $row['quantity'];
                $expiry_date = $row['expiry_date'];
                $unit_per = $row['unit_per'];

                $remainingStocks = $transfer_quantity - $stocks_transferred;

                ?>
                <tr>
                  <td class="text-center"><?php echo $product_id; ?>
                    <input type="hidden" name="product_id[]" value="<?php echo $product_id; ?>">
                  </td>
                  <input type="hidden" name="transfer_id[]" value="<?php echo $transfer_id; ?>">
                  <td><?php echo $product_name; ?>
                    <input type="hidden" name="product_name[]" value="<?php echo $product_name; ?>">
                  </td>
                  <td><?php echo $description; ?>
                    <input type="hidden" name="product_desc[]" value="<?php echo $description; ?>">
                    <input type="hidden" name="unit_per[]" value="<?php echo $unit_per; ?>">
                  </td>
                  <td>₱ <?php echo number_format($product_price, 2); ?></td>
                  <input type="hidden" name="product_price[]" value="<?php echo $product_price; ?>">
                  <td><?php echo $expiry_date; ?>
                    <input type="hidden" name="product_exp[]" value="<?php echo $expiry_date; ?>">
                  </td>
                  <td><strong><?php echo $quantity; ?></strong></td>
                  <td><?php echo $remainingStocks; ?></td>
                  <td><?php echo $stocks_transferred; ?></td>
                  <td>
                    <input type="number" class="form-control" name="qtyBuy[]"  id="<?php echo "qtyBuy" . $b++; ?>" min="1" max="<?php echo $remainingStocks;?>">
                  </td>
                </tr>
                <?php }?>
              </tbody>
            </table>

            <div class="form-group">
              <input type="submit" name="addCart" value="Confirm Stock Transfer" class="btn btn-info pull-right">
              <a href="stock_requests_partial.php" class="btn btn-warning pull-left">Back to Request List</a>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div> <!-- End of Product List -->

  <?php include 'includes/admin_footer.php'; ?>