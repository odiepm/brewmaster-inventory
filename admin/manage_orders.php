<?php include 'includes/admin_header.php'; ?>
<?php  
error_reporting(0);
if (isset($_POST['setcart'])) {

  $customer = $_POST['selectCustomer'];
  $_SESSION['customer_id'] = $customer;
}

$swsID = $_SESSION['cid'];
$customer_id = $_SESSION['customer_id'];

$salesman_id = $_SESSION['sid'];



  //***************Retrieve Salesman Information****************
$supplierInfo = "SELECT * FROM {$prefix}orders WHERE order_num = $swsID;";
$suppE = mysqli_query($connection, $supplierInfo);

while ($row = mysqli_fetch_array($suppE)) {
  $salesman_name = $row['salesman_name'];
}
  //**************************END********************************

$checkDisID = "SELECT * FROM {$prefix}customer;";
$checkQ = mysqli_query($connection, $checkDisID);

$initDN = 0;
$count = 0;

while ($row = mysqli_fetch_array($checkQ)) {
  $initDN = $row['customer_distribution_id'];
}

while ($count <= $initDN) {
  $count++;
}

  //ROW COUNT IF DISPLAY
$countProduct = "SELECT COUNT(*) rowCount FROM {$prefix}sws WHERE sws_number = $swsID AND sws_true_quantity >= 1";
$countProductE = mysqli_query($connection, $countProduct);

while ($row = mysqli_fetch_array($countProductE)) {
    $count_product = $row['rowCount']; #CHECK IF PRODUCT HAS COUNT
  }

  if ($count_product == 0) {
    $updateComplete = "UPDATE {$prefix}orders SET status = 'Completed' WHERE order_num = $swsID";
    $updateCompleteE = mysqli_query($connection, $updateComplete);

    // header('Location:completed_orders.php');
  }

  if (isset($_POST['addCart']) && $_POST['addCart']=="Confirm") {

    //POST for Customer 
    $custName     = $_POST['custName'];
    $custAddress  = $_POST['custAddress'];
    $custNumber   = $_POST['custNumber'];

    foreach($_POST['qtyBuy'] as $index=>$value){ 
     if($value > 0){

        if (isset($_POST['sws_productid'])) { #start of if
      //POST for Product List
          $sws_productid = $_POST['sws_productid'][$index];
          $sws_procode   = $_POST['sws_procode'][$index];
          $sws_proname   = $_POST['sws_proname'][$index];
          $sws_unitprice = $_POST['sws_unitprice'][$index];
          $sws_prodesc   = $_POST['sws_prodesc'][$index];
          $case_sws_proexp = $_POST['sws_proexp'][$index];
          $sws_isEmpty = $_POST['sws_isEmpty'][$index];

          $customerProd = "INSERT INTO {$prefix}customer 
          (customer_distribution_id, customer_sws_id, customer_name, customer_address, customer_contact,
          customer_product_id, customer_product_code, customer_product_name, customer_product_exp, customer_product_qty,
          customer_product_price, customer_product_des, customer_info_id, customer_isEmpty, customer_salesman_id)
          VALUES 
          ($count ,$swsID, '$custName', '$custAddress', '$custNumber', $sws_productid, '$sws_procode',
          '$sws_proname', '$case_sws_proexp', $value, $sws_unitprice, '$sws_prodesc', $customer_id, $sws_isEmpty, $salesman_id)";
          $customerProdE = mysqli_query($connection, $customerProd);


        //MINUS TO TRUE QUANTITY
          $minusP = "UPDATE {$prefix}sws SET sws_true_quantity = sws_true_quantity - $value WHERE sws_productid = $sws_productid
          AND sws_number = $swsID";
          $minusPe = mysqli_query($connection, $minusP);

          //START OF EMPTY
          foreach($_POST['qtyEmpty'] as $index=>$value) { 
            if($value > 0){


              if (isset($_POST['sws_product_delete_id'])) {
                $sws_product_delete_id = $_POST['sws_product_delete_id'][$index];
                if ($sws_product_delete_id == $sws_productid) {
                  # code...
                $insertEmptyP = "UPDATE {$prefix}customer 
                SET customer_empty_qty = customer_empty_qty + $value
                WHERE customer_sws_id = $swsID 
                AND customer_product_id = $sws_product_delete_id";
                $insertEmptyPE = mysqli_query($connection, $insertEmptyP);

                $emptyProducts = "UPDATE {$prefix}products 
                SET empties = empties + $value
                WHERE product_id = $sws_product_delete_id";
                $emptyProductsE = mysqli_query($connection, $emptyProducts);
                }

              } 
            }
          }
          ///END OF EMPTY       

        } 
      }  
    } //END OF FOREACH qtyBuy 


  header('Location:outfordel_order.php');
  }


  ?>


  <div class="row">
    <div class="col-md-12"> <!-- Product List Info Start -->
      <h1>Manage Distribution</h1>
      <hr>
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Manage Distribution</span>
          </strong>
        </div>
        <div class="panel-body">
        <form action="" method="POST" onsubmit="return confirm('Are you sure?')";>
            <!-- START OF PRODUCT LIST -->
            <h4>Product List:</h4>
            <table class="table table-striped table-bordered table-hover results table-fixed table-condensed" id="tae">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th>Product Code</th>
                  <th>Product Name</th>
                  <th>Description</th>
                  <th>Unit per Case/Box</th>
                  <th>Price</th>
                  <th>Ordered</th>
                  <th>Qty</th>
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
                  $sws_unit_per = $row['sws_unit_per'];

                  ?>
                  <tr>
                    <td class="text-center"><?php echo $sws_productid; ?>
                      <input type="hidden" name="sws_productid[]" value="<?php echo $sws_productid; ?>">
                      <input type="hidden" name="sws_proexp[]" value="<?php echo $sws_proexp; ?>">
                      <input type="hidden" name="sws_isEmpty[]" value="<?php echo $sws_isEmpty; ?>">
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

                    <td>
                      <?php echo $sws_unit_per; ?>
                      <input type="hidden" name="sws_unit_per[]" value="<?php echo $sws_unit_per; ?>">
                    </td>

                    <td>₱ <?php echo number_format($sws_unitprice, 2); ?>
                      <input type="hidden" name="sws_unitprice[]" value="<?php echo $sws_unitprice; ?>">
                    </td>
                    <td><strong><?php echo $sws_true_quantity; ?></strong></td>
                    <td><input type="number" class="form-control errorM" name="qtyBuy[]" id="<?php echo "qtyBuy" . $a++; ?>" min="1" max="<?php echo $sws_true_quantity; ?>"></td>
                    <?php } ?>
                  </tbody>
                </table>
                <!-- END OF PRODUCT LIST -->
                <!-- START OF PRODUCT LIST -->
                <h4>Empties:</h4>
                <table class="table table-striped table-bordered table-hover results table-fixed table-condensed" id="tae">
                 <thead>
                   <tr>
                     <th class="text-center">#</th>
                     <th>Product Code</th>
                     <th>Product Name</th>
                     <th>Description</th>
                     <th>Unit per Case/Box</th>
                     <th>Price</th>
                     <th>Ordered</th>
                     <th>Empties</th>
                   </tr>
                 </thead> 
                 <tbody>
                   <?php 
                   $query = "SELECT * FROM {$prefix}sws WHERE sws_number = $swsID AND sws_true_quantity > 0 AND sws_isEmpty > 0";
                   $exec = mysqli_query($connection, $query);

                   while ($row = mysqli_fetch_array($exec)) {
                     $sws_id = $row['sws_id'];
                     $sws_product_delete_id = $row['sws_productid'];
                     $sws_procode = $row['sws_procode'];
                     $sws_proname = $row['sws_proname'];
                     $sws_unitprice = $row['sws_unitprice'];
                     $sws_prodesc = $row['sws_prodesc'];
                     $sws_proexp = $row['sws_proexp'];
                     $sws_true_quantity = $row['sws_true_quantity'];
                     $sws_isEmpty = $row['sws_isEmpty'];
                     $sws_unit_per = $row['sws_unit_per'];

                     ?>
                     <tr>
                       <td class="text-center"><?php echo $sws_product_delete_id; ?>
                         <input type="hidden" name="sws_product_delete_id[]" value="<?php echo $sws_product_delete_id; ?>">
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

                       <td>
                         <?php echo $sws_unit_per; ?>
                         <input type="hidden" name="sws_unit_per[]" value="<?php echo $sws_unit_per; ?>">
                       </td>

                       <td>₱ <?php echo number_format($sws_unitprice, 2); ?>
                         <input type="hidden" name="sws_unitprice[]" value="<?php echo $sws_unitprice; ?>">
                       </td>
                       <td><strong><?php echo $sws_true_quantity; ?></strong></td>
                       <td><input type="number" class="form-control errorM" name="qtyEmpty[]" id="<?php echo "qtyEmpty" . $a++; ?>" min="1" max="<?php echo $sws_true_quantity; ?>"></td>
                     </tr>
                     <?php } ?>
                   </tbody>
                 </table>
                 <!-- END OF PRODUCT LIST -->

                 <!-- START OF CUSTOMER DETAILS -->
                 <?php 

                 $sql = "SELECT * FROM {$prefix}customer_info WHERE customer_info_id = $customer";
                 $sqlE = mysqli_query($connection, $sql);

                 while ($row = mysqli_fetch_array($sqlE)) {
                  $customer_info_id = $row['customer_info_id'];
                  $customer_info_name = $row['customer_info_name'];
                  $customer_info_address = $row['customer_info_address'];
                  $customer_info_number = $row['customer_info_number'];
                }

                ?>
                <hr>
                <h3>Customer Details</h3>
                <hr>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="custName">Customer Name</label>
                    <input type="text" class="form-control" name="custName" id="custDetails" readonly value="<?php echo $customer_info_name; ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="custNumber" class="label-control">Customer Number</label>
                    <input type="text" class="form-control" name="custNumber" id="custDetails" readonly value="<?php echo $customer_info_number; ?>">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="custAddress" class="label-control">Address</label>
                    <input type="text" class="form-control" name="custAddress" id="custDetails" readonly value="<?php echo $customer_info_address; ?>">
                  </div>
                </div>



                <div class="form-group">
                  <input type="submit" name="addCart" value="Confirm" class="btn btn-info pull-right">
                  <a href="javascript:history.back()" class="btn btn-default pull-left">Back</a>
                </div>

              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div> <!-- End of Product List -->

  <?php include 'includes/admin_footer.php'; ?>