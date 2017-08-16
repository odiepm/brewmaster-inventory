<?php include 'includes/admin_header.php'; ?>
<script type="text/javascript" src="js/loader.js"></script>
<?php 

if (isset($_POST['submit'])) {
 $date1= $_POST['dateFrom'];
 $date2= $_POST['dateTo'];

 $_SESSION['dateFrom'] = date('m/d/Y', strtotime($date1));
 $_SESSION['dateTo']  = date('m/d/Y', strtotime($date2));

 $dateFrom = $_SESSION['dateFrom'];
 $dateTo = $_SESSION['dateTo'];

}

 ?>
<div class="row">
  <div class="col-md-12">

    <div class="panel panel-primary">
      <div class="panel-heading">
      <h3 class="panel-title">History of Sales (Date)</h3>
      </div>
      <div class="panel-body">
      <a href="print_transcation_date.php" class="btn btn-default pull-right"><i class="glyphicon glyphicon-print"></i> Print</a>
        <table class="table table-hover table-condensed table-bordered table-striped">
          <thead>
            <tr>
            <th class="text-center">#</th>
            <th class="text-center">Customer Name</th>
            <th class="text-center">Customer Address</th>
            <th class="text-center">Customer Contact</th>
            <th class="text-center">Total Sales</th>
            <th class="text-center">Date</th>
            <th class="text-center">View OR</th>
            </tr>
          </thead>
          <tbody>
            <?php  

            $userQuery = "SELECT * FROM {$prefix}customer 
            INNER JOIN {$prefix}sws ON {$prefix}customer.customer_sws_id = {$prefix}sws.sws_number
            WHERE date BETWEEN '$dateFrom' and '$dateTo'
            GROUP BY customer_distribution_id;";
            $selectQuery = mysqli_query($connection,$userQuery);

            $tableCount = 0;
            $productTableTotal = 0;
            while ($row = mysqli_fetch_array($selectQuery)) {
              $customer_name = $row['customer_name'];
              $customer_address = $row['customer_address'];
              $customer_contact = $row['customer_contact'];
              $customer_distribution_id = $row['customer_distribution_id'];
              $customer_product_qty = $row['customer_product_qty'];
              $customer_product_price = $row['customer_product_price'];
              $date = $row['date'];

              $productTable = $customer_product_qty * $customer_product_price;
              $productTableTotal += $productTable;

              $tableCount++;

              ?>
              <td class="text-center"><?php echo $tableCount; ?></td>
              <td><?php echo $customer_name; ?></td>
              <td><?php echo $customer_address; ?></td>
              <td><?php echo $customer_contact; ?></td>
              <td><?php echo '₱ '. number_format($productTableTotal,2); ?></td>
              <td><?php echo $date; ?></td>
              <td class="text-center>">
                <a href='or_print.php?id=<?php echo $customer_distribution_id; ?>' class='btn btn-xs btn-primary' title='View Details' >View OR</a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
          </table>
        </div>
      </div>

  <a href="history_transaction.php" class="btn btn-default">Back</a>

    </div>
  </div>
  <!-- /.row -->
</div>
<!-- /.container-fluid -->

<!-- /#page-wrapper -->

<?php include 'includes/admin_footer.php'; ?>
