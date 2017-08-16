<?php include 'includes/salesman_header.php'; ?>

<div class="row">
  <div class="col-md-12">
  <h1>Order Reports
  <hr>
</h1>
    <div class="panel panel-default">
    <div class="panel-heading clearfix">
      <strong>
        <span class="glyphicon glyphicon-calendar"></span>
        <span>Today's Order Report</span>
     </strong>
    </div>

     <div class="panel-body">
      <table class="table table-bordered table-striped table-hover table-condensed" id="example">
        <thead>
          <tr>
            <th>#</th>
          	<th>Supplier/Salesman</th>
            <th>Order Type</th>
            <th>Date Added</th>
            <th>Product Name </th>
            <th>Product Description </th>
            <th>Product Expiry </th>
            <th>Quantity </th>
          </tr>
        </thead>
        <tbody>
        <?php


        $selectRange = "SELECT DISTINCT * FROM {$prefix}reports WHERE report_date = '$expiryDateMin' ORDER BY report_id desc;";
		    $sqlExec2 = mysqli_query($connection, $selectRange);

        $tableCount = 0;
        while ($row = mysqli_fetch_array($sqlExec2)) {

          $report_id = $row['report_id'];
          $report_supplier = $row['report_supplier'];
          $report_type = $row['report_type'];
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
            <td><?php echo $report_type; ?></td>
            <td><?php echo $report_date; ?></td>
            <td><?php echo $report_product; ?></td>
            <td><?php echo $report_description; ?></td>
            <td><?php echo $report_expiry; ?></td>
            <td><?php echo $report_quantity; ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>

      <hr>  
      <?php 

      if ($tableCount > 0) {

      ?>
        <a href="print_orderreport.php" class="btn btn-default pull-left"><i class="glyphicon glyphicon-print"></i> Print Report</a>
      <?php
      }

       ?>
    </div>
      
   </div>
   </div>

</div>

<?php include 'includes/salesman_footer.php'; ?>