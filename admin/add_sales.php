<?php include 'includes/admin_header.php'; ?>

<?php 

//Assign Salesman Session from select_salesman.php
if (isset($_POST['setcart'])) {
  $_SESSION['salesman'] = $_POST['selectSalesman'];
  $_SESSION['vehicleNo'] = $_POST['selectVehicle'];
}

?>

<?php
//ADD TO CART FOR PRODUCTS
if (isset($_POST['addCart']) && $_POST['addCart']=="Add Items to Cart") {

 foreach($_POST['qtyBuy'] as $index=>$value){
   if ($value > 0) {

    $cartProd_id = $_POST['product_id'][$index];
    $cartProd_code = $_POST['product_code'][$index];
    $cartProd_name = $_POST['product_name'][$index];
    $cartProd_desc = $_POST['description'][$index];
    $cartProd_sellprice = $_POST['product_price'][$index];
    $cartProd_expdate = $_POST['expiry_date'][$index];
    $cartProdempty = $_POST['isEmpty'][$index];
    $cartProdcat = $_POST['cartCatID'][$index];
    $cartUnitper = $_POST['unit_per'][$index];
    
    $addQuery = "INSERT INTO {$prefix}cart 
    (product_id, cartProdcode, cartProdname, cartProdesc, cartProdsell, cartProdexp, quantityCart, cartProdcat, cartProdempty, cartUnitper) 
    VALUES ($cartProd_id, '$cartProd_code', '$cartProd_name', '$cartProd_desc', $cartProd_sellprice, '$cartProd_expdate', $value, $cartProdcat, $cartProdempty, $cartUnitper)
    ON DUPLICATE KEY UPDATE quantityCart = quantityCart + $value;";
    $addQuery2 = "UPDATE {$prefix}products SET quantity = quantity - $value WHERE product_id = $cartProd_id;";

    $execQuery  = mysqli_query($connection, $addQuery);
    $execQuery2 = mysqli_query($connection, $addQuery2);
  }  
}

}

?>

<?php 

if(isset($_SESSION['salesman']))
	
{

  ?>

  <div class="row">
    <div class="col-md-12"> <!-- Product List Info Start -->
      <div class="well well-sm">
        <ol class="breadcrumb" style="margin-bottom: -3px;">
          <li class="active">Select Salesman</li>
          <li><strong>Add Products to Cart</strong></li>
          <li class="active">Delivery Info</li>
          <li class="active">Confirm Order</li>
          <li class="active">Success</li>
        </ol>
      </div>

      <div class="panel panel-success">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Select Products</span>
          </strong>
        </div>



        <!-- Product Table Start -->
        <div class="panel-body">

          <form action="add_sales.php" method="POST">
            <table class="table table-striped table-bordered table-hover table-fixed table-condensed" id="example">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th>Product Code</th>
                  <th>Product Name</th>
                  <th>Description</th>
                  <th width="20px">Units per Case/Box</th>
                  <th>Price</th>
                  <th>Expiry Date</th>
                  <th>In Stock</th>
                  <th>Quantity</th>
                </tr>
              </thead>


              <tbody>
                <?php 
                $query = "SELECT * FROM {$prefix}products WHERE quantity > 0;";
                $exec = mysqli_query($connection, $query);
                $a = 1;
                $b = 1;
                $count = 0;
                while ($row = mysqli_fetch_array($exec)) {
                  $product_id = $row['product_id'];
                  $product_code = $row['product_code'];
                  $product_name = $row['product_name'];
                  $product_price = $row['sell_price'];
                  $description = $row['description'];
                  $product_quantity = $row['quantity'];
                  $category_id = $row['category_id'];
                  $expiry_date = $row['expiry_date'];
                  $isEmpty = $row['isEmpty'];
                  $unit_per = $row['unit_per'];
                  $count++;

                  ?>


                  <tr>
                    <td class="text-center"><?php echo $product_id; ?>
                      <input type="hidden" name="product_id[]" value="<?php echo $product_id; ?>">
                    </td>
                    <td>
                      <?php echo $product_code; ?>
                      <input type="hidden" name="product_code[]" value="<?php echo $product_code; ?>">
                    </td>
                    <input type="hidden" name="cartCatID[]" value="<?php echo $category_id; ?>">
                    <input type="hidden" name="isEmpty[]" value="<?php echo $isEmpty; ?>">
                    <td><?php echo $product_name; ?></td>
                    <input type="hidden" name="product_name[]" value="<?php echo $product_name; ?>">

                    <td><?php echo $description; ?></td>
                    <input type="hidden" name="description[]" value="<?php echo $description; ?>">

                    <td><?php echo $unit_per; ?></td>
                    <input type="hidden" name="unit_per[]" value="<?php echo $unit_per; ?>">
                    
                    <td>₱ <?php echo number_format($product_price, 2); ?></td>
                    <input type="hidden" name="product_price[]" value="<?php echo $product_price; ?>">

                    <td><?php echo $expiry_date; ?></td>
                    <input type="hidden" name="expiry_date[]" value="<?php echo $expiry_date; ?>">

                    <td><input type="number" value="<?php echo $product_quantity; ?>" id="<?php echo "qtyResult" . $a++; ?>" disabled></td>
                    <td><input type="number" name="qtyBuy[]" id="<?php echo "qtyBuy" . $b++; ?>" onkeyup="updateStock(this, event)" min="1" max="<?php echo $product_quantity; ?>"></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>

              <?php if ($count <= 0) { ?>
              <div class="form-group">
                <button class="btn btn-info pull-right" disabled>Add Items to Cart</button>
              </div>
              <?php } elseif ($count > 0) { ?>
              <div class="form-group">
                <input type="submit" name="addCart" value="Add Items to Cart" class="btn btn-info pull-right">
              </div>
              <?php } ?>
            </div>
          </form>
        </div>
      </div>
    </div> <!-- End of Product List -->





    <hr>
    <!-- Start of Salesman's Cart -->
    <div class="panel panel-primary">
      <div class="panel-heading">
        <strong>
          <span class="fa fa-shopping-cart"></span>
          <span>Salesman's Cart</span>
        </strong>
      </div>
      <div class="panel-body">
        <a href="add_sales.php?removeall" class="btn btn-danger pull-right btn-xs bbValid"><i class="glyphicon glyphicon-repeat"></i> Remove All from Cart</a>
        <!-- START OF PRODUCT LIST -->
        <h4>Product List:</h4>
        <table class="table table-hover">
          <thead>
            <tr>
              <th class="text-center">Product ID</th>
              <th class="text-center">Product Name</th>
              <th class="text-center">Description</th>
              <th class="text-center">Unit per Case/Box</th>
              <th class="text-center">Quantity</th>
              <th class="text-center">Price per Unit</th>
              <th class="text-center">Total Amount</th>
              <th class="text-center">Remove</th>
            </tr>
          </thead>
          <tbody>


            <?php 

            $selectCart = "SELECT * FROM {$prefix}cart INNER JOIN {$prefix}products ON {$prefix}products.product_id = {$prefix}cart.product_id";
            $execSelectCart = mysqli_query($connection, $selectCart);

            $cartCount = 0;

            while ($row = mysqli_fetch_array($execSelectCart)) {

              $cartProId = $row['product_id'];
              $unit_per = $row['unit_per'];
              $cartProName = $row['product_name'];
              $cartProDesc = $row['description'];
              $cartSellPrice = $row['sell_price'];
              $cartQty = $row['quantityCart'];

              $compute = $cartSellPrice * $cartQty;
              $totalAmount = number_format((float)$compute, 2, '.', '');
              $cartCount++;
              ?>

              <tr>
                <td class="text-center"><?php echo $cartProId; ?></td>
                <td class="text-center"><?php echo $cartProName; ?></td>
                <td class="text-center"><?php echo $cartProDesc; ?></td>
                <td class="text-center"><?php echo $unit_per; ?></td>
                <td class="text-center"><?php echo $cartQty; ?></td>
                <td class="text-center">₱ <?php echo number_format($cartSellPrice,2); ?></td>
                <td class="text-center">₱ <?php echo $totalAmount ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="add_sales.php?remove=<?php echo $cartProId; ?>" class="btn btn-xs btn-danger bbValid">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>

                  </div>
                </td>
              </tr>

              <?php } ?>
            </tbody>
          </table>
          <hr>
          <div class="form-group">
            <a href="checkout.php" class="btn btn-success pull-right"><i class="glyphicon glyphicon-check"></i> Proceed</a>
            <a href="select_salesman.php" class="btn btn-info pull-left"><i class="glyphicon glyphicon-arrow-left"></i> Change Salesman</a>
          </div>
        </div>

      </div>

      <!-- End of Customer Cart -->


      <?php 
    }
//REMOVE PRODUCT FROM SHOPPING CART
    if (isset($_GET['remove'])) {
      $removeID = $_GET['remove'];

      if (isset($cartQty)) {
        $updateQuery = "SELECT * FROM {$prefix}cart WHERE product_id = $removeID;";
        $execSelectCart1 = mysqli_query($connection, $updateQuery);

        while ($row = mysqli_fetch_array($execSelectCart1)) {
          $qCart = $row['quantityCart'];
        }
        if (isset($qCart)) {

          $updateQuery .= "UPDATE {$prefix}products SET quantity = quantity + $qCart WHERE product_id = $removeID;";  
          $updateQuery .= "DELETE FROM {$prefix}cart WHERE product_id = $removeID;";   
          mysqli_multi_query($connection, $updateQuery);
          header("Refresh:0; add_sales.php");

        }
      }


    }


//remove all    
    if (isset($_GET['removeall'])) {


          //*********************TRUNCATE TABLE CART AND RETURN QTY TO TABLE PRODUCTS*****************************
      $getCart = "SELECT * FROM {$prefix}cart;";
      $getCartE = mysqli_query($connection, $getCart);

      while ($row = mysqli_fetch_array($getCartE)) {
        $cartProID = $row['product_id'];
        $quantityCart = $row['quantityCart'];

        $updateQuery = "UPDATE {$prefix}products SET quantity = quantity + $quantityCart WHERE product_id = $cartProID;";
        mysqli_query($connection, $updateQuery);
      }

      $deleteCart = "TRUNCATE TABLE {$prefix}cart;";
      mysqli_query($connection, $deleteCart);

      $deleteCart1 = "TRUNCATE TABLE {$prefix}case_cart;";
      mysqli_query($connection, $deleteCart1);

      header("Refresh: 0; url=add_sales.php");
    }


    ?>






    <?php include 'includes/admin_footer.php'; ?>