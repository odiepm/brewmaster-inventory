<?php include 'includes/salesman_header.php'; ?>
<script type="text/javascript" src="js/loader.js"></script>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">History of Transactions (Today)</h3>
      </div>
      <div class="panel-body">
        <div class="form-group">
          <a href="print_transcation.php" class="btn btn-default pull-right"><i class="glyphicon glyphicon-print"></i> Print</a>
        </div>
        <table class="table table-bordered table-striped table-hover table-condensed results" id="example">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Salesman Name</th>
              <th class="text-center">Customer Name</th>
              <th class="text-center">Customer Address</th>
              <th class="text-center">Customer Contact</th>
              <th class="text-center">Total Sales</th>
              <th class="text-center">View OR</th>
            </tr>
          </thead>
          <tbody>
            <?php  

            $userQuery = "SELECT * FROM {$prefix}customer 
            INNER JOIN {$prefix}sws ON {$prefix}customer.customer_sws_id = {$prefix}sws.sws_number
            WHERE date = '$displayDate'
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
              $sws_smname = $row['sws_smname'];
              $date = $row['date'];

              $productTable = $customer_product_qty * $customer_product_price;
              $productTableTotal += $productTable;

              $tableCount++;

              ?>
              <td class="text-center"><?php echo $tableCount; ?></td>
              <td class="text-center"><?php echo $sws_smname; ?></td>
              <td><?php echo $customer_name; ?></td>
              <td><?php echo $customer_address; ?></td>
              <td><?php echo $customer_contact; ?></td>
              <td><?php echo '₱ '. number_format($productTableTotal,2); ?></td>
              <td class="text-center>">
                <a href='or_print.php?id=<?php echo $customer_distribution_id; ?>' class='btn btn-xs btn-primary' title='View Details' >View OR</a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="col-md-12">
      <h1> Transaction Report Date
        <hr>
      </h1>
      <div class="col-md-12">
        <div class="panel panel-primary">
          <div class="panel-body">
            <form action="history_transaction_date.php" method="POST">

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
                <input type="submit" name="submit" class="btn btn-info" value="Confirm"/>
                <hr>
              </div>
            </form>
          </div>
        </div>

      </div>

    </div>

  </div>
</div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->

<!-- /#page-wrapper -->

<?php include 'includes/salesman_footer.php'; ?>
