<?php include 'includes/admin_header.php' ?>
<div class="col-md-12">
  <div class="well well-sm">
    <ol class="breadcrumb" style="margin-bottom: -3px;">
      <li class="active"><a href="pending_order.php">Pending Orders</a> <span class="badge"><?php echo $count_pc; ?></span></li>
      <li class="active"><a href="outfordel_order.php">Out for Delivery</a> <span class="badge" style="background-color:#f89406"><?php echo $count_od; ?></span></li>
      <li><strong>Completed Orders</strong> <span class="badge" style="background-color: #468847"><?php echo $count_cp; ?></span></a></li>
      <li class="active"><a href="canceled_orders.php">Canceled Orders</a> <span class="badge" style="background-color: #333333"><?php echo $cancelCount; ?></span></a></li>
    </ol>
  </div>
  
  <div class="panel panel-default">
   <div class="panel-heading">
    <strong>
      <span class="glyphicon glyphicon-th"></span>
      <span>Completed Orders</span>
    </strong>
  </div>
  <div class="panel-body">
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
      $result = substr('Coke', 0, 3) .sprintf('%04d',4);

      $orderQuery = "SELECT * FROM {$prefix}orders WHERE status = 'Completed'";
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
          <td class="text-center"><?php echo $order_id; ?></td>
          <td class="text-center"><?php echo sprintf('%08d',$order_num); ?></td>
          <td class="text-center"><?php echo ucwords($salesman); ?></td>
          <td class="text-center"><?php echo $date; ?></td>
          <td class="text-center"><?php echo $status; ?></td>
          <td class="text-center">
            <a href='invoice3.php?id=<?php echo $order_num; ?>' class='btn btn-xs btn-info' title='View Details' >Invoice </a>
            <a href='or_list.php?sws_id=<?php echo $order_num; ?>' class='btn btn-xs btn-success' title='View Details' >OR List</a>
            <a href='return_list.php?id=<?php echo $order_num; ?>' class='btn btn-xs btn-danger' title='View Details' >Return Details</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>


  </div>
</div>
</div>



<?php include 'includes/admin_footer.php' ?>  