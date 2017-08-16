<?php include 'includes/admin_header.php' ?>

<?php


//Return.php array
if (isset($_POST['addCart']) && $_POST['addCart']=="Confirm Receive") {
 foreach($_POST['qtyBuy'] as $index=>$value){
   if($value > 0){

    $report_supplier = $_POST['report_supplier'];
    $cartProd_id = $_POST['product_id'][$index];
    
    $addQuery = "UPDATE {$prefix}products SET quantity = quantity + $value WHERE product_id = $cartProd_id;";
    $minusQuery = "UPDATE {$prefix}sws SET sws_quantity = sws_quantity + $value WHERE sws_productid = $cartProd_id;";

    $getProName = "SELECT * FROM {$prefix}products WHERE product_id = $cartProd_id;";
    $getProNameE = mysqli_query($connection, $getProName);
    while ($row = mysqli_fetch_array($getProNameE)) {
      $productName = $row['product_name'];
      $productDesc = $row['description'];
      $expiry_date = $row['expiry_date'];
    }

    $insertQuery = "INSERT INTO {$prefix}reports (report_supplier, report_product, report_description, report_quantity, report_date, report_type, report_expiry) VALUES ('$report_supplier', '$productName','$productDesc', $value, '$activityDate', 'Receive', '$expiry_date') ;";

    $execQuery  = mysqli_query($connection, $addQuery);
    $execQuery2  = mysqli_query($connection, $minusQuery);
    $execQuery3  = mysqli_query($connection, $insertQuery);

    echo $execQuery3;


  }  
}

}
?>

<div class="col-md-12">
  <div class="panel panel-default">
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
          <label for="">Supplier Name</label>
          <input type="text" name="report_supplier" class="form-control" placeholder="Supplier Name" required>
        </div>
      </div>
      <div class="col-md-12">
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
             <th style="width: 20%">Quantity to Receive</th>
           </tr>
         </thead>


         <tbody>
           <?php 
           $query = "SELECT * FROM {$prefix}products WHERE quantity > 0;";
           $exec = mysqli_query($connection, $query);
           $a = 1;
           $b = 1;

           while ($row = mysqli_fetch_array($exec)) {
             $product_id = $row['product_id'];
             $product_name = $row['product_name'];
             $product_vatable = $row['vatable'];
             $product_price = $row['sell_price'];
             $description = $row['description'];
             $product_quantity = $row['quantity'];
             $expiry_date = $row['expiry_date'];

             ?>
             <tr>
               <td class="text-center"><?php echo $product_id; ?>
                 <input type="hidden" name="product_id[]" value="<?php echo $product_id; ?>">
               </td>
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
         <a class="btn btn-success btn-ok" data-toggle="modal" data-target="#confirm-add">Confirm Receive</a>
         <a href="receive_product.php" class="btn btn-primary pull-right">Add New Product</a>
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
                <input type="submit" name="addCart" value="Confirm Receive" class="btn btn-info btn-ok">
              </div>
            </div>
          </div>
        </div>

        <?php include 'includes/admin_footer.php' ?> 
      </div>
    </div>
  </form>

