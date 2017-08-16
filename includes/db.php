<?php 

$db['db_host'] = "localhost";
$db['db_user'] = "root";
$db['db_pass'] = "";
$db['db_name'] = "inventorydb";

foreach ($db as $key => $value) {
define(strtoupper($key), $value);
}

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$connection) {
	echo "Failed to connect to the database" . mysqli_errno($connection);
}
date_default_timezone_set('Asia/Manila');
?>