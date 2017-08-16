<?php include 'includes/admin_header.php' ?>
<div class="col-md-12">
  <div class="well well-sm">
    <ol class="breadcrumb" style="margin-bottom: -3px;">
      <li><strong>Pending Orders</strong> <span class="badge"><?php echo $count_pc; ?></span></li>
      <li class="active"><a href="outfordel_order.php">Manage Orders </a><span class="badge" style="background-color:#f89406"><?php echo $count_od; ?></span></li>
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

          $orderQuery = "SELECT * FROM {$prefix}orders WHERE status = 'Pending'";
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
                <a href='pending_order.php?cid=<?php echo $order_num; ?>' class='btn btn-xs btn-success' title='View Details' > Out for Delivery </a>
                <a href='invoice3.php?id=<?php echo $order_num; ?>' class='btn btn-xs btn-info' title='View Details' >Details </a>
                <a href='pending_order.php?id=<?php echo $order_num; ?>' class='btn btn-xs btn-danger' title='View Details' >Cancel </a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>

        <?php 
          //Confirm Order
        if (isset($_GET['cid'])) {
          $confirmID = $_GET['cid'];        

          $sqlConfirm = "UPDATE {$prefix}orders SET status = 'Out for Delivery' WHERE order_num = $confirmID;";
          $exec = mysqli_query($connection, $sqlConfirm);
          header('Refresh:0; pending_order.php');
        }          

  //Cancel Order
        if (isset($_GET['id'])) {
          $orderID = $_GET['id'];
//***********************************INSERT STOCK FROM SWS TO PRODUCTS**********************************
          $sqlSelect = "SELECT * FROM {$prefix}sws WHERE sws_number = $orderID;";
          $sqlExec = mysqli_query($connection, $sqlSelect);

          while ($row = mysqli_fetch_array($sqlExec)) {
            $sws_proname  = $row['sws_proname'];
            $sws_proexp   = $row['sws_proexp'];
            $sws_prodesc  = $row['sws_prodesc'];
            $sws_category = $row['sws_category'];
          }

          $checkExist = "SELECT * FROM {$prefix}products WHERE product_name = '$sws_proname' AND description = '$sws_prodesc' AND expiry_date = '$sws_proexp';";
          $checkExistE = mysqli_query($connection, $checkExist);
          
          if (mysqli_num_rows($checkExistE) > 0) {

            $sqlSelect2 = "SELECT * FROM {$prefix}sws WHERE sws_number = $orderID;";
            $sqlSelect2E = mysqli_query($connection, $sqlSelect2);

            while ($row = mysqli_fetch_array($sqlSelect2E)) {
              $productID = $row['sws_productid'];
              $quantity = $row['sws_quantity'];
              $upName = $row['sws_proname'];
              $upDesc = $row['sws_prodesc'];
              $upExp = $row['sws_proexp'];

              $returnQuery = "UPDATE {$prefix}products SET quantity = quantity + $quantity 
              WHERE product_name = '$upName' AND description = '$upDesc' AND expiry_date = '$upExp';";
              $returnExec = mysqli_query($connection,$returnQuery);

            } 
          } else {
            $insert_branch_stock = 
            "INSERT INTO {$prefix}products 
            (product_branch, category_id, product_name, description, 
            isEmpty, vatable, sell_price, expiry_date, quantity, date)
            SELECT '$capitalPrefix', sws_category, sws_proname, sws_prodesc, sws_isEmpty, sws_vat, sws_unitprice, sws_proexp, sws_quantity, date FROM {$prefix}sws WHERE sws_number = $orderID;";
            $insert_branch_stockE = mysqli_query($connection, $insert_branch_stock);

          }
          $deleteSwsOrder = "UPDATE {$prefix}orders SET status = 'Canceled' WHERE order_num = $orderID; ";
          mysqli_query($connection, $deleteSwsOrder);
          header("Refresh:0; url=pending_order.php");
        }


        ?>

      </div>
    </div>
  </div>



  <?php include 'includes/admin_footer.php' ?>	