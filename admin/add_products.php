<?php include 'includes/admin_header.php' ?>
<?php  

//Get VAT, MarkUp, IsChecked from DB
  $getVat = "SELECT * FROM {$prefix}settings";
  $getVatExec = mysqli_query($connection, $getVat);

  while ($row = mysqli_fetch_array($getVatExec)) {
      $vatValue = $row['vat_percent'];
      $markup_percentage = $row['markup_percentage'];
      $checked = $row['markUpIsCheck'];
  }



if (isset($_POST['add_product'])) {

  $product_name = trim($_POST['product_name']);
  $description  = trim($_POST['description']);
  $category_id  = $_POST['category_id'];
  $expiry_date = $_POST['expiry_date'];
  $sell_price   = $_POST['sell_price'];
  $markup_price   = $_POST['markup_price'];
  $total_price = $_POST['total_price'];
  $unit_per = $_POST['unit_per'];

  //Compute total price with VAT and format to 2 decimal places
  $unformatted_price = (($sell_price * $markup_price/100) + $sell_price);
  $unformatted_price_vat = $unformatted_price * (1 + $vatValue/100);
  $formatted_price = number_format($unformatted_price_vat, 2);

  #TODO: Check if 'Product has empties' is checked
  if (isset($_POST['isEmpty'])) { $isEmpty = 1; } else { $isEmpty = 0; } 

  //Check if product has same details on products database
    $checkProd = "SELECT * FROM {$prefix}products WHERE 
                product_name = '$product_name' AND description = '$description' 
                AND expiry_date = '$expiry_date';";
    $checkProdE = mysqli_query($connection, $checkProd);

if (mysqli_num_rows($checkProdE) > 0) 
  { 
    echo "<script>bootbox.alert('Product already exists!');</script>";
  } else 
    {
     $insert = "INSERT INTO {$prefix}products 
                (product_branch, category_id, product_name, 
                 description, markup_percent, isEmpty, 
                  expiry_date, supplier_price, sell_price, date, unit_per) 
                VALUES ('$capitalPrefix', $category_id, 
                        '$product_name', '$description', $markup_price, $isEmpty, 
                        '$expiry_date', $sell_price, $total_price,'$expiryDateMin', $unit_per)";

    $insertE = mysqli_query($connection, $insert);
    $lastID = mysqli_insert_id($connection); //should be after mysqli_query

      $msg ="<div class='alert alert-success'><strong>{$product_name}</strong> has been added. 
              <a href='manage_products.php'>Go back to Add Products</a></div>";
      echo $msg;

  $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername added a product: $product_name', '$activityDate');";
  $execLog = mysqli_query($connection, $queryLog);
  
  //Update product_code table
  $product_sub = substr($product_name, 0, 3);
  $product_code = strtoupper($product_sub). sprintf('%04d', $lastID);
  $updateCode = "UPDATE {$prefix}products SET product_code = '$product_code' WHERE product_id = $lastID";
  $updateCode2 = mysqli_query($connection, $updateCode);
  }


} //end of isset($_POST['add_product'])




?>

<div class="row">
  <div class="col-md-10">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Add New Product</span>
        </strong>
      </div>
      <div class="panel-body">
       <div class="col-md-12">
        <form method="post" action="add_products.php" class="clearfix">


          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
               <i class="glyphicon glyphicon-th-large"></i>
             </span>
             <input type="text" class="form-control" name="product_name" placeholder="Product Name" required autocomplete="off">
           </div>
         </div>


         <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon">
             <i class="fa fa-align-justify "></i>
           </span>
           <textarea name="description" class="form-control" placeholder="Description ex. 500mL, 1.5L, 2L.." rows="3" required autocomplete="off"></textarea>
         </div>
       </div>


       <div class="form-group">
        <div class="row">
          <div class="col-md-12">
            <select class="form-control" name="category_id" required>
              <option value="">Select Product Category</option>

              <?php  

              $selectQuery = "SELECT * FROM categories;";
              $execSelect = mysqli_query($connection, $selectQuery);
              $validCat = 0;
              while ($row = mysqli_fetch_array($execSelect)) {
                $catID = $row['category_id'];
                $catName = $row['category_name'];

                echo "<option value='$catID'>{$catName}</option>";
                $validCat++;
                
              }
              ?>
              
            </select>
          </div>

        </div>
        <br>
        <div class="form-group">
        <div class="row">
          <div class="col-md-6">
            <label for="">Expiry Date</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-calendar"></i>
              </span>
              <input type="date" class="form-control" name="expiry_date" min="<?php echo $expiryDateMin ?>" required>
            </div>
          </div>
        </div>
      </div>

        <hr>
      </div>
        


      <div class="form-group">
       <div class="row">

       <div class="col-md-4">
         <label for="">Supplier's Price</label>
         <div class="input-group">
           <span class="input-group-addon">
             ₱
           </span>
           <input type="number" class="form-control" name="sell_price" id="sell_price" placeholder="0.00" step='0.01'  required>

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
             <input type="number" class="form-control" name="total_price" id="total_price" placeholder="0" readonly>
           </div>
         </div>

          <div class="col-md-4">
          <br>
           <label for="">Units per Case/Box</label>
           <div class="input-group">
             <span class="input-group-addon">
               +
             </span>
             <input type="number" class="form-control" name="unit_per" id="unit_per" placeholder="0" required min="1" max="50">
           </div>
         </div>
          




         </div>

       </div>




       <div class="checkbox">
        <label>
          <input type="checkbox" name="isEmpty">
          Product has Empties
        </label>
      </div>

        <hr>
    </div>

    <hr>
    <a class="btn btn-success" data-toggle="modal" data-target="#confirm-add">Add product</a>
    <a href="manage_products.php" class="btn btn-default pull-right">Back</a>

    <!-- MODAL FOR UPDATE -->
    <div class="modal fade" id="confirm-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h3>Confirm Product</h3>
          </div>
          <div class="modal-body">
            Are you sure you want to add this product?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <input type="submit" name="add_product" value="Add Product" class="btn btn-info btn-ok">
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
    var sell_price = parseInt($('#sell_price').val());
    var markup_price = parseFloat($('#markup_price').val());
    var vat_value = parseFloat($('#vat_value').val());
    $('#total_price').val((((sell_price * markup_price/100) + sell_price) * (1+(vat_value/100))).toFixed(2));
});
</script>

<?php include 'includes/admin_footer.php' ?>