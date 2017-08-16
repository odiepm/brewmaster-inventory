<?php include 'includes/salesman_header.php'; ?>

<div class="row">


  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Inventory</span>
        </strong>
        <a href="print_products.php" class="btn btn-default pull-right btn-md"><i class="glyphicon glyphicon-print"></i> Product List</a>
      </div>

      <div class="panel-body">

        <table class="table table-bordered table-striped table-hover table-condensed results" id="example">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Product Name</th>
              <th class="text-center">Description</th>
              <th class="text-center">Instock</th>
            </tr>
          </thead>
          <tbody>
            <?php  

            $userQuery = "SELECT sum(quantity) as sumQuantity, p.* FROM {$prefix}products AS p GROUP BY product_name, description;";
            $selectQuery = mysqli_query($connection,$userQuery);

            $tableCount = 0;
            while ($row = mysqli_fetch_array($selectQuery)) {
              $product_id = $row['product_id'];
              $product_name = $row['product_name'];
              $description = $row['description'];
              $sumQuantity = $row['sumQuantity'];
              $sell_price = $row['sell_price'];
              $category_id = $row['category_id'];
              $expiry_date = $row['expiry_date'];
              $isEmpty = $row['isEmpty'];

              $sell_price_formatted = number_format($sell_price, 2);
              $tableCount++;

              ?>
   
              <td class="text-center"><?php echo $tableCount; ?></td>
              <td><?php echo $product_name; ?></td>
              <td><?php echo $description; ?></td>
              <td><?php echo $sumQuantity;?></td>
          </tr>
                <?php } ?>
        </tbody>
      </table>

      
    </div>
  </div>
</div>
</div>

<?php include 'includes/salesman_footer.php'; ?>