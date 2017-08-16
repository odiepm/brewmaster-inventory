<?php include 'includes/admin_header.php'; ?>
<?php 

if (isset($_GET['user'])) {
  $user = $_GET['user'];

  if ($user == 1) {
    $userUpdate = "UPDATE users SET isUserManagement = 1 WHERE user_role = 'Salesman'";
    $userUpdateE = mysqli_query($connection, $userUpdate);
    header('Location:manage_modules.php');
  } elseif ($user == 0) {
    $userUpdate = "UPDATE users SET isUserManagement = 0";
    $userUpdateE = mysqli_query($connection, $userUpdate);
    header('Location:manage_modules.php');
  }

}

if (isset($_GET['product'])) {
  $product = $_GET['product'];

  if ($product == 1) {
    $productUpdate = "UPDATE users SET isProductManagement = 1 WHERE user_role = 'Salesman'";
    $productUpdateE = mysqli_query($connection, $productUpdate);
    header('Location:manage_modules.php');
  } elseif ($product == 0) {
    $productUpdate = "UPDATE users SET isProductManagement = 0 WHERE user_role = 'Salesman'";
    $productUpdateE = mysqli_query($connection, $productUpdate);
    header('Location:manage_modules.php');
  }
}

if (isset($_GET['stock'])) {
  $stock = $_GET['stock'];

  if ($stock == 1) {
    $stock = "UPDATE users SET isStockManagement = 1 WHERE user_role = 'Salesman'";
    $stockE = mysqli_query($connection, $stock);
    header('Location:manage_modules.php');
  } elseif ($stock == 0) {
    $stock = "UPDATE users SET isStockManagement = 0 WHERE user_role = 'Salesman'";
    $stockE = mysqli_query($connection, $stock);
    header('Location:manage_modules.php');
  }
} 

if (isset($_GET['sales'])) {
  $sales = $_GET['sales'];

  if ($sales == 1) {
    $salesMUpdate = "UPDATE users SET isSalesManagement = 1 WHERE user_role = 'Salesman'";
    $salesMUpdateE = mysqli_query($connection, $salesMUpdate);
    header('Location:manage_modules.php');
  } elseif ($sales == 0) {
    $salesMUpdate = "UPDATE users SET isSalesManagement = 0 WHERE user_role = 'Salesman'";
    $salesMUpdateE = mysqli_query($connection, $salesMUpdate);
    header('Location:manage_modules.php');
  }
}


if (isset($_GET['salesman'])) {
  $salesman = $_GET['salesman'];

  if ($salesman == 1) {
    $salesmanUpdate = "UPDATE users SET isSalesmanWithdrawal = 1 WHERE user_role = 'Salesman'";
    $salesmanUpdateE = mysqli_query($connection, $salesmanUpdate);
    header('Location:manage_modules.php');
  } elseif ($salesman == 0) {
    $salesmanUpdate = "UPDATE users SET isSalesmanWithdrawal = 0 WHERE user_role = 'Salesman'";
    $salesmanUpdateE = mysqli_query($connection, $salesmanUpdate);
    header('Location:manage_modules.php');
  }
}

if (isset($_GET['order'])) {
  $order = $_GET['order'];

  if ($order == 1) {
    $orderUpdate = "UPDATE users SET isOrderManagement = 1 WHERE user_role = 'Salesman'";
    $orderUpdateE = mysqli_query($connection, $orderUpdate);
    header('Location:manage_modules.php');
  } elseif ($order == 0) {
    $orderUpdate = "UPDATE users SET isOrderManagement = 0 WHERE user_role = 'Salesman'";
    $orderUpdateE = mysqli_query($connection, $orderUpdate);
    header('Location:manage_modules.php');
  }
}

if (isset($_GET['reports'])) {
  $reports = $_GET['reports'];

  if ($reports == 1) {
    $reportUpdate = "UPDATE users SET isReports = 1 WHERE user_role = 'Salesman'";
    $reportUpdateE = mysqli_query($connection, $reportUpdate);
    header('Location:manage_modules.php');
  } elseif ($reports == 0) {
    $reportUpdate = "UPDATE users SET isReports = 0 WHERE user_role = 'Salesman'";
    $reportUpdateE = mysqli_query($connection, $reportUpdate);
    header('Location:manage_modules.php');
  }
}

if (isset($_GET['settings'])) {
  $settings = $_GET['settings'];

  if ($settings == 1) {
    $settingsUpdate = "UPDATE users SET isSettings = 1 WHERE user_role = 'Salesman'";
    $settingsUpdateE = mysqli_query($connection, $settingsUpdate);
    header('Location:manage_modules.php');
  } elseif ($settings == 0) {
    $settingsUpdate = "UPDATE users SET isSettings = 0 WHERE user_role = 'Salesman'";
    $settingsUpdateE = mysqli_query($connection, $settingsUpdate);
    header('Location:manage_modules.php');
  }
}

?>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Module List</span>
        </strong>
      </div>

      <div class="panel-body">

        <?php 

        $selectModule = "SELECT * FROM users";
        $selectModuleE = mysqli_query($connection, $selectModule);

        while ($row = mysqli_fetch_array($selectModuleE)) {
          $isUserManagement = $row['isUserManagement'];
          $isProductManagement = $row['isProductManagement'];
          $isStockManagement = $row['isStockManagement'];
          $isSalesmanWithdrawal = $row['isSalesmanWithdrawal'];
          $isOrderManagement = $row['isOrderManagement'];
          $isReports = $row['isReports'];
          $isSettings = $row['isSettings'];
        }

        ?>

        <h3>Salesman:</h3>
        <table class="table table-bordered table-striped table-hover table-condensed results">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Module</th>
              <th class="text-center">Enable/Disable</th>
            </tr>
          </thead>
          <tbody>

            <tr>
              <td>1</td>
              <td>Product Management</td>
              <td class="text-center">
               <div class="btn-group">
                 <?php 
                 if ($isProductManagement == 0) {
                  ?>
                  <a href="manage_modules.php?product=1" class="btn btn-xs btn-success" data-toggle="tooltip" title="Edit">
                    <i class="glyphicon glyphicon-check"></i>
                  </a>
                  <?php } elseif ($isProductManagement == 1) { ?>
                  <a href="manage_modules.php?product=0" class="btn btn-xs btn-danger bbValid" data-toggle="tooltip" title="Remove">
                    <i class="glyphicon glyphicon-remove"></i>
                  </a>
                  <?php } ?>
                </div>
              </td>
            </tr>

          <tr>
            <td>2</td>
            <td>Salesman Withdrawal</td>
            <td class="text-center">
             <div class="btn-group">
               <?php 
               if ($isSalesmanWithdrawal == 0) {
                ?>
                <a href="manage_modules.php?salesman=1" class="btn btn-xs btn-success" data-toggle="tooltip" title="Edit">
                  <i class="glyphicon glyphicon-check"></i>
                </a>
                <?php } elseif ($isSalesmanWithdrawal == 1) { ?>
                <a href="manage_modules.php?salesman=0" class="btn btn-xs btn-danger bbValid" data-toggle="tooltip" title="Remove">
                  <i class="glyphicon glyphicon-remove"></i>
                </a>
                <?php } ?>
              </div>
            </td>
          </tr>

          <tr>
            <td>3</td>
            <td>Reports</td>
            <td class="text-center">
             <div class="btn-group">
               <?php if ($isReports == 0) { ?>
               <a href="manage_modules.php?reports=1" class="btn btn-xs btn-success" data-toggle="tooltip" title="Edit">
                <i class="glyphicon glyphicon-check"></i>
              </a>
              <?php } elseif ($isReports == 1) { ?>
              <a href="manage_modules.php?reports=0" class="btn btn-xs btn-danger bbValid" data-toggle="tooltip" title="Remove">
                <i class="glyphicon glyphicon-remove"></i>
              </a>
              <?php } ?>
            </div>
          </td>
        </tr>

      </tbody>
    </table>




  </div>
</div>
</div>
</div>


<?php include 'includes/admin_footer.php'; ?>