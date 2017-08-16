<?php include 'includes/admin_header.php' ?>
<div class="col-md-12">
 
  <div class="panel panel-default">
   <div class="panel-heading">
    <strong>
      <span class="glyphicon glyphicon-th"></span>
      <span>Empties</span>
    </strong>
  </div>
  <div class="panel-body">
    <a href="print_empties.php" class="btn btn-default pull-right btn-md"><i class="glyphicon glyphicon-print"></i> Print List</a>
    <h4>Product List:</h4>
    <table class="table table-bordered table-striped table-hover results table-condensed" id="example">
      <thead>
        <tr>

          <th class="text-center">#</th>
          <th class="text-center">Product Name</th>
          <th class="text-center">Description</th>
          <th class="text-center">Expiry Date</th>
          <th class="text-center">Empties</th>
        </tr>

      </thead>
      <tbody>
        <?php 

        $orderQuery = "SELECT * FROM {$prefix}products WHERE isEmpty > 0";
        $execOrder = mysqli_query($connection, $orderQuery);

        $tableCount = 0;
        while ($row = mysqli_fetch_array($execOrder)) {
          $product_code = $row['product_code'];
          $product_name = $row['product_name'];
          $description = $row['description'];
          $expiry_date = $row['expiry_date'];
          $empties = $row['empties'];
          $tableCount++;
          ?>
          <tr>
            <td class="text-center"><?php echo $product_code; ?></td>
            <td class="text-center"><?php echo $product_name; ?></td>
            <td class="text-center"><?php echo $description; ?></td>
            <td class="text-center"><?php echo $expiry_date; ?></td>
            <td class="text-center"><?php echo $empties; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>


    </div>
  </div>
</div>



<?php include 'includes/admin_footer.php' ?>  