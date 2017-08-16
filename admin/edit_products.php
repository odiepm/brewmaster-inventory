<?php include 'includes/admin_header.php' ?>
<?php 
$proID = $_GET['edit'];

//Get VAT, MarkUp, IsChecked from DB
  $getVat = "SELECT * FROM {$prefix}settings";
  $getVatExec = mysqli_query($connection, $getVat);

  while ($row = mysqli_fetch_array($getVatExec)) {
      $vatValue = $row['vat_percent'];
      $markup_percentage = $row['markup_percentage'];
      $checked = $row['markUpIsCheck'];
  }

if (isset($_POST['update'])) {
  $product_name = $_POST['product_name'];
  $description  = $_POST['description'];
  $supplier_price = $_POST['supplier_price'];
  $markup_percent = $_POST['markup_price'];

  $unformatted_price = (($supplier_price * $markup_percent/100) + $supplier_price);
  $unformatted_price_vat = $unformatted_price * (1 + $vatValue/100);
  $formatted_price = number_format($unformatted_price_vat, 2);

    $updateSql = "UPDATE {$prefix}products SET product_name = '$product_name', description = '$description', supplier_price = $supplier_price, markup_percent = $markup_percent, sell_price = $formatted_price
    WHERE product_id = $proID;";
    $execUpdate = mysqli_query($connection, $updateSql);


    $msg ="<div class='alert alert-success'><strong>{$product_name}</strong> has been updated! <a href='manage_products.php'>Back to Products</a></div>";
    echo $msg;


    $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername edited the product: $product_name', '$activityDate');";
    $execLog = mysqli_query($connection, $queryLog);

}



?>
<div class="row">
  <div class="col-md-10">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Edit Product</span>
        </strong>
      </div>
      <div class="panel-body">
       <div class="col-md-12">
        <form method="post" action="" class="clearfix">
          <?php 
          //Get details inside product table
          $selectProduct = "SELECT * FROM {$prefix}products WHERE product_id = $proID;";
          $execSelect = mysqli_query($connection, $selectProduct);

          while ($row = mysqli_fetch_array($execSelect)) {
            $product_name = $row['product_name'];
            $description = $row['description'];
            $category_id = $row['category_id'];
            $markup_percent = $row['markup_percent'];
            $supplier_price = $row['supplier_price'];
            $sell_price = $row['sell_price'];
            $unit_per = $row['unit_per'];

            ?>
            <div class="form-group">
              <label for="">Product Name</label>
              <div class="input-group">
                <span class="input-group-addon">
                 <i class="glyphicon glyphicon-th-large"></i>
               </span>
               <input type="text" class="form-control" name="product_name" value="<?php echo $product_name; ?>" placeholder="Product Name" maxlength="65" required>
             </div>
           </div>

           <div class="form-group">
            <label for="">Description</label>
            <div class="input-group">
              <span class="input-group-addon">
               <i class="fa fa-align-justify "></i>
             </span>
             <textarea name="description" class="form-control" placeholder="Description ex. 500mL, 1.5L, 2L.." rows="3" required><?php echo $description; ?></textarea>
           </div>
         </div>


         <div class="form-group">
          <div class="row">
            <div class="col-md-12">
              <label for="">Category</label>
              <select class="form-control" name="category_id" required disabled="disabled">


                <?php  

                $selectQuery = "SELECT * FROM categories WHERE category_id = $category_id;";
                $execSelect = mysqli_query($connection, $selectQuery);

                while ($row = mysqli_fetch_array($execSelect)) {
                  $catID   = $row['category_id'];
                  $catName = $row['category_name'];


                }
                ?>
                <option value="<?php echo $catID; ?>" selected="selected" disabled="disabled"><?php echo $catName; ?></option>

              </select>
            </div>

          </div>
        </div>

        <hr>
        <div class="form-group">
         <div class="row">

         <div class="col-md-4">
           <label for="">Supplier's Price</label>
           <div class="input-group">
             <span class="input-group-addon">
               ₱
             </span>
             <input type="number" class="form-control" name="supplier_price" id="supplier_price" placeholder="Buying Price Per Unit" step='0.01' value='<?php echo $supplier_price; ?>' placeholder='0.00' required>

           </div>
         </div>

         <div class="col-md-4">
           <label for="">Mark-up Price (In Percentage)</label>
           <div class="input-group">
             <span class="input-group-addon">
               %
             </span>
              <?php if ($checked == 1) { ?>
             <input type="number" class="form-control" name="markup_price" id="markup_price"  value="<?php echo $markup_percentage; ?>" readonly>
             <?php } else { ?>
             <input type="number" class="form-control" name="markup_price" id="markup_price" placeholder="0" required min='1' max='100'>
             <?php } ?>
           </div>
         </div>

            

              <div class="col-md-4">
               <label for="">VAT</label>
               <div class="input-group">
                 <span class="input-group-addon">
                   %
                 </span>
                 <input type="text" class="form-control" id="vat_value" value="<?php echo $vatValue; ?>" placeholder="0" readonly>
               </div>
             </div>

            <div class="col-md-4">
            <br>
             <label for="">Total</label>
             <div class="input-group">
               <span class="input-group-addon">
                 ₱
               </span>
               <input type="number" class="form-control" name="total_price" value="<?php echo $sell_price; ?>" id="total_price" placeholder="0" readonly>
             </div>
           </div>

            <div class="col-md-4">
            <br>
             <label for="">Unit per Case/Box</label>
             <div class="input-group">
               <span class="input-group-addon">
                 ₱
               </span>
               <input type="number" class="form-control" name="unit_per" value="<?php echo $unit_per; ?>" id="unit_per" placeholder="0" readonly>
             </div>
           </div>


           </div>

         </div>
      <?php } ?>

      <hr>
      <a data-toggle="modal" data-target="#confirm-update" class="btn btn-danger">Update product</button>
        <a href="manage_products.php" class="btn btn-warning pull-right">Back</a>

        <!-- MODAL FOR UPDATE -->
        <div class="modal fade" id="confirm-update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h3>Confirm Update</h3>
              </div>
              <div class="modal-body">
                You are about to update a product, this procedure is irreversible. <br>
                Are you sure you want to update this product?
              </div>
              <div class="modal-footer">
                <input type="submit" name="update" value="Update Product" class="btn btn-info">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
</div>
<script>
 $('#sell_price, #markup_price').on('input',function() {
    var sell_price = parseInt($('#supplier_price').val());
    var markup_price = parseFloat($('#markup_price').val());
    var vat_value = parseFloat($('#vat_value').val());
    $('#total_price').val((((sell_price * markup_price/100) + sell_price) * (1+(vat_value/100))).toFixed(2));
});
</script>
<?php include 'includes/admin_footer.php'; ?>