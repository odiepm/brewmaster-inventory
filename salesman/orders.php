<?php include 'includes/salesman_header.php'; ?>

<div class="row">
  <div class="col-md-12">
  <h1> Order Reports
  <hr>
</h1>
    <div class="panel panel-default">
    <div class="panel-heading clearfix">
      <strong>
        <span class="glyphicon glyphicon-calendar"></span>
        <span>Select Date</span>
     </strong>
    </div>

     <div class="panel-body">
     <?php
      $dateFrom = '';
      $dateTo = ''; 
     ?>
      <form action="orders.php" method="POST">

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

      <table class="table table-hover table-striped table-condensed" id="example">
        <thead>
          <tr>
            <th>Order #</th>
            <th>Supplier/Salesman</th>
            <th class="text-left">Date Added</th>
            <th>Order Type</th>
            <th>Product Name</th>
            <th>Product Description</th>
            <th>Product Expiry</th>
            <th>Quantity</th>
          </tr>
        </thead>
        <tbody>
        <?php 
        $tableCount = 0;
     if (isset($_POST['submit'])) {
        $dateFrom = date('Y-m-d', strtotime($_POST['dateFrom']));
        $dateTo = date('Y-m-d', strtotime($_POST['dateTo']));

      
        $sqlSelect2 =  "SELECT DISTINCT * FROM {$prefix}reports WHERE report_date BETWEEN '$dateFrom' AND '$dateTo' ORDER BY report_id desc;";
        $sqlExec2 = mysqli_query($connection, $sqlSelect2);

        while ($row = mysqli_fetch_array($sqlExec2)) {

          $report_id = $row['report_id'];
          $report_type = $row['report_type'];
          $report_supplier = $row['report_supplier'];
          $report_product = $row['report_product'];
          $report_description = $row['report_description'];
          $report_quantity = $row['report_quantity'];
          $report_date = $row['report_date'];
          $report_expiry = $row['report_expiry'];
          
          $tableCount++;
         ?>

         <tr>
           <td><?php echo $tableCount; ?></td>
           <td><?php echo $report_supplier; ?></td>
           <td><?php echo $report_date; ?></td>
           <td><?php echo $report_type; ?></td>
           <td><?php echo $report_product; ?></td>
           <td><?php echo $report_description; ?></td>
           <td><?php echo $report_expiry; ?></td>
           <td><?php echo $report_quantity; ?></td>
         </tr>
        <?php } } ?>
        </tbody>
      </table>
      <hr>

      
      <?php 

      if ($tableCount > 0) {

      ?>
        <a href="print_orderreport2.php?dateFrom=<?php echo $dateFrom; ?>&dateTo=<?php echo $dateTo; ?>" class="btn btn-default pull-left"><i class="glyphicon glyphicon-print"></i> Print Report</a>
      <?php
      }

       ?>

    </div>
   </div>
 </div>

</div>


<?php include 'includes/salesman_footer.php'; ?>