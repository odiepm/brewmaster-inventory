<?php include 'includes/admin_header.php' ?>

<?php

//Return.php array
if (isset($_POST['addCart']) && $_POST['addCart']=="Return Stocks") {
 foreach($_POST['qtyBuy'] as $index=>$value){
   if($value > 0){

    $cartProd_id = $_POST['product_id'][$index];
    
    $addQuery = "UPDATE {$prefix}products SET quantity = quantity - $value WHERE product_id = $cartProd_id;";

    $getProName = "SELECT * FROM {$prefix}products WHERE product_id = $cartProd_id;";
    $getProNameE = mysqli_query($connection, $getProName);
    while ($row = mysqli_fetch_array($getProNameE)) {
      $productName = $row['product_name'];
      $productDesc = $row['description'];
      $expiry_date = $row['expiry_date'];
    }

    $insertQuery = "INSERT INTO {$prefix}reports (report_supplier, report_type, report_product, report_description, report_expiry, report_quantity, report_date) 
                      VALUES ('$capitalPrefix','Return', '$productName','$productDesc', '$expiry_date', $value, '$expiryDateMin');";

    $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername received product: $productName', '$activityDate');";
    $execLog = mysqli_query($connection, $queryLog);

    $execQuery  = mysqli_query($connection, $addQuery);
    $execQuery3  = mysqli_query($connection, $insertQuery);



  }  
}

}
?>

<div class="col-md-12">
  <div class="panel panel-default">
   <div class="panel-heading">
    <strong>
      <span class="glyphicon glyphicon-th"></span>
      <span>Return Stocks</span>
    </strong>
  </div>

  <div class="panel-body">
    <form action="" method="POST">
      <div class="col-md-12">
   
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
             <th style="width: 20%">Quantity to Receive</th>
           </tr>
         </thead>


         <tbody>
           <?php 
           $query = "SELECT * FROM {$prefix}products WHERE quantity > 0;";
           $exec = mysqli_query($connection, $query);
           $a = 1;
           $b = 1;

           $count = 0;
           while ($row = mysqli_fetch_array($exec)) {
             $product_id = $row['product_id'];
             $product_code = $row['product_code'];
             $product_name = $row['product_name'];
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
               <td><?php echo $product_code; ?></td>
               <input type="hidden" name="product_vatable[]" value="<?php echo $product_vatable; ?>">
               <td><?php echo $product_name; ?></td>
               <td><?php echo $description; ?></td>
               <td><?php echo $expiry_date; ?></td>
               <td>₱ <?php echo number_format($product_price, 2); ?></td>
               <td><?php echo $product_quantity; ?></td>
               <td><input type="number" name="qtyBuy[]" id="<?php echo "qtyBuy" . $b++; ?>" min="1" max="10000"></td>
             </tr>
             <?php } ?>
           </tbody>
         </table>
         <hr>
         <div class="form-group">
         <?php if ($count <= 0) { ?>
         <button type="button" class="btn btn-success disabled">Return Stocks</button>
         <?php } else { ?>
          <a class="btn btn-success btn-ok" data-toggle="modal" data-target="#confirm-add">Return Stocks</a>
         <?php } ?>
        </div>

        <!-- MODAL FOR UPDATE -->
        <div class="modal fade" id="confirm-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h3>Return Stocks</h3>
              </div>
              <div class="modal-body">
                Are you sure you want to Return Stocks?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <input type="submit" name="addCart" value="Return Stocks" class="btn btn-info btn-ok">
              </div>
            </div>
          </div>
        </div>

        <?php include 'includes/admin_footer.php' ?> 
      </div>
    </div>
  </form>

