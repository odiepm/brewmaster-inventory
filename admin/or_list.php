<?php include 'includes/admin_header.php'; ?>
<?php 
  
  if (isset($_GET['sws_id'])) {
      $sws_id = $_GET['sws_id'];
  }

 ?>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>OR List for Order Number: <?php echo sprintf('%08d', $sws_id); ?></span>
        </strong>
      </div>

      <div class="panel-body">

        <table class="table table-bordered table-striped table-hover table-condensed results" id="example">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Customer Name</th>
              <th class="text-center">Customer Address</th>
              <th class="text-center">Customer Contact</th>
              <th class="text-center">View OR</th>
            </tr>
          </thead>
          <tbody>
            <?php  

            $userQuery = "SELECT * FROM {$prefix}customer 
                          WHERE customer_sws_id = $sws_id GROUP BY customer_distribution_id;";
            $selectQuery = mysqli_query($connection,$userQuery);

            $tableCount = 0;
            while ($row = mysqli_fetch_array($selectQuery)) {
              $customer_name = $row['customer_name'];
              $customer_address = $row['customer_address'];
              $customer_contact = $row['customer_contact'];
              $customer_distribution_id = $row['customer_distribution_id'];

              $tableCount++;

              ?>
              <td class="text-center"><?php echo $tableCount; ?></td>
              <td><?php echo $customer_name; ?></td>
              <td><?php echo $customer_address; ?></td>
              <td><?php echo $customer_contact; ?></td>
              <td class="text-center>">
              <a href='or_print.php?id=<?php echo $customer_distribution_id; ?>' class='btn btn-xs btn-primary' title='View Details' >View OR</a>
              </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>

      <a class="btn btn-default" href="javascript:history.back()">Back to Manage Orders</a>
      
    </div>
  </div>
</div>
</div>


<?php include 'includes/admin_footer.php'; ?>