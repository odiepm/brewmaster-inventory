<?php include 'includes/admin_header.php'; ?>
<?php 

//############################### SET VAT % ############################################################
if(isset($_POST['vatSubmit'])){

  $vat_percent = $_POST['vat_percent'];

  $setVatSQL = "UPDATE {$prefix}settings SET vat_percent = $vat_percent;";
  $sqlQuery2 = mysqli_query($connection, $setVatSQL);

}


//##################### START OF MarkUP ****************************
//SET SELL PRICE %
if(isset($_POST['markUpSubmit'])){

  $markup_percent = $_POST['markup_percent'];

  $setSellSQL = "UPDATE {$prefix}settings SET markup_percentage = $markup_percent";
  $sqlQuery = mysqli_query($connection, $setSellSQL);


  if (isset($_POST['markUpCheck'])) { #TODO CHECKBOX
    
    $markUpCheck = $_POST['markUpCheck'];

    $setCheck = "UPDATE {$prefix}settings SET markUpIsCheck = 1";
    $setCheckE = mysqli_query($connection, $setCheck);

    $getMarkup = "SELECT markup_percentage, vat_percent FROM {$prefix}settings;";
    $getMarkupE = mysqli_query($connection, $getMarkup);

    while ($row = mysqli_fetch_array($getMarkupE)) {
      $getMark = $row['markup_percentage'];
      $getVat = $row['vat_percent'];
    }

    $updateAllProductsMU = "UPDATE {$prefix}products SET markup_percent = $getMark";
    $updateAllProductsMUE = mysqli_query($connection, $updateAllProductsMU);


    $updateAllProducts = "UPDATE {$prefix}products
                  SET sell_price = (supplier_price * (1 + ($getVat/100))) 
                  + ((supplier_price * (1 + ($getVat/100))) * ($getMark/100))";
    $updateAllProductsE = mysqli_query($connection, $updateAllProducts);

  } else {

    $setCheck = "UPDATE {$prefix}settings SET markUpIsCheck = 0";
    $setCheckE = mysqli_query($connection, $setCheck);
  }


}

//CHECK PERCENTAGE IF CHECKED
$checkChecked = "SELECT markUpIsCheck FROM {$prefix}settings";
$checkCheckedE = mysqli_query($connection, $checkChecked);

while ($row = mysqli_fetch_array($checkCheckedE)) {
  $checked = $row ['markUpIsCheck'];
}

$selectSettings = "SELECT * FROM {$prefix}settings;";
$execSelect = mysqli_query($connection, $selectSettings);

while ($row = mysqli_fetch_array($execSelect)) {
  $vat_percent = $row['vat_percent'];
  $markup_percentage = $row['markup_percentage'];
}

?>


<form action="" method="post" class="form-inline">

  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Manage Markup</span>
          </strong>
        </div>

        <div class="panel-body">
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <label for="">Current Markup %</label>
                  <input type="text" class="form-control" value="<?php echo $markup_percentage . '%';?>" readonly>
                </div>
              </div>
            </div>
          </div> 

          <div class="checkbox">
            <label>
              <?php if ($checked == 1) { ?>
                <input type="checkbox" name="markUpCheck" checked="checked" value="1">
              <?php  } else { ?>
                <input type="checkbox" name="markUpCheck">
              <?php } ?>

              Enable Gerneral Setting <p class="text-muted">* Disables Input of Markup Percentage on <strong>Add Products</strong><br>* Set <strong>All Products'</strong> Price based on the Mark-Up Percentage </p>
            </label>
          </div>

          <hr>
          <div class="col-xs-4">
            <label>Set Mark-Up %</label>
            <input type="number" class="form-control" name="markup_percent" min="1" max="100" style="width: 180px;" >
          </div>

          <input type="submit" name="markUpSubmit" class="btn btn-success" value="Set Mark-Up Percentage">

      </div>


    </div>
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Manage VAT</span>
          </strong>
        </div>

        <div class="panel-body">
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <label for="">Current VAT %</label>
                  <input type="text" class="form-control" value="<?php echo $vat_percent . '%';?>" readonly>
                </div>
              </div>
            </div>
          </div> 

          <hr>


          <div class="col-xs-4">
            <label>Set VAT%</label>
            <input type="number" class="form-control" name="vat_percent" min="1" max="100" style="width: 180px;" >
          </div>

          <input type="submit" name="vatSubmit" class="btn btn-success" value="Set TAX Percentage">

        </form>

      </div>


    </div>


  </div>
</div>


<?php include 'includes/admin_footer.php'; ?>