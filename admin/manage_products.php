<?php include 'includes/admin_header.php'; ?>
<div class="row">


  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Product List</span>
        </strong>
        <a href="print_products.php" class="btn btn-default pull-right btn-md"><i class="glyphicon glyphicon-print"></i> Product List</a>
        <a href="add_products.php" class="btn btn-info pull-right btn-md"><i class="glyphicon glyphicon-plus"></i> Add New Product</a>
      </div>

      <div class="panel-body">

        <table class="table table-bordered table-striped table-hover table-condensed results" id="example">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Product Code</th>
              <th class="text-center">Product Name</th>
              <th class="text-center">Description</th>
              <th class="text-center">Unit per Case</th>
              <th class="text-center">Expiry Date</th>
              <th class="text-center">Category</th>
              <th class="text-center">Instock</th>
              <th class="text-center">Selling Price</th>
              <th class="text-center">Empties</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php  

            $userQuery = "SELECT * FROM {$prefix}products;";
            $selectQuery = mysqli_query($connection,$userQuery);

            $tableCount = 0;
            while ($row = mysqli_fetch_array($selectQuery)) {
              $product_id = $row['product_id'];
              $product_name = $row['product_name'];
              $description = $row['description'];
              $quantity = $row['quantity'];
              $sell_price = $row['sell_price'];
              $category_id = $row['category_id'];
              $expiry_date = $row['expiry_date'];
              $product_code = $row['product_code'];
              $unit_per = $row['unit_per'];
              $isEmpty = $row['isEmpty'];

              $sell_price_formatted = number_format($sell_price, 2);
              $tableCount++;

              ($isEmpty == 1 ? $isEmptyString = 'Yes' : $isEmptyString = 'No'); 

              ?>

              
              <td class="text-center"><?php echo $tableCount; ?></td>
              <td class="text-center"><?php echo $product_code; ?></td>
              <td><?php echo $product_name; ?></td>
              <td><?php echo $description; ?></td>
              <td><?php echo $unit_per; ?></td>
              <td class="text-center"><?php echo $expiry_date; ?></td>

              <?php  

              $selectCat = "SELECT * FROM categories WHERE category_id = $category_id";
              $execCat = mysqli_query($connection,$selectCat);

              while ($row = mysqli_fetch_array($execCat)) {
                $category_name = $row['category_name'];

                echo "<td>$category_name</td>";
              }

              ?>

              <td><?php echo $quantity;?></td>
              <td class="text-center">₱ <?php echo $sell_price_formatted; ?></td>
              <td class="text-center"><?php echo $isEmptyString; ?></td>
              <td class="text-center">

               <div class="btn-group">
                <a href="edit_products.php?edit=<?php echo $product_id; ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                  <i class="glyphicon glyphicon-pencil"></i>
                </a>
                <a href="manage_products.php?delete=<?php echo $product_id; ?>" class="btn btn-xs btn-danger bbValid" data-toggle="tooltip" title="Remove">
                  <i class="glyphicon glyphicon-remove"></i>
                </a>
              </div>

            </td>
          </tr>
          <?php }  


          if (isset($_GET['delete'])) {
            $product_id = $_GET['delete'];

            $deleteGet = "SELECT * FROM {$prefix}products WHERE product_id = $product_id;";
            $deleteGetq = mysqli_query($connection, $deleteGet);

            while ($row = mysqli_fetch_array($deleteGetq)) {
              $product_name = $row['product_name'];
            }

            $checkCart = "SELECT * FROM {$prefix}cart WHERE product_id = $product_id;";
            $checkCartE = mysqli_query($connection, $checkCart);

            if (mysqli_num_rows($checkCartE) > 0) {
              echo "<script>bootbox.alert('Product is used in Cart!');</script>";
            } else{


              $deleteQuery = "DELETE FROM {$prefix}products WHERE product_id = $product_id";
              $execDelete = mysqli_query($connection, $deleteQuery);

              $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername deleted product: $product_name', '$activityDate');";
              $execLog = mysqli_query($connection, $queryLog);

              if ($execDelete){
                $msg ="<div class='alert alert-success col-xs-offset-2'><strong>{$product_name}</strong> is deleted!</div>";
                echo $msg;


                header("LOCATION:manage_products.php");

              } else {

                die(mysqli_error($connection));
              }
            }
          }

          ?>


        </tbody>
      </table>

      
    </div>
  </div>



  <?php 

          //Delete product
  if (isset($_GET['delete'])) {
    $product_id = $_GET['delete'];

    $deleteGet = "SELECT * FROM {$prefix}products WHERE product_id = $product_id;";
    $deleteGetq = mysqli_query($connection, $deleteGet);

    while ($row = mysqli_fetch_array($deleteGetq)) {
      $product_name = $row['product_name'];
    }

    $checkCart = "SELECT * FROM {$prefix}cart WHERE product_id = $product_id;";
    $checkCartE = mysqli_query($connection, $checkCart);

    if (mysqli_num_rows($checkCartE) > 0) {
      echo "<script>bootbox.alert('Product is used in Cart!');</script>";
    } else{


      $deleteQuery = "DELETE FROM {$prefix}products WHERE product_id = $product_id";
      $execDelete = mysqli_query($connection, $deleteQuery);

      $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername deleted product: $product_name', '$activityDate');";
      $execLog = mysqli_query($connection, $queryLog);

      if ($execDelete){
        $msg ="<div class='alert alert-success col-xs-offset-2'><strong>{$product_name}</strong> is deleted!</div>";
        echo $msg;


        header("LOCATION:manage_products.php");

      } else {

        die(mysqli_error($connection));
      }
    }
  }
  ?>

<div class="panel panel-danger">
  <div class="panel-heading">
    <h3 class="panel-title">3 Months Before Expiry</h3>
  </div>
  <div class="panel-body">

  <table class="table table-hover table-condensed table-striped" id="tae">
    <thead>
      <tr>
      <th>#</th>
      <th>Product Code</th>
      <th>Product Name</th>
      <th>Description</th>
      <th>Unit per Case</th>
      <th>Expiry Date</th>
      <th>Instock</th>
      </tr>
    </thead>
    <tbody>
        <?php 

        $query = "SELECT * 
        FROM {$prefix}products
        WHERE  STR_TO_DATE(expiry_date, '%Y-%m-%d') BETWEEN now() 
        AND DATE_ADD(now(), INTERVAL 3 MONTH)";
        $execQuery = mysqli_query($connection,$query);

        if (mysqli_num_rows($execQuery) > 0 ) {
          # code...
        

        $tableCount1 = 0;

        while ($row = mysqli_fetch_array($execQuery)) {
          $product_id = $row['product_id'];
          $product_name = $row['product_name'];
          $description = $row['description'];
          $quantity = $row['quantity'];
          $sell_price = $row['sell_price'];
          $category_id = $row['category_id'];
          $expiry_date = $row['expiry_date'];
          $product_code = $row['product_code'];
          $unit_per = $row['unit_per'];
          $isEmpty = $row['isEmpty'];

          $tableCount1++;
        }
        ?>

      <tr>
        <td><?php echo $tableCount1; ?></td>
        <td><?php echo $product_code; ?></td>
        <td><?php echo $product_name; ?></td>
        <td><?php echo $description; ?></td>
        <td><?php echo $unit_per; ?></td>
        <td><?php echo $expiry_date; ?></td>
        <td><?php echo $quantity; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  </div>
</div>





</div>
</div>


<?php include 'includes/admin_footer.php'; ?>