<?php include 'includes/admin_header.php'; ?>

<?php 

if (isset($_GET['catID'])) {

  $cat_id = $_GET['catID'];

  $selectQuery = "SELECT * FROM categories WHERE category_id = $cat_id";
  $execQuery = mysqli_query($connection, $selectQuery);

  while ($row = mysqli_fetch_array($execQuery)) {

    $category_name = $row['category_name'];

  }

  
if (isset($_POST['update'])) {

  $category_name = $_POST['category_name'];
  
  $query = "UPDATE categories SET category_name = '$category_name' WHERE category_id = $cat_id";
  $execQuery = mysqli_query($connection,$query);

  if (!$execQuery) {

    die(mysqli_error($connection));

  } else {

    $queryLog = "INSERT INTO {$prefix}activity_log (description, date) VALUES ('$activityUsername edited the category: $category_name', '$activityDate');";
    $execLog = mysqli_query($connection, $queryLog);

    $msg ="<div class='alert alert-success'><strong>{$category_name}</strong> has been updated! <a href='category.php'>Back to Categories</a></div>";
    echo $msg;
  }



 }



?>

        <form method="post" action="">

          <div class="form-group">
              <label for="category_name">Category</label>
              <input type="text" class="form-control" name="category_name" value="<?php echo $category_name; ?>" required>
          </div>

          <div class="form-group"> 
          <a data-href="edit_category?update=<?php echo $catID; ?>" data-toggle="modal" data-target="#confirm-edit" class="btn btn-info">Update Category</a>
          <a href="category.php" class="btn btn-warning pull-right" >Back</a>

          <!-- MODAL FOR UPDATE -->
          <div class="modal fade" id="confirm-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                        <h3>Confirm Product</h3>
                      </div>
                      <div class="modal-body">
                        Are you sure you want to add this product?
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                          <input type="submit" name="update" value="Confirm" class="btn btn-info btn-ok"></a>
                      </div>
                  </div>
              </div>
          </div>


          </div>
      </form>

</div>
<?php } ?>
</form>
<?php include 'includes/admin_footer.php'; ?>
</div>

