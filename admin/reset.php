<?php include 'includes/admin_header.php' ?>
<?php 
	$reset = "TRUNCATE `activity_log`;
				TRUNCATE `brands`;
				TRUNCATE `cart`;
				TRUNCATE `categories`;
				TRUNCATE `orders`;
				TRUNCATE `products`;
				TRUNCATE `reports`;
				TRUNCATE `supplier`;
				TRUNCATE `sws`;";

	$exec = mysqli_query($connection , $reset);

	echo $reset;


 ?>
<?php include 'includes/admin_footer.php' ?> 