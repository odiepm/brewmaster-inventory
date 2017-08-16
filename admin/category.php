<?php include 'includes/admin_header.php'; ?>
<?php  

if (isset($_POST['addCat'])) {

  $category_name = $_POST['category_name'];

  $query = "INSERT INTO categories (category_name) VALUES ('$category_name')";
  $insertQuery = mysqli_query($connection, $query);

  if (!$insertQuery) {

    die(mysqli_error($connection));

  } else {

    $msg ="<div class='alert alert-success'><strong>{$category_name}</strong> has been added</div>";
    echo $msg;

    $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername added category: $category_name', '$activityDate');";
    $execLog = mysqli_query($connection, $queryLog);

    header("Location:category.php");

  }  
}

?>

<div class="row">
  <h1> Category <small class="text-muted">Manage Categories</small> </h1>
  <hr>

  <div class="col-md-5">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Add New Category</span>
        </strong>
      </div>

      <div class="panel-body">
        <form method="post" action="category.php">
          <div class="form-group">
            <input type="text" class="form-control" name="category_name" placeholder="Category Name" required>
          </div>
          <a data-toggle="modal" data-target="#confirm-add" class="btn btn-sm btn-primary pull-right">Add Category</a>

          <!-- MODAL FOR ADD -->
          <div class="modal fade" id="confirm-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h3>Confirm Category</h3>
                </div>
                <div class="modal-body">
                  Are you sure you want to add this category?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <input type="submit" name="addCat" value="Add Category" class="btn btn-info">
                </div>
              </div>
            </div>
          </div>


        </form>
      </div> 
    </div>
  </div>

  <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>All Categories</span>
        </strong>
      </div>

      <div class="panel-body">

        <table class="table table-bordered table-striped table-hover table-condensed results">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th>Categories</th>
              <th class="text-center" style="width: 100px;">Actions</th>
            </tr>
          </thead>
          <tbody>

            <?php 
            $tableCount = 0;
            $query = "SELECT * FROM categories;";
            $exec = mysqli_query($connection, $query);
            $count = mysqli_num_rows($exec);

            while ($row = mysqli_fetch_array($exec)) {
              $tableCount++;
              $catID = $row['category_id'];
              $catName = $row['category_name'];

              ?>
              <tr>
                <td class="text-center"><?php echo $tableCount; ?></td>
                <td><?php echo $catName; ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_category.php?catID=<?php echo $catID; ?>"  class="btn btn-xs btn-info" data-toggle="tooltip" title="Edit">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="category.php?delete=<?php echo $catID; ?>" class="btn btn-xs btn-danger bbValid" data-toggle="tooltip" title="Remove">
                      <i class="glyphicon glyphicon-remove"></i>
                    </a>

                  </div>
                </td>
              </tr>
              <?php } ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php  

  if (isset($_GET['delete'])) {

    $catID = $_GET['delete'];

    $catGet = "SELECT categories.category_id, categories.category_name, bs_products.category_id, bs_products.product_name FROM categories INNER JOIN bs_products on bs_products.category_id = $catID 

    UNION SELECT categories.category_id, categories.category_name, fv_products.category_id, fv_products.product_name FROM categories INNER JOIN fv_products on fv_products.category_id = $catID 

    UNION SELECT categories.category_id, categories.category_name, td_products.category_id, td_products.product_name FROM categories INNER JOIN td_products on td_products.category_id = $catID;";
    $catGetq = mysqli_query($connection, $catGet);

    if (mysqli_num_rows($catGetq) == 0) {

      while ($row = mysqli_fetch_array($catGetq)) {
        $catGetName = $row['category_name'];
      }

      $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername deleted category: $catGetName', '$activityDate');";
      $execLog = mysqli_query($connection, $queryLog);

      $deleteQuery = "DELETE FROM categories WHERE category_id = $catID;";
      $execDelete = mysqli_query($connection, $deleteQuery); 
      header("Location: category.php");
      
    }
    else {
      while ($row = mysqli_fetch_array($catGetq)) {
        $catGetName = $row['category_name'];
      }
    ?>
      <script>bootbox.alert("The category is used by a product!")</script>
    <?php  
    }
  }

  ?>


  <script>
  //disable enter key
  $('form').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
      e.preventDefault();
      return false;
    }
  });
</script>

<?php include 'includes/admin_footer.php'; ?>