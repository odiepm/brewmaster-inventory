<?php include 'includes/admin_header.php'; ?>


<div class="row">
  <div class="col-md-12">
  </h1>
  <div class="panel panel-default">
    <div class="panel-heading clearfix">
      <strong>
        <span class="glyphicon glyphicon-user"></span>
        <span>Manage Customer</span>
      </strong>
      <a href="add_customer.php" class="btn btn-info pull-right btn-md"><i class="glyphicon glyphicon-plus"></i> Add Customer</a>
    </div>

    <div class="panel-body">

      <table class="table table-condensed table-bordered" id="example">
        <thead>
          <tr>
            <th class="text-center">Customer ID</th>
            <th class="text-center">Store Name</th>
            <th class="text-center">Customer Contact #</th>
            <th class="text-center">Customer Address</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>

          <?php  

          $userQuery = "SELECT * FROM {$prefix}customer_info";
          $selectQuery = mysqli_query($connection,$userQuery);
          while ($row = mysqli_fetch_array($selectQuery)) {

            $customer_info_id = $row['customer_info_id'];
            $customer_info_name = $row['customer_info_name'];
            $customer_info_number = $row['customer_info_number'];
            $customer_info_address = $row['customer_info_address'];

           ?>

           <tr>

             <td class="text-center"><?php echo $customer_info_id; ?></td>
             <td class="text-center"><?php echo $customer_info_name; ?></td>
             <td class="text-center"><?php echo $customer_info_number; ?></td>
             <td class="text-center"><?php echo $customer_info_address; ?></td>
             <td class="text-center">

              <div class="btn-group">
                <a href="edit_customer.php?edit=<?php echo $customer_info_id; ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                  <i class="glyphicon glyphicon-pencil"></i> Edit
                </a>

                <a class="btn btn-xs btn-danger bbValid" href="manage_customer.php?delete=<?php echo $customer_info_id; ?>"><i class="glyphicon glyphicon-trash"></i> Delete</a>
              </div>


            </td>
          </tr>


           <?php }  //End of while


           if (isset($_GET['delete'])) {
            $customer_info_id = $_GET['delete'];

            $checkIfRecord = "SELECT * FROM {$prefix}customer_info WHERE customer_info_id = $customer_info_id;";
            $checkIfRecordE = mysqli_query($connection, $checkIfRecord);

            while ($row = mysqli_fetch_array($checkIfRecordE)) {
              $getVehicleNo = $row['customer_info_id'];
            }

              $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername deleted Customer: $customer_info_id', '$activityDate');";
              $execLog = mysqli_query($connection, $queryLog);

              $deleteQuery = "DELETE FROM {$prefix}customer_info WHERE customer_info_id = $customer_info_id";
              $execDelete = mysqli_query($connection, $deleteQuery);

              header('Location:manage_customer.php');

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