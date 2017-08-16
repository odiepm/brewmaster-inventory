<?php include 'includes/admin_header.php' ?>
<div class="col-md-12">
    <div class="well well-sm">
                <ol class="breadcrumb" style="margin-bottom: -3px;">
                  <li class="active"><a href="pending_order.php">Pending Orders</a> <span class="badge"><?php echo $count_pc; ?></span></li>
                  <li class="active"><a href="outfordel_order.php">Out for Delivery</a> <span class="badge" style="background-color:#f89406"><?php echo $count_od; ?></span></li>
                  <li><strong>Return</strong> <span class="badge" style="background-color: #b94a48"><?php echo $count_od; ?></span></a></li>
                  <li class="active"><a href="completed_orders.php">Completed Orders <span class="badge" style="background-color: #468847"><?php echo $count_cp; ?></span></a></li>
                  <li class="active"><a href="canceled_orders.php">Canceled Orders</a> <span class="badge" style="background-color: #333333"><?php echo $cancelCount; ?></span></a></li>
                </ol>
</div>
  <div class="panel panel-default">
     <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Pending Orders</span>
       </strong>
     </div>
        <div class="panel-body">
          <div class="form-group">
              <table class="table table-bordered table-striped table-hover results table-condensed" id="example">
                <thead>
                <tr>

                    <th class="text-center" style="width: 70px;">#</th>
                    <th class="text-center">Order Number</th>
                    <th class="text-center">Salesman</th>
                    <th class="text-center">Date of Order</th>
                    <th class="text-center">Submission Status</th>
                    <th class="text-center" style="width: 270px;">Action</th>
                </tr>
                
              </thead>
              <tbody>
              <?php 

                $orderQuery = "SELECT * FROM {$prefix}orders WHERE status = 'Out for Delivery'";
                $execOrder = mysqli_query($connection, $orderQuery);

                $tableCount = 0;
                while ($row = mysqli_fetch_array($execOrder)) {
                    $order_id = $row['order_id'];
                    $order_num = $row['order_num'];
                    $salesman = $row['salesman_name'];
                    $status = $row['status'];
                    $date = $row['date'];
                    $tableCount++;
                ?>
              <tr>
                <td class="text-center"><?php echo $tableCount; ?></td>
                <td class="text-center"><?php echo sprintf('%08d',$order_num); ?></td>
                <td class="text-center"><?php echo ucwords($salesman); ?></td>
                <td class="text-center"><?php echo $date; ?></td>
                <td class="text-center"><?php echo $status; ?></td>
                <td class="text-center">
                  <a href='return_sales.php?cid=<?php echo $order_num; ?>' class='btn btn-xs btn-success bbValid' title='Complete Order' >Complete Order </a>
                  <a href='manage_return.php?id=<?php echo $order_num; ?>' class='btn btn-xs btn-danger' title='Manage Return' >Manage Return </a>
                  <a href='invoice3.php?id=<?php echo $order_num; ?>' class='btn btn-xs btn-info' title='View Details' >Details </a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php 
          //Confirm Order
          if (isset($_GET['cid'])) {
          $confirmID = $_GET['cid'];        

          $selectEmp = "SELECT * FROM {$prefix}sws WHERE sws_number = $confirmID;";
          $selectEmpE = mysqli_query($connection, $selectEmp);

          while ($row = mysqli_fetch_array($selectEmpE)) {
            $sws_productid = $row['sws_productid'];
            $sws_quantity = $row['sws_quantity'];

            $insertEmp = "UPDATE {$prefix}products SET empties = empties + $sws_quantity WHERE product_id = $sws_productid;";
            $insertEmpE = mysqli_query($connection, $insertEmp);
          }

          $selectEmpE = mysqli_query($connection, $selectEmp);

          $sqlConfirm = "UPDATE {$prefix}orders SET status = 'Completed' WHERE order_num = $confirmID;";
          $exec = mysqli_query($connection, $sqlConfirm);
          header('Refresh:0; return_sales.php');
          }          


           ?>

       </div>
    </div>
    </div>
    
  

<?php include 'includes/admin_footer.php' ?>  