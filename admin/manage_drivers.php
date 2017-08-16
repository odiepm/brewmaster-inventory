<?php include 'includes/admin_header.php'; ?>


<div class="row">
  <div class="col-md-12">
  </h1>
  <div class="panel panel-default">
    <div class="panel-heading clearfix">
      <strong>
        <span class="glyphicon glyphicon-user"></span>
        <span>Manage Vehicles</span>
      </strong>
      <a href="add_driver.php" class="btn btn-info pull-right btn-md"><i class="glyphicon glyphicon-plus"></i> Add Vehicle</a>
    </div>

    <div class="panel-body">

      <table class="table table-condensed table-bordered" id="example">
        <thead>
          <tr>
            <th class="text-center">Vehicle ID</th>
            <th class="text-center">Plate No.</th>
            <th class="text-center">Driver's Firstname</th>
            <th class="text-center">Driver's Lastname</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>

          <?php  

          $userQuery = "SELECT * FROM {$prefix}vehicles";
          $selectQuery = mysqli_query($connection,$userQuery);
          while ($row = mysqli_fetch_array($selectQuery)) {

            $vehicle_id = $row['vehicle_id'];
            $vehicle_firstname = $row['vehicle_firstname'];
            $vehicle_lastname = $row['vehicle_lastname'];
            $vehicle_plateno = $row['vehicle_plateno'];

           ?>

           <tr>

             <td class="text-center"><?php echo $vehicle_id; ?></td>
             <td class="text-center"><?php echo $vehicle_plateno; ?></td>
             <td class="text-center"><?php echo $vehicle_firstname; ?></td>
             <td class="text-center"><?php echo $vehicle_lastname; ?></td>
             <td class="text-center">

              <div class="btn-group">
                <a href="edit_vehicle.php?edit=<?php echo $vehicle_id; ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                  <i class="glyphicon glyphicon-pencil"></i> Edit
                </a>

                <a class="btn btn-xs btn-danger bbValid" href="manage_drivers.php?delete=<?php echo $vehicle_id; ?>"><i class="glyphicon glyphicon-trash"></i> Delete</a>
              </div>


            </td>
          </tr>


           <?php }  //End of while


           if (isset($_GET['delete'])) {
            $vehicle_id = $_GET['delete'];

            $checkIfRecord = "SELECT * FROM {$prefix}vehicles WHERE vehicle_id = $vehicle_id;";
            $checkIfRecordE = mysqli_query($connection, $checkIfRecord);

            while ($row = mysqli_fetch_array($checkIfRecordE)) {
              $getVehicleNo = $row['vehicle_id'];
            }

              $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername deleted Plate No: $getVehicleNo', '$activityDate');";
              $execLog = mysqli_query($connection, $queryLog);

              $deleteQuery = "DELETE FROM {$prefix}vehicles WHERE vehicle_id = $vehicle_id";
              $execDelete = mysqli_query($connection, $deleteQuery);

              echo $deleteQuery;


              if ($execDelete){
              } else {
                die(mysqli_error($connection));
              }
             //End of delete
          }
          ?>

        </tbody>
      </table>



    </div>
  </div>
</div>

</div>

<?php include 'includes/admin_footer.php'; ?>