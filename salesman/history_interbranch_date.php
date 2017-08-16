<?php include 'includes/salesman_header.php'; ?>
<?php 
if (isset($_POST['submit'])) {
 $date1= $_POST['dateFrom'];
 $date2= $_POST['dateTo'];

 $_SESSION['dateFrom'] = date('Y-m-d', strtotime($date1));
 $_SESSION['dateTo']  = date('Y-m-d', strtotime($date2));

 $dateFrom = $_SESSION['dateFrom'];
 $dateTo = $_SESSION['dateTo'];

}

 ?>
<script type="text/javascript" src="js/loader.js"></script>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">History of Transactions (Date)</h3>
      </div>
      <div class="panel-body">
        <div class="form-group">
          <a href="print_stock_date.php" class="btn btn-default pull-right"><i class="glyphicon glyphicon-print"></i> Print</a>
        </div>
        <table class="table table-bordered table-striped table-hover table-condensed results" id="example">
          <thead>
            <tr>
              <th class="text-center">Transfer #</th>
              <th class="text-center">Branch Transferred To</th>
              <th class="text-center">Product Code</th>
              <th class="text-center">Product Name</th>
              <th class="text-center">Unit Per Case/Box</th>
              <th class="text-center">Requested</th>
              <th class="text-center">Transferred</th>
            </tr>
          </thead>
          <tbody>
            <?php  
            $branch = $_SESSION['branch'];
            $userQuery = "SELECT * FROM stock_transfer 
                          INNER JOIN {$prefix}products ON stock_transfer.transfer_product_code = {$prefix}products.product_code
            WHERE transfer_tobranch = '$branch' AND transfer_status = 'Transfer Complete'
            AND transfer_date BETWEEN '$dateFrom' AND '$dateTo'";

            $selectQuery = mysqli_query($connection,$userQuery);

            while ($row = mysqli_fetch_array($selectQuery)) {
              $transfer_number = $row['transfer_number'];
              $transfer_status = $row['transfer_status'];
              $transfer_frombranch = $row['transfer_frombranch'];
              $transfer_tobranch = $row['transfer_tobranch'];
              $transfer_product_id = $row['transfer_product_id'];
              $transfer_product_code = $row['transfer_product_code'];
              $product_name = $row['product_name'];
              $transfer_quantity = $row['transfer_quantity'];
              $stocks_transferred = $row['stocks_transferred'];
              $st_unit_per = $row['st_unit_per'];

              ?>
              <td class="text-center"><?php echo sprintf('%08d', $transfer_number); ?></td>
              <td><?php echo $transfer_frombranch; ?></td>
              <td><?php echo $transfer_product_code; ?></td>
              <td><?php echo $product_name; ?></td>
              <td><?php echo $st_unit_per; ?></td>
              <td><?php echo $transfer_quantity; ?></td>
              <td><?php echo $stocks_transferred; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->

<!-- /#page-wrapper -->

<?php include 'includes/salesman_footer.php'; ?>
