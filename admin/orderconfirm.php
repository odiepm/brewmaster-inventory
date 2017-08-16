<?php include 'includes/admin_header.php' ?>

<?php
$id = $_GET['id'];
$update = "UPDATE {$prefix}orders SET status = 'Confirmed' where order_id = '$id'";
$sql = mysqli_query($connection,$update);
header("Location:pending_order.php");
?>

