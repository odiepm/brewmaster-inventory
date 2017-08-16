<?php include 'includes/admin_header.php'; ?>

<?php 

//GET id on edit url
if (isset($_GET['edit'])) {

  $customer_info_id = $_GET['edit'];

  $selectQuery = "SELECT * FROM {$prefix}customer_info WHERE customer_info_id = $customer_info_id;";
  $execQuery = mysqli_query($connection, $selectQuery);

  while ($row = mysqli_fetch_array($execQuery)) {

    $customer_info_id  = $row['customer_info_id'];
    $customer_info_name  = $row['customer_info_name'];
    $customer_info_number  = $row['customer_info_number'];
    $customer_info_address  = $row['customer_info_address'];
  }

      if (isset($_POST['update'])) {

        $customer_info_name     = $_POST['customer_info_name'];
        $customer_info_address  = $_POST['customer_info_address'];
        $customer_info_number   = $_POST['customer_info_number'];
        
        $query = "UPDATE {$prefix}customer_info SET customer_info_name = '$customer_info_name', customer_info_number = '$customer_info_number', 
        customer_info_address = '$customer_info_address' WHERE customer_info_id = $customer_info_id";
        $execQuery = mysqli_query($connection,$query);


        $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername edited customer: $customer_info_name', '$activityDate');";
        $execLog = mysqli_query($connection, $queryLog);

        if (!$execQuery) {
          die(mysqli_error($connection));
        } else {
          $msg ="<div class='alert alert-success'><strong>{$customer_info_name}</strong> has been updated! <a href='manage_customer.php'>Back to Customer</a></div>";
          echo $msg;
        }
      }
}
?>

<form action="" method="POST" role="form" id="haha">
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Edit Customer</span>
        </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-6">

          <div class="form-group">
            <label for="firstname">Customer Store Name</label>
            <input type="text" class="form-control" name="customer_info_name" value="<?php echo $customer_info_name; ?>" required>
            <input type="hidden" class="form-control" name="customer_info_id" value="<?php echo $customer_info_id; ?>" required>
          </div>

          <div class="form-group">
            <label for="lastname">Customer Number</label>
            <input type="text" class="form-control" name="customer_info_number" value="<?php echo $customer_info_number; ?>" required>
          </div>


          <div class="form-group">
            <label for="lastname">Customer Address</label>
            <input type="text" class="form-control" name="customer_info_address" value="<?php echo $customer_info_address; ?>" required>
          </div>

          <div class="form-group"> 
            <a class="btn btn-info" data-toggle="modal" data-target="#confirm-update">Update Customer</a>
            <a href="manage_customer.php" class="btn btn-warning pull-right" >Back</a>

            <!-- MODAL FOR UPDATE -->
            <div class="modal fade" id="confirm-update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3>Confirm Update</h3>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to update this customer?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="update" class="btn btn-info btn-ok" id="btnDisable">Confirm</button>
                  </div>
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>

    </div>
  </div>

</form>
<?php include 'includes/admin_footer.php'; ?>