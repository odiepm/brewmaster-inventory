<?php include 'includes/admin_header.php' ?>
<div class="col-md-12">
    <div class="well well-sm">
                <ol class="breadcrumb" style="margin-bottom: -3px;">
                  <li class="active"><a href="pending_order.php">Pending Orders</a> <span class="badge"><?php echo $count_pc; ?></span></li>
                  <li><strong>Manage Orders </strong><span class="badge" style="background-color:#f89406"><?php echo $count_od; ?></span></li>
                  <li class="active"><a href="completed_orders.php">Completed Orders <span class="badge" style="background-color: #468847"><?php echo $count_cp; ?></span></a></li>
                  <li class="active"><a href="canceled_orders.php">Canceled Orders</a> <span class="badge" style="background-color: #333333"><?php echo $cancelCount; ?></span></a></li>
                </ol>
</div>
  <div class="panel panel-default">
     <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Out for Delivery Orders</span>
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
                    $salesman_id = $row['Salesman'];
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
                  <a href='manage_orders_select.php?cid=<?php echo $order_num; ?>&sid=<?php echo $salesman_id; ?>' class='btn btn-xs btn-primary' title='Complete Order'>Distribution</a>
                  <a href='manage_complete.php?cid=<?php echo $order_num; ?>' class='btn btn-xs btn-success' title='View Details' >Manage Order </a>
                  <a href='invoice3.php?id=<?php echo $order_num; ?>' class='btn btn-xs btn-warning' title='View Details' >Invoice </a>
                  <a href='or_list.php?sws_id=<?php echo $order_num; ?>' class='btn btn-xs btn-info' title='View Details' >O.R</a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
       </div>
    </div>
    </div>
    
	

<?php include 'includes/admin_footer.php' ?>	