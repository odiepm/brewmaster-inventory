<?php include 'includes/admin_header.php'; ?>

<?php 

//GET id on edit url
if (isset($_GET['edit'])) {

  $user_id = $_GET['edit'];

  $selectQuery = "SELECT * FROM users WHERE user_id = $user_id;";
  $execQuery = mysqli_query($connection, $selectQuery);

  while ($row = mysqli_fetch_array($execQuery)) {

    $firstname = $row['firstname'];
    $lastname  = $row['lastname'];
    $email     = $row['email'];
    $contact   = $row['contact'];
    $username  = $row['username'];
    $password  = $row['password'];
    $user_role = $row['user_role'];
  }

  if (isset($_POST['username'])) {

    $usernamePost = $_POST['username'];

    $sql = "SELECT * FROM users WHERE username = '$usernamePost';";
    $res = mysqli_query($connection, $sql);

    if (!($username == $usernamePost)) {

      if($res && mysqli_num_rows($res) > 0) {

        echo "<div class='alert alert-danger'>The username: <strong>{$usernamePost}</strong> is taken!</div>";
      } else {

        $firstname = $_POST['firstname'];
        $lastname  = $_POST['lastname'];
        $email     = $_POST['email'];
        $contact   = $_POST['contact'];
        $username  = $_POST['username'];
        $password  = $_POST['password'];

        $query = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', username = '$username', password = '$password' WHERE user_id = $user_id AND branch ='$capitalPrefix'";
        $execQuery = mysqli_query($connection,$query);

        $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername edited user: $username', '$activityDate');";
        $execLog = mysqli_query($connection, $queryLog);


        if (!$execQuery) {
          die(mysqli_error($connection));
        } else {
          $msg ="<div class='alert alert-success'><strong>{$username}</strong> has been updated! <a href='users.php'>Back to Users</a></div>";
          echo $msg;
        }

      }

    } else {

      if (isset($_POST['update'])) {

        $firstname = $_POST['firstname'];
        $lastname  = $_POST['lastname'];
        $email     = $_POST['email'];
        $contact   = $_POST['contact'];
        $username  = $_POST['username'];
        $password  = $_POST['password'];
        
        $query = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', username = '$username', password = '$password' WHERE user_id = $user_id AND branch ='$capitalPrefix'";
        $execQuery = mysqli_query($connection,$query);

        $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername edited user: $username', '$activityDate');";
        $execLog = mysqli_query($connection, $queryLog);

        if (!$execQuery) {
          die(mysqli_error($connection));
        } else {
          $msg ="<div class='alert alert-success'><strong>{$username}</strong> has been updated! <a href='users.php'>Back to Users</a></div>";
          echo $msg;
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
            <span>Edit User</span>
          </strong>
        </div>
        <div class="panel-body">
          <div class="col-md-6">

            <div class="form-group">
              <label for="firstname">Firstname</label>
              <input type="text" class="form-control" name="firstname" value="<?php echo $firstname; ?>" required>
            </div>

            <div class="form-group">
              <label for="lastname">Lastname</label>
              <input type="text" class="form-control" name="lastname" value="<?php echo $lastname; ?>" required>
            </div>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" name="username" pattern="^(?!.*\.\.)(?!.*\.$)[^\W][\w.]{3,29}$" value="<?php echo $username; ?>"  required>
              <small>Usernames can contain characters a-z, 0-9, underscores and periods. The username cannot start with a period nor end with a period. It must also not have more than one period sequentially. Max length is 30 chars.</small>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="text" class="form-control" name ="password"  value="<?php echo $password; ?>" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" name="email" value="<?php echo $email ?>" required>
            </div>
            <div class="form-group">
              <label for="contact">Contact #</label>
              <input type="text" class="form-control" name="contact" value="<?php echo $contact; ?>" required>
            </div>
            <div class="form-group">
              <label for="role">User Role</label>
              <select class="form-control" name="user_role" value="<?php echo $user_role; ?>" disabled>

                <option value='<?php echo $user_role; ?>'><?php echo $user_role;?></option>

                <?php  
              }
              ?>

            </select>
          </div>

          <div class="form-group"> 
            <a class="btn btn-info" data-toggle="modal" data-target="#confirm-update">Update User</a>
            <a href="users.php" class="btn btn-warning pull-right" >Back</a>

            <!-- MODAL FOR UPDATE -->
            <div class="modal fade" id="confirm-update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3>Confirm Update</h3>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to update this user?
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