<?php include 'includes/admin_header.php'; ?>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
    <div class="panel-heading clearfix">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Purchase Order</span>
     </strong>
    </div>
     <div class="panel-body">

     		<div class="col-md-4">
     			<label for="">Supplier</label>
				<select name="supplier" id="input" class="form-control" required="required">
                <option selected="true" disabled="disabled">Select Supplier</option>
                <?php 

                    $sql1 = "SELECT * FROM supplier";
                    $execSql = mysqli_query($connection, $sql1);

                    while ($row = mysqli_fetch_array($execSql)) {
                        $supplier_name = $row['supplier_name'];
                        $supplier_id = $row['supplier_id'];
                    ?>
                    <option value="<?php echo $supplier_id; ?>"><?php echo $supplier_name; ?></option>
                    <?php } ?>
                </select>
     		</div>

		
     		<div class="col-md-3">
     			<label for="">Delivery Date</label>
				<input type="date" name="" value="" placeholder="" class="form-control">
     		</div>

     		<div class="col-md-3">
     			<label for="">PO-Number</label>
				<input type="text" name="" value="PO-00000001" placeholder="" class="form-control" readonly>
     		</div>

     	<div class="col-md-12">
     		<hr>

     		<div class="form-group">
		     	<div class="col-md-4">
		     		<label for="">Item</label>
						<input type="text" class="form-control">
		     	</div>
		     </div>	

		     <div class="form-group">
		     	<div class="col-md-3">
		     		<label for="">Description</label>
						<input type="text" name="" value="" placeholder="" class="form-control">
		     	</div>
		     	</div>
		     	
		     	<div class="form-group">
		     	<div class="col-md-3">
		     		<label for="">Amount</label>
						<input type="number" name="" value="" placeholder="" class="form-control">
		     	</div>
		     	</div>
     	     	
     	     	<div class="form-group">
		     		<div class="col-md-12">
     	     	<br>
     					<input type="submit" class="btn btn-info pull-right" value="Add Item">
     	     		</div>
     	     	</div>
     	</div>


     	<div class="col-md-12">
     	<br>
     		<table class="table table-hover">
     			<thead>
     				<tr>
	     				<th>Item</th>
	     				<th>Description</th>
	     				<th>Quantity</th>
	     				<th>Unit Price</th>
     				</tr>
     			</thead>
     		<tbody>
     			<tr>
     				<td></td>
     			</tr>
     		</tbody>
     		</table>
     	</div>


    </div>
   </div>
 </div>

</div>


<?php include 'includes/admin_footer.php'; ?>