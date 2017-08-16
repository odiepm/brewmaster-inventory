<?php include 'includes/salesman_header.php'; ?>
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
      <a href="print_salesman_sales.php" class="btn btn-default pull-right"><i class="glyphicon glyphicon-print"></i> Print</a>
        <table class="table table-hover table-condensed table-bordered table-striped">
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
            FROM {$prefix}sws WHERE date BETWEEN '$dateFrom' AND '$dateTo'
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

  <a href="history_sales.php" class="btn btn-default">Back</a>

    </div>
  </div>
  <!-- /.row -->
</div>
<!-- /.container-fluid -->

<!-- /#page-wrapper -->

<?php include 'includes/salesman_footer.php'; ?>
