<?php include 'includes/admin_header.php'; ?>

<?php 

  $sql="select categories.category_id, categories.category_name, td_products.category_id, bs_products.category_id, fv_products.category_id
	from categories
   left JOIN bs_products on categories.category_id = bs_products.category_id
   left JOIN fv_products on categories.category_id = fv_products.category_id
   left JOIN td_products on categories.category_id = td_products.category_id;";
   $sqle= mysqli_query($connection, $sql);

   print_r($sqle);

   while ($row = mysqli_fetch_array($sqle)) {
   		$haha = $row['category_id'];
   }



 ?>