<?php include 'includes/admin_header.php'; ?>
<script type="text/javascript" src="js/loader.js"></script>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Select Salesman (Today)</h3>
      </div>
      <div class="panel-body">
        <form action="history_salesman2.php" method="post">
          <div class="form-group">
            <label for="selectSalesman">Select Salesman</label>
            <select name="selectSalesman" class="form-control">
              <option value="">Select Salesman</option>
              <?php 

              $sql = "SELECT * FROM users WHERE user_role = 'Salesman' AND branch = '$capitalPrefix'";
              $sqlE = mysqli_query($connection, $sql);

              while ($row = mysqli_fetch_array($sqlE)) {
                $user_id = $row['user_id'];
                $userFN = $row['firstname'];
                $userLN = $row['lastname'];
                ?>
                <option value="<?php echo $user_id; ?>"><?php echo $userFN . " " . $userLN; ?></option>
                <?php } ?>
              </select>
              <input type="submit" name="submit" value="Select" class="btn btn-info pull-right">
            </div>
          </form>


        </div>
      </div>
      <div class="col-md-12">
        <div class="panel panel-primary">
          <div class="panel-body">
            <h1> Select Dated History
              <hr>
            </h1>
            <form action="history_salesman_dated.php" method="POST">
            <div class="col-md-12">
                <label for="selectSalesman">Select Salesman</label>
                <select name="selectSalesman" class="form-control">
                  <option value="">Select Salesman</option>
                  <?php 

                  $sql = "SELECT * FROM users WHERE user_role = 'Salesman' AND branch = '$capitalPrefix'";
                  $sqlE = mysqli_query($connection, $sql);

                  while ($row = mysqli_fetch_array($sqlE)) {
                    $user_id = $row['user_id'];
                    $userFN = $row['firstname'];
                    $userLN = $row['lastname'];
                    ?>
                    <option value="<?php echo $user_id; ?>"><?php echo $userFN . " " . $userLN; ?></option>
                    <?php } ?>
                  </select>

                </div>
                <div>
                  <div class="col-md-6">
                    <label for="">From</label>
                    <input type="date" name="dateFrom" class="form-control" value="<?php echo date('Y-m-d'); ?>" />
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="">To</label>
                  <input type="date" name="dateTo" class="form-control" value="<?php echo date('Y-m-d'); ?>" />
                </div>

                <div class="col-md-12">
                  <br>
                  <input type="submit" name="submitDate" class="btn btn-info" value="Confirm"/>
                  <hr>
                </div>
              </form>
            </div>
          </div>


        </div>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->

  <!-- /#page-wrapper -->

  <?php include 'includes/admin_footer.php'; ?>
