<?php include 'includes/admin_header.php'; ?>

<div class="row">
  <div class="col-md-12">
    <h3> Manage Stock Request by Other Branches </h3>
    <hr>
    <div class="well well-sm">
      <ol class="breadcrumb" style="margin-bottom: -3px;">
        <li><strong>Request by Branches</strong> <span class="badge"><?php echo $toPending; ?></span></li>
        <li class="active">
          <a href="stock_requests_partial.php">Partially Transfered Requests</a> <span class="badge" style="background-color:#f89406"><?php echo $toProgress; ?></span>
        </li>
        <li class="active"><a href="stock_requests_complete.php">Completed Requests </a><span class="badge" style="background-color:#468847"><?php echo $toComplete; ?></span></li>
        <li class="active"><a href="stock_requests_canceled.php">Canceled Requests <span class="badge" style="background-color: #b94a48"><?php echo $toCanceled; ?></span></a></li>
      </ol>
    </div>

    <div class="panel panel-primary">
      <div class="panel-body">
      <h3>Requests by Other Branches</h3>
      <hr>
        <table class="table table-condensed table-hover table-bordered table-striped" id="example">
          <thead>
            <tr>
              <th>#</th>
              <th>Transfer Number</th>
              <th>Request By Branch</th>
              <th>To Branch</th>
              <th>Status</th>
              <th>Date of Placement</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php 

              $pending = "SELECT * FROM stock_transfer WHERE transfer_tobranch = '$capitalPrefix' AND transfer_status ='Pending' GROUP BY (transfer_number);";
              $pendingE = mysqli_query($connection, $pending);

              $tableCount = 0;
              while ($row = mysqli_fetch_array($pendingE)) {
                  $transfer_id = $row['transfer_id'];
                  $transfer_number = $row['transfer_number'];
                  $transfer_status = $row['transfer_status'];
                  $transfer_frombranch = $row['transfer_frombranch'];
                  $transfer_tobranch = $row['transfer_tobranch'];
                  $transfer_product_id = $row['transfer_product_id'];
                  $transfer_quantity = $row['transfer_quantity'];
                  $transfer_date = $row['transfer_date'];
                  $tableCount++;
             ?>
              <tr>
                <td><?php echo $tableCount; ?></td>
                <td><?php echo sprintf('%08d', $transfer_number); ?></td>
                <td><?php echo $transfer_frombranch; ?></td>
                <td><?php echo $transfer_tobranch; ?></td>
                <td><?php echo $transfer_status; ?></td>
                <td><?php echo $transfer_date; ?></td>
                <td>
                  <a href="stock_transfer_request.php?tid=<?php echo $transfer_number; ?>" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-import"></i> Manage</a>
                  <a href="stock_details2.php?id=<?php echo $transfer_number; ?>" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-list"></i> Details</a>
                  <a href="stock_manage_requests.php?cancel=<?php echo $transfer_number; ?>" class="btn btn-xs btn-danger bbValid"><i class="glyphicon glyphicon-trash"></i> Cancel</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <a href="stock_transfer.php" class="btn btn-default">Back</a>
      </div>
    </div>
    <hr>
  
  </div>

</div>

<?php 

  if (isset($_GET['cancel'])) {
      $cancelID = $_GET['cancel'];

      $delete = "UPDATE stock_transfer SET transfer_status = 'Canceled' WHERE transfer_number = $cancelID;";
      $deleteE = mysqli_query($connection, $delete);

      header("Refresh:0; url=stock_manage_requests.php");
    }  

 ?>
<?php include 'includes/admin_footer.php'; ?>