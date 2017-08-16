<?php include 'includes/admin_header.php'; ?>

<?php 

if (isset($_POST['submit'])) {

  if (isset($_POST['vehicle_plateno'])) {

    $vehicle_firstname = $_POST['vehicle_firstname'];
    $vehicle_lastname  = $_POST['vehicle_lastname'];
    $vehicle_plateno   = $_POST['vehicle_plateno'];

    $sql = "SELECT * FROM {$prefix}vehicles WHERE vehicle_plateno = '$vehicle_plateno'";
    $res = mysqli_query($connection, $sql);

    if($res && mysqli_num_rows($res) > 0){

      echo "<div class='alert alert-danger'>The Plate No: <strong>{$vehicle_plateno}</strong> is already taken!</div>";

    } else {

      $query = "INSERT INTO {$prefix}vehicles (vehicle_firstname, vehicle_lastname, vehicle_plateno)  
      VALUES ('$vehicle_firstname', '$vehicle_lastname', '$vehicle_plateno')";
      $execQuery = mysqli_query($connection,$query);

      $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername registered vehicle: $vehicle_plateno', '$activityDate');";
      $execLog = mysqli_query($connection, $queryLog);

      if(!$execQuery) {
       die(mysqli_error($connection));
     } else {
      $msg ="<div class='alert alert-success'><strong>{$vehicle_plateno}</strong> has been added! <a href='manage_drivers.php'>Back to Manage Drivers</a></div>";
      echo $msg;
    }
  }
}
}
?>

<form action="add_driver.php" method="POST">
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Add New Vehicle</span>
        </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-6">

          <div class="form-group">
            <label for="firstname">Driver's Firstname</label>
            <input type="text" class="form-control" name="vehicle_firstname" placeholder="Driver's Firstname" required autocomplete="off">
          </div>

          <div class="form-group">
            <label for="lastname">Driver's Lastname</label>
            <input type="text" class="form-control" name="vehicle_lastname" placeholder="Driver's Lastname" required autocomplete="off">
          </div>
          
          <div class="form-group">
            <label for="lastname">Driver's Plate No.</label>
            <input type="text" class="form-control" name="vehicle_plateno" placeholder="Driver's Plate No." required autocomplete="off">
          </div>


          <div class="form-group"> 
            <a data-toggle="modal" data-target="#confirm-add" class="btn btn-info">Add Driver</a>
            <a href="manage_drivers.php" class="btn btn-warning pull-right" >Back</a>
          </div>

          <!-- MODAL FOR UPDATE -->
          <div class="modal fade" id="confirm-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h3>Confirm Registration</h3>
                </div>
                <div class="modal-body">
                  Are you sure you want to add this vehicle?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <input type="submit" name="submit" value="Register Vehicle" class="btn btn-info btn-ok"></a>
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