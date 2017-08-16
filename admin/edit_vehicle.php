<?php include 'includes/admin_header.php'; ?>

<?php 

//GET id on edit url
if (isset($_GET['edit'])) {

  $vehicle_id = $_GET['edit'];

  $selectQuery = "SELECT * FROM {$prefix}vehicles WHERE vehicle_id = $vehicle_id;";
  $execQuery = mysqli_query($connection, $selectQuery);

  while ($row = mysqli_fetch_array($execQuery)) {

    $vehicle_lastname  = $row['vehicle_lastname'];
    $vehicle_firstname = $row['vehicle_firstname'];
    $vehicle_plateno   = $row['vehicle_plateno'];
  }

  if (isset($_POST['vehicle_plateno'])) {

    $vehicle_platenoPost = $_POST['vehicle_plateno'];

    $sql = "SELECT * FROM {$prefix}vehicles WHERE vehicle_plateno = '$vehicle_platenoPost';";
    $res = mysqli_query($connection, $sql);

    if (!($vehicle_plateno == $vehicle_platenoPost)) {
      if($res && mysqli_num_rows($res) > 0) {

        echo "<div class='alert alert-danger'>The Plate No: <strong>{$vehicle_platenoPost}</strong> is taken!</div>";
      } else {

        $vehicle_firstname = $_POST['vehicle_firstname'];
        $vehicle_lastname  = $_POST['vehicle_lastname'];
        $vehicle_plateno     = $_POST['vehicle_plateno'];


        $query = "UPDATE {$prefix}vehicles SET vehicle_firstname = '$vehicle_firstname', vehicle_lastname = '$vehicle_lastname', 
        vehicle_plateno = $vehicle_plateno WHERE vehicle_id = $vehicle_id";
        $execQuery = mysqli_query($connection,$query);

        $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername edited vehicle: $vehicle_plateno', '$activityDate');";
        $execLog = mysqli_query($connection, $queryLog);


        if (!$execQuery) {
          die(mysqli_error($connection));
        } else {
          $msg ="<div class='alert alert-success'><strong>{$vehicle_plateno}</strong> has been updated! <a href='manage_drivers.php'>Back to Vehicles</a></div>";
          echo $msg;
        }

      }

    } else {

      if (isset($_POST['update'])) {

        $vehicle_firstname = $_POST['vehicle_firstname'];
        $vehicle_lastname  = $_POST['vehicle_lastname'];
        $vehicle_plateno     = $_POST['vehicle_plateno'];
        
        $query = "UPDATE {$prefix}vehicles SET vehicle_firstname = '$vehicle_firstname', vehicle_lastname = '$vehicle_lastname', 
        vehicle_plateno = $vehicle_plateno WHERE vehicle_id = $vehicle_id";
        $execQuery = mysqli_query($connection,$query);


        $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername edited vehicle: $vehicle_plateno', '$activityDate');";
        $execLog = mysqli_query($connection, $queryLog);

        if (!$execQuery) {
          die(mysqli_error($connection));
        } else {
          $msg ="<div class='alert alert-success'><strong>{$vehicle_plateno}</strong> has been updated! <a href='manage_drivers.php'>Back to Vehicles</a></div>";
          echo $msg;
        }
      }
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
          <span>Edit Vehicle</span>
        </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-6">

          <div class="form-group">
            <label for="firstname">Driver's Firstname</label>
            <input type="text" class="form-control" name="vehicle_firstname" value="<?php echo $vehicle_firstname; ?>" required>
          </div>

          <div class="form-group">
            <label for="lastname">Driver's Lastname</label>
            <input type="text" class="form-control" name="vehicle_lastname" value="<?php echo $vehicle_lastname; ?>" required>
          </div>


          <div class="form-group">
            <label for="lastname">Plate No.</label>
            <input type="text" class="form-control" name="vehicle_plateno" value="<?php echo $vehicle_plateno; ?>" required>
          </div>

          <div class="form-group"> 
            <a class="btn btn-info" data-toggle="modal" data-target="#confirm-update">Update Vehicle</a>
            <a href="manage_drivers.php" class="btn btn-warning pull-right" >Back</a>

            <!-- MODAL FOR UPDATE -->
            <div class="modal fade" id="confirm-update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3>Confirm Update</h3>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to update this vehicle?
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