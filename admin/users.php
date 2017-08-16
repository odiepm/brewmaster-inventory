<?php include 'includes/admin_header.php'; ?>


<div class="row">
  <div class="col-md-12">
  </h1>
  <div class="panel panel-default">
    <div class="panel-heading clearfix">
      <strong>
        <span class="glyphicon glyphicon-user"></span>
        <span>Users</span>
      </strong>
      <a href="add_user.php" class="btn btn-info pull-right btn-md"><i class="glyphicon glyphicon-plus"></i> Add New User</a>
    </div>

    <div class="panel-body">

      <table class="table table-condensed table-bordered" id="example">
        <thead>
          <tr>
            <th class="text-center">#</th>
            <th class="text-center">First Name</th>
            <th class="text-center">Last Name</th>
            <th class="text-center">Username</th>
            <th class="text-center">Contact #</th>
            <th class="text-center">Email</th>
            <th class="text-center">User Role</th>
            <th class="text-center">Action</th>

          </tr>
        </thead>
        <tbody>

          <?php  

          $userQuery = "SELECT * FROM users WHERE branch = '$capitalPrefix'";
          $selectQuery = mysqli_query($connection,$userQuery);
          $tableCount = 0;
          while ($row = mysqli_fetch_array($selectQuery)) {
           $userID = $row['user_id'];
           $lastname = $row['lastname'];
           $firstname = $row['firstname'];
           $username = $row['username'];
           $email = $row['email'];
           $role = $row['user_role'];
           $contact = $row['contact'];
           $tableCount++;
           ?>

           <tr>

             <td class="text-center"><?php echo $tableCount; ?></td>
             <td class="text-center"><?php echo ucwords($firstname); ?></td>
             <td class="text-center"><?php echo ucwords($lastname); ?></td>
             <td class="text-center"><?php echo $username; ?></td>
             <td class="text-center"><?php echo $contact; ?></td>
             <td class="text-center"><?php echo $email; ?></td>
             <td class="text-center"><?php echo $role; ?></td>
             <td class="text-center">

              <div class="btn-group">
                <a href="edit_user.php?edit=<?php echo $userID; ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                  <i class="glyphicon glyphicon-pencil"></i> Edit
                </a>

                <a class="btn btn-xs btn-danger bbValid" href="users.php?delete=<?php echo $userID; ?>"><i class="glyphicon glyphicon-trash"></i> Delete</a>
              </div>


            </td>
          </tr>


           <?php }  //End of while


           if (isset($_GET['delete'])) {
            $user_id = $_GET['delete'];

            $checkIfRecord = "SELECT * FROM {$prefix}sws WHERE sws_salesman = $user_id;";
            $checkIfRecordE = mysqli_query($connection, $checkIfRecord);

            if ($user_id == 1 || $user_id == 2 || $user_id == 3) {
              echo "<script>bootbox.alert('Invalid Request: You cannot delete own account')</script>";
            } elseif (mysqli_num_rows($checkIfRecordE) > 0) {
              echo "<script>bootbox.alert('Invalid Request: Salesman has a <strong>sales</strong> record on the database')</script>";
            } else {

            $delSel = "SELECT * FROM users WHERE user_id = $user_id AND branch = '$capitalPrefix';";
            $delSelexec = mysqli_query($connection, $delSel);

            while ($row = mysqli_fetch_array($delSelexec)) {
              $getName = $row['firstname'];
            }

              $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername deleted user: $getName', '$activityDate');";
              $execLog = mysqli_query($connection, $queryLog);

              $deleteQuery = "DELETE FROM users WHERE user_id = $user_id AND branch = '$capitalPrefix';";
              $execDelete = mysqli_query($connection, $deleteQuery);


              if ($execDelete){
                header("Refresh:0; url=users.php");
              } else {
                die(mysqli_error($connection));
              }
             //End of delete
          }
        }
          ?>

        </tbody>
      </table>



    </div>
  </div>
</div>

</div>

<?php include 'includes/admin_footer.php'; ?>