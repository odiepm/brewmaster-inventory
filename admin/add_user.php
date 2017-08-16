<?php include 'includes/admin_header.php'; ?>

<?php 

if (isset($_POST['submit'])) {

  if (isset($_POST['username'])) {

    $username = $_POST['username'];

    $sql = "SELECT * FROM users WHERE username = '$username';";
    $res = mysqli_query($connection, $sql);

    if($res && mysqli_num_rows($res) > 0){

      echo "<div class='alert alert-danger'>The username: <strong>{$username}</strong> is already taken!</div>";

    } else {

      $username = $_POST['username'];


      $firstname = $_POST['firstname'];
      $lastname  = $_POST['lastname'];
      $email     = $_POST['email'];
      $contact   = $_POST['contact'];
      $password  = $_POST['password'];
      $user_role = $_POST['user_role'];
      
      $query = "INSERT INTO users (firstname, lastname, username, password, email, contact, user_role, branch) 
      VALUES ('$firstname', '$lastname', '$username', '$password', '$email','$contact', '$user_role', '$capitalPrefix')";
      $execQuery = mysqli_query($connection,$query);

      $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername registered user: $username', '$activityDate');";
      $execLog = mysqli_query($connection, $queryLog);

      if(!$execQuery) {
       die(mysqli_error($connection));
     } else {
      $msg ="<div class='alert alert-success'><strong>{$username}</strong> has been added! <a href='users.php'>Back to Manage Users</a></div>";
      echo $msg;
    }
  }
}
}
?>

<form action="add_user.php" method="POST">
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Add New User</span>
        </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-6">

          <div class="form-group">
            <label for="firstname">Firstname</label>
            <input type="text" class="form-control" name="firstname" placeholder="First Name" required autocomplete="off">
          </div>

          <div class="form-group">
            <label for="lastname">Lastname</label>
            <input type="text" class="form-control" name="lastname" placeholder="Last Name" required autocomplete="off">
          </div>

          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" placeholder="Username" pattern="^(?!.*\.\.)(?!.*\.$)[^\W][\w.]{3,29}$" required autocomplete="off">
            <small>Usernames can contain characters a-z, 0-9, underscores and periods. The username cannot start with a period nor end with a period. It must also not have more than one period sequentially. Max length is 30 chars.</small>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name ="password"  placeholder="Password" required autocomplete="off">
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Email" required autocomplete="off">
          </div>

          <div class="form-group">
            <label for="contact">Contact #</label>
            <input type="number" class="form-control" name="contact" placeholder="09151234567" required autocomplete="off">
          </div>

          <div class="form-group">
            <label for="role">User Role</label>
            <select class="form-control" name="user_role" required>
             <option value='Admin'>Admin</option>
             <option value='Salesman'>Salesman</option>
           </select>
         </div>

         <div class="form-group"> 
          <a data-toggle="modal" data-target="#confirm-add" class="btn btn-info">Add User</a>
          <a href="users.php" class="btn btn-warning pull-right" >Back</a>
        </div>

        <!-- MODAL FOR UPDATE -->
        <div class="modal fade" id="confirm-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h3>Confirm Registration</h3>
              </div>
              <div class="modal-body">
                Are you sure you want to add this user?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <input type="submit" name="submit" value="Register User" class="btn btn-info btn-ok"></a>
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