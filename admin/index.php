<?php include 'includes/admin_header.php'; ?>
<script type="text/javascript" src="js/loader.js"></script>
<?php  

$query = "SELECT * 
FROM {$prefix}products
WHERE  STR_TO_DATE(expiry_date, '%Y-%m-%d') BETWEEN now() 
                   AND DATE_ADD(now(), INTERVAL 3 MONTH)";
$execQuery = mysqli_query($connection,$query);

$monthCount =  mysqli_num_rows($execQuery);


$query = "SELECT * FROM {$prefix}orders WHERE status = 'Pending';";
$execQuery = mysqli_query($connection,$query);
$catCount = mysqli_num_rows($execQuery);

$query = "SELECT * FROM users WHERE branch = '$capitalPrefix';";
$execQuery = mysqli_query($connection,$query);
$userCount = mysqli_num_rows($execQuery);

$query = "SELECT * FROM {$prefix}cart;";
$execQuery = mysqli_query($connection,$query);
$salesCount = mysqli_num_rows($execQuery);

if (isset($_POST['submitSales'])) {
  $target_sales = $_POST['target_sales'];

  $insertSales = "UPDATE {$prefix}settings SET target_sales = $target_sales";
  $insertSalesE = mysqli_query($connection, $insertSales);

}

?>

<div class="row">
  <div class="panel panel-default">
    <div class="panel-body">

      <div class="col-lg-4 col-md-6">
        <div class="panel panel-green">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-user fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">


                <div class="huge"><?php echo $userCount; ?></div>

                <div>Users</div>
              </div>
            </div>
          </div>
          <a href="users.php">
            <div class="panel-footer">
              <span class="pull-left">Manage Users</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>


              <span class="clearfix"></span>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="panel panel-green">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-list fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">

                <div class="huge"></div>

                <div>Salesman Withdrawal</div>
              </div>
            </div>
          </div>
          <a href="select_salesman.php">
            <div class="panel-footer">
              <span class="pull-left">Salesman Withdrawal</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>        

              <span class="clearfix"></span>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="panel panel-yellow">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-th fa-5x"></i>
              </div>
              <div class="col-xs-9 text-right">

                <div class="huge"><?php echo $monthCount; ?></div>

                <div>Products Expiring (3 Months)</div>
              </div>
            </div>
          </div>
          <a href="manage_products.php">
            <div class="panel-footer">
              <span class="pull-left">Manage Products</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Top Selling Products</h3>
      </div>
      <div class="panel-body">
        <table class="table table-hover table-condensed table-bordered table-striped">
          <thead>
            <tr>
              <th>Top #</th>
              <th>Product Code</th>
              <th>Product Name</th>
              <th>Product Description</th>
              <th>Total Quantity</th>
              <th width="100px">Total Sales </th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $top = 0;
            $top5prod = "SELECT customer_product_code, customer_product_des, customer_product_name, SUM(customer_product_qty) AS TotalQuantity, SUM(customer_product_qty * customer_product_price) as TotalProdSales FROM {$prefix}customer GROUP BY customer_product_code ORDER BY SUM(customer_product_qty) DESC LIMIT 5";
            $top5prodE = mysqli_query($connection, $top5prod);


            while ($row = mysqli_fetch_array($top5prodE)) {
              $customer_product_code = $row['customer_product_code'];
              $customer_product_des = $row['customer_product_des'];
              $customer_product_name = $row['customer_product_name'];
              $TotalQuantity = $row['TotalQuantity'];
              $TotalProdSales = $row['TotalProdSales'];
              $top++;
              ?>
              <tr>
                <td><?php echo $top; ?></td>
                <td><?php echo $customer_product_code; ?></td>
                <td><?php echo $customer_product_name; ?></td>
                <td><?php echo $customer_product_des; ?></td>
                <td><?php echo $TotalQuantity; ?></td>
                <td><?php echo  '₱ '.number_format($TotalProdSales, 2); ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>

    <div class="col-md-6">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Top 5 Salesman of 2017</h3>
        </div>
        <div class="panel-body">
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
              FROM {$prefix}sws
              GROUP BY sws_salesman
              ORDER BY SUM(sws_unitprice * sws_quantity) DESC
              LIMIT 10";
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

      </div>

      <div class="col-md-12">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">Top 5 Salesman (Interbranch) of 2017</h3>
          </div>
          <div class="panel-body">
            <table class="table table-hover table-condensed table-bordered table-striped" id="tae">
              <thead>
                <tr>
                  <th>Top #</th>
                  <th>Branch</th>
                  <th>Employee No.</th>
                  <th>Salesman Name</th>
                  <th>Total Sales</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $top = 0;
                $top5salesmanInt = "SELECT sws_salesman, sws_smname, sws_branch,
                                    SUM(sws_unitprice * sws_quantity) AS TotalSales
                                    FROM ((SELECT sws_salesman, sws_smname, sws_unitprice, sws_quantity, sws_branch
                                    FROM bs_sws
                                    ) UNION ALL
                                    (SELECT sws_salesman, sws_smname, sws_unitprice, sws_quantity, sws_branch
                                    FROM fv_sws
                                    ) UNION ALL
                                    (SELECT sws_salesman, sws_smname, sws_unitprice, sws_quantity, sws_branch
                                    FROM td_sws
                                    )
                                    ) abc
                                    GROUP BY sws_salesman
                                    ORDER BY TotalSales DESC
                                    LIMIT 5;";

                $top5salesmanIntE = mysqli_query($connection, $top5salesmanInt);

                while ($row = mysqli_fetch_array($top5salesmanIntE)) {
                  $sws_salesman = $row['sws_salesman'];
                  $sws_smname = $row['sws_smname'];
                  $TotalSales = $row['TotalSales'];
                  $sws_branch = $row['sws_branch'];
                  $top++;
                  ?>
                  <tr>
                    <td><?php echo $top; ?></td>
                    <td><?php echo $sws_branch; ?></td>
                    <td><?php echo sprintf('%08d', $sws_salesman); ?></td>
                    <td><?php echo $sws_smname; ?></td>
                    <td><?php echo '₱ '. number_format($TotalSales, 2); ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>

        </div>


        <?php 

        $selectSales = "SELECT * FROM {$prefix}settings";
        $selectSalesE = mysqli_query($connection, $selectSales);
        while ($row = mysqli_fetch_array($selectSalesE)) {
          $target_sales = $row['target_sales'];
        }
        ?>


        <form action="index.php" method="post">
          <div class="col-md-12">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h3 class="panel-title">Forecast (2016)</h3>
              </div>
              <div class="panel-body">
                <div class="col-md-4">
                  <div class="form-group">
                    <input type="number" name="target_sales" placeholder="Target Sales %" class="form-control" min="1" max="100">
                  </div>
                </div>
                <div class="form-group">
                  <input type="submit" name="submitSales" value="Set Target %" class="btn btn-info">
                </div>
                <br>
                <table class="table table-condensed table-hover" id="example">
                  <thead>
                    <tr>
                      <th>Product Name</th>
                      <th>Product Description</th>
                      <th>Total Sales</th>
                      <th>Suggested Sales (<?php echo $target_sales; ?>%)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $selectYear = "SELECT {$prefix}sws.*, {$prefix}customer.*, 
                                  SUM(customer_product_price * customer_product_qty) AS TotalSales
                                  FROM {$prefix}customer INNER JOIN {$prefix}sws ON {$prefix}customer.customer_sws_id = {$prefix}sws.sws_number WHERE date LIKE '%2017%'
                                    GROUP BY customer_product_code
                                    ORDER BY SUM(customer_product_price * customer_product_qty) DESC
                                  LIMIT 10";
                    $selectYearE = mysqli_query($connection, $selectYear);

                    while ($row = mysqli_fetch_array($selectYearE)) { 
                      $customer_product_des = $row['customer_product_des'];
                      $customer_product_name = $row['customer_product_name'];
                      $totalSalesF = $row['TotalSales'];
                      ?>
                      <tr>
                        <td><?php echo $customer_product_name; ?></td>
                        <td><?php echo $customer_product_des; ?></td>
                        <td><?php echo '₱ '. number_format($totalSalesF,2); ?></td>
                        <td><?php echo '₱ '. number_format($totalSalesF * (1+($target_sales/100)),2); ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </form>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->

      <!-- /#page-wrapper -->

      <?php include 'includes/admin_footer.php'; ?>
