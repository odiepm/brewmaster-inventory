<?php include 'includes/salesman_header.php'; ?>
<script type="text/javascript" src="js/loader.js"></script>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">History of Sales (Today)</h3>
      </div>
      <div class="panel-body">
  <div class="form-group">
      <a href="print_salesman_today.php" class="btn btn-default pull-right"><i class="glyphicon glyphicon-print"></i> Print</a>
      </div>
        <table class="table table-hover table-condensed table-bordered table-striped" id="example">
          <thead>
            <tr>
              <th>Top #</th>
              <th>Employee No.</th>
              <th>Salesman Name</th>
              <th>Total Sales</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $top = 0;
            $top5salesman = "SELECT sws_salesman, sws_smname, SUM(sws_unitprice * sws_quantity) AS TotalSales
            FROM {$prefix}sws WHERE date = '$displayDate'
            GROUP BY sws_salesman
            ORDER BY SUM(sws_unitprice * sws_quantity) DESC";
            $top5salesmanE = mysqli_query($connection, $top5salesman);

            while ($row = mysqli_fetch_array($top5salesmanE)) {
              $sws_salesman = $row['sws_salesman'];
              $sws_smname = $row['sws_smname'];
              $TotalSales = $row['TotalSales'];
              $top++;
              ?>
              <tr>
                <td><?php echo $top; ?></td>
                <td><?php echo sprintf('%08d', $sws_salesman); ?></td>
                <td><?php echo $sws_smname; ?></td>
                <td><?php echo '₱ '. number_format($TotalSales, 2); ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="col-md-12">
        <h1> Salesman Report Date
          <hr>
        </h1>
        <div class="col-md-12">
          <div class="panel panel-primary">
            <div class="panel-body">
              <form action="history_sales_date.php" method="POST">

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
