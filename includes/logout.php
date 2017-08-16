<?php include '../includes/db.php'; ?>
<?php session_start() ?>

<?php  

$id = $_SESSION['user_id'];

date_default_timezone_set('Asia/Manila');
$logoutDate = date("Y-m-d h:i:sa"); 

$logName = $_SESSION['username'];

$queryLog = "INSERT INTO activity_log (description, date) VALUES ('$logName logged out', '$logoutDate');";
$execLog = mysqli_query($connection, $queryLog);

$logout = "UPDATE users SET isLogged = 0 WHERE user_id = $id;";
$logoutE = mysqli_query($connection, $logout);


session_destroy();
header("Location: ../index.php");


?>