<?php include 'includes/salesman_header.php'; ?>



<div class="row">
  <div class="col-md-12">
    <div class="well well-sm">
      <ol class="breadcrumb" style="margin-bottom: -3px;">
        <li><strong>Select Driver</strong></li>
        <li class="active">Add Products to Cart</li>
        <li class="active">Delivery Info</li>
        <li class="active">Confirm Order</li>
        <li class="active">Success</li>

      </ol>
    </div>
    <div class="panel panel-default">	
      <div class="panel-body">
       <div class="col-md-12">

        <div class="form-group">
         <form action="add_sales.php" method="post">
           <br>
           <label for="salesman">List of Vehicles</label>
           <select name="selectVehicle" class="form-control" required>
            <option value="">Select Plate No.</option>
            <?php 
            $select = "SELECT * FROM {$prefix}vehicles";
            $squery = mysqli_query($connection,$select);
            $count = 0;
            while($row = mysqli_fetch_array($squery)) {

              $vehicle_id            = $row['vehicle_id'];
              $vehicle_firstname = $row['vehicle_firstname'];
              $vehicle_lastname  = $row['vehicle_lastname'];
              $vehicle_plateno  = $row['vehicle_plateno'];
              $count++;
              ?>
              <option value='<?php echo $vehicle_id ?>'><?php echo $vehicle_plateno; ?></option>";
              <?php } ?>

            </select>
            
            <br>
            <input type="submit" class="btn btn-success pull-right" name="setcart" value="Proceed">
          </form>
        </div> 
      </div>
    </div>


  </div>
</div>
</div>
<?php if ($count <= 0) { ?>
<script>
  bootbox.alert('Create a <a href="add_user.php"><strong>Salesman</strong></a> first!', function(){
    window.location = "users.php";
  });
</script>
<?php } ?>
<?php include 'includes/salesman_footer.php'; ?>