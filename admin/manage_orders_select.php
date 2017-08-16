<?php include 'includes/admin_header.php'; ?>
<?php 
if (isset($_GET['cid'])) {
$_SESSION['cid'] = $_GET['cid'];
$_SESSION['sid'] = $_GET['sid'];
}

 ?>


<div class="row">
  <div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Choose Customer</h3>
    </div>
      <div class="panel-body">

        <div class="form-group">
         <form action="manage_orders.php" method="post">

         <label for="salesman">Select Customer</label>
          <select name="selectCustomer" class="form-control" required>
           <option value="">Select Customer</option>
           <?php 
           $select = "SELECT * FROM {$prefix}customer_info";
           $squery = mysqli_query($connection,$select);
           $count = 0;

           while($row = mysqli_fetch_array($squery)) {

             $customer_info_id = $row['customer_info_id'];
             $customer_info_name = $row['customer_info_name'];
             $customer_info_address = $row['customer_info_address'];

             $count++;
             ?>
             <option value='<?php echo $customer_info_id ?>'><?php echo ucwords($customer_info_name)." - ".ucwords($customer_info_address); ?></option>";
             <?php } ?>

           </select>
           <br>

            <br>
            <a href="outfordel_order.php" class="btn btn-default" title="">Back</a>
            <input type="submit" class="btn btn-success pull-right" name="setcart" value="Proceed">
          </form>
        </div>
      </div>

    </div>


  </div>
</div>
</div>
<?php include 'includes/admin_footer.php'; ?>