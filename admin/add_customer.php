<?php include 'includes/admin_header.php'; ?>

<?php 

if (isset($_POST['submit'])) {

  if (isset($_POST['customer_store'])) {

    $customer_store = $_POST['customer_store'];
    $customer_contact  = $_POST['customer_contact'];
    $customer_address   = $_POST['customer_address'];

    $sql = "SELECT * FROM {$prefix}customer_info WHERE customer_store = '$customer_store'";
    $res = mysqli_query($connection, $sql);

    if($res && mysqli_num_rows($res) > 0){

      echo "<div class='alert alert-danger'>The Customer Store: <strong>{$customer_store}</strong> is already taken!</div>";

    } else {

      $query = "INSERT INTO {$prefix}customer_info (customer_info_name, customer_info_address, customer_info_number)  
      VALUES ('$customer_store', '$customer_address', '$customer_contact')";
      $execQuery = mysqli_query($connection,$query);

      $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername registered customer: $customer_store', '$activityDate');";
      $execLog = mysqli_query($connection, $queryLog);

      if(!$execQuery) {
       die(mysqli_error($connection));
     } else {
      $msg ="<div class='alert alert-success'><strong>{$customer_store}</strong> has been added! <a href='manage_customer.php'>Back to Manage Customers</a></div>";
      echo $msg;
    }
  }
}
}
?>

<form action="add_customer.php" method="POST">
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Add New Customer</span>
        </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-6">

          <div class="form-group">
            <label for="firstname">Customer Store Name</label>
            <input type="text" class="form-control" name="customer_store" placeholder="Customer Store" required autocomplete="off">
          </div>

          <div class="form-group">
            <label for="lastname">Customer Contact #</label>
            <input type="text" class="form-control" name="customer_contact" placeholder="Customer Contact #" required autocomplete="off">
          </div>
          
          <div class="form-group">
            <label for="lastname">Customer Address</label>
            <input type="text" class="form-control" name="customer_address" placeholder="Customer Address" required autocomplete="off">
          </div>


          <div class="form-group"> 
            <a data-toggle="modal" data-target="#confirm-add" class="btn btn-info">Add Customer</a>
            <a href="manage_customer.php" class="btn btn-warning pull-right" >Back</a>
          </div>

          <!-- MODAL FOR UPDATE -->
          <div class="modal fade" id="confirm-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h3>Confirm Registration</h3>
                </div>
                <div class="modal-body">
                  Are you sure you want to add this customer?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <input type="submit" name="submit" value="Register Customer" class="btn btn-info btn-ok"></a>
                </div>
              </div>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>
</div>

<?php include 'includes/admin_footer.php'; ?>