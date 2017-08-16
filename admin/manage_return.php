<?php include 'includes/admin_header.php'; ?>
<?php  

if (isset($_GET['cid'])) {
  $swsID = $_GET['cid'];

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


  if (isset($_POST['addCart']) && $_POST['addCart']=="Confirm") {
   foreach($_POST['qtyBuy'] as $index=>$value){ 
     if($value > 0){
      if (isset($_POST['case_sws_productid'])) { #start of if
    //POST for Case List
        $case_sws_productid = $_POST['case_sws_productid'][$index];
        $case_sws_procode   = $_POST['case_sws_procode'][$index];
        $case_sws_proname   = $_POST['case_sws_proname'][$index];
        $case_sws_unitprice = $_POST['case_sws_unitprice'][$index];
        $case_sws_prodesc   = $_POST['case_sws_prodesc'][$index];
        $case_sws_proexp    = $_POST['case_sws_proexp'][$index];

        //ADD TO PRODUCTS
        $addC = "UPDATE {$prefix}case SET case_quantity = case_quantity + $value WHERE case_product_id = $case_sws_productid";
        $addCE = mysqli_query($connection, $addC);

        //MINUS TO TRUE QUANTITY
        $minusC = "UPDATE {$prefix}case_sws SET case_true_quantity = case_true_quantity - $value WHERE case_sws_productid = $case_sws_productid";
        $minusCE = mysqli_query($connection, $minusC);


      } #end of if
    } #END OF IF VALUE > 0  
  } # END OF FOREACH

   foreach($_POST['qtyBuy1'] as $index=>$value){ 
     if($value > 0){

        if (isset($_POST['sws_productid'])) { #start of if
      //POST for Product List
        $sws_productid = $_POST['sws_productid'][$index];
        $sws_procode   = $_POST['sws_procode'][$index];
        $sws_proname   = $_POST['sws_proname'][$index];
        $sws_unitprice = $_POST['sws_unitprice'][$index];
        $sws_prodesc   = $_POST['sws_prodesc'][$index];
        $case_sws_proexp = $_POST['sws_proexp'][$index];

        //ADD QUANTITY TO PRODUCTs
        $addQ = "UPDATE {$prefix}products SET quantity = quantity + $value WHERE product_id = $sws_productid";
        $addQE = mysqli_query($connection, $addQ);

        //MINUS TO TRUE QUANTITY
        $minusP = "UPDATE {$prefix}sws SET sws_true_quantity = sws_true_quantity - $value WHERE sws_productid = $sws_productid
        AND sws_number = $swsID";
        $minusPe = mysqli_query($connection, $minusP);      


        } #end of if
    } #END OF IF VALUE > 0  
  } # END OF FOREACH

}
?>


<div class="row">
  <div class="col-md-12"> <!-- Product List Info Start -->
    <h1>Manage Return</h1>
    <hr>

    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Manage Return</span>
        </strong>
      </div>
      <div class="panel-body">
        <h4>Case List:</h4>
        <form action="" method="POST" onsubmit="return confirm('Are you sure?')";>
          <!-- Case Table Start -->
          <table class="table table-striped table-bordered table-hover results table-fixed table-condensed" id="example">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Ordered</th>
                <th>Qty</th>
                <!-- <th>Empties</th> -->
              </tr>
            </thead>
            <tbody>
              <?php 
              $query = "SELECT * FROM {$prefix}case_sws WHERE case_sws_number = $swsID AND case_true_quantity > 0";
              $exec = mysqli_query($connection, $query);
              $a = 1;
              $b = 1;

              $count = 0;
              while ($row = mysqli_fetch_array($exec)) {
                $case_sws_productid = $row['case_sws_productid'];
                $case_sws_procode = $row['case_sws_procode'];
                $case_sws_proname = $row['case_sws_proname'];
                $case_sws_unitprice = $row['case_sws_unitprice'];
                $case_sws_prodesc = $row['case_sws_prodesc'];
                $case_sws_proexp = $row['case_sws_proexp'];
                $case_true_quantity = $row['case_true_quantity'];
                // $case_sws_isEmpty = $row['case_sws_isEmpty'];
                $count++;

                ?>
                <tr>

                  <td class="text-center"><?php echo $case_sws_productid; ?>
                    <input type="hidden" name="case_sws_productid[]" value="<?php echo $case_sws_productid; ?>">
                    <input type="hidden" name="case_sws_proexp[]" value="<?php echo $case_sws_proexp; ?>">
                  </td>

                  <td>
                    <?php echo $case_sws_procode; ?>
                    <input type="hidden" name="case_sws_procode[]" value="<?php echo $case_sws_procode; ?>">
                  </td>

                  <td>
                    <?php echo $case_sws_proname; ?>
                    <input type="hidden" name="case_sws_proname[]" value="<?php echo $case_sws_proname; ?>">
                  </td>

                  <td>
                    <?php echo $case_sws_prodesc; ?>
                    <input type="hidden" name="case_sws_prodesc[]" value="<?php echo $case_sws_prodesc; ?>">
                  </td>

                  <td>₱ <?php echo number_format($case_sws_unitprice, 2); ?>
                    <input type="hidden" name="case_sws_unitprice[]" value="<?php echo $case_sws_unitprice; ?>">
                  </td>

                  <td><strong><?php echo $case_true_quantity; ?></strong></td>

                  <td><input type="number" class="form-control errorM" name="qtyBuy[]" id="<?php echo "qtyBuy" . $a++; ?>" min="1" max="<?php echo $case_true_quantity; ?>">
                  </td>
                  <?php } ?>
               </tbody>
             </table>
             <!-- END OF CASE LIST -->

             <hr>

             <!-- START OF PRODUCT LIST -->
             <h4>Product List:</h4>
             <table class="table table-striped table-bordered table-hover results table-fixed table-condensed" id="example">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th>Product Code</th>
                  <th>Product Name</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Ordered</th>
                  <th>Qty</th>
                  <!-- <th>Empties</th> -->
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
                   </tr>
                   <?php } ?>
                 </tbody>
               </table>
               <!-- END OF PRODUCT LIST -->

               <hr>

              <div class="form-group">
                <input type="submit" name="addCart" value="Confirm" class="btn btn-danger pull-right">
                <a href="outfordel_order.php" class="btn btn-default pull-left">Back</a>
              </div>

            </div>

          </div>

        </form>
      </div>
    </div>
  </div>
</div> <!-- End of Product List -->
<?php } ?>

<?php include 'includes/admin_footer.php'; ?>