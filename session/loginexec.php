<?php include '../includes/db.php'; ?>
<?php ob_start(); ?>
<?php session_start(); ?>
<?php date_default_timezone_set('Asia/Manila');
$loginDate = date("Y-m-d h:i:sa"); ?>
<?php 

if (empty($_POST['username']) || empty($_POST['password'])) {
	echo "<script>alert('Please enter a Username/Password!'); window.location='../index.php'</script>";
}

	$dbUser_password ='';
if (isset($_POST['login'])) {

	$username = $_POST['username'];
	$password = $_POST['password'];

	$username = mysqli_real_escape_string($connection, $username);
	$password = mysqli_real_escape_string($connection, $password);

	$checkLog = "SELECT * FROM users WHERE username = '$username' AND isLogged = 1;";
	$checkLogE = mysqli_query($connection, $checkLog);

	if (mysqli_num_rows($checkLogE) > 0) {
		echo "
		<script>
			alert('This user is already logged in!');
			window.location = '../index.php';
		</script>";
		
		 die();
	}


	$query = "SELECT * FROM users WHERE username = '$username'";
	$selectUser_query = mysqli_query($connection, $query);

	if (!$selectUser_query) {
		die(mysqli_error($connection));
	}

	while ($row = mysqli_fetch_array($selectUser_query)) {

		$dbUser_id = $row['user_id'];		
		$dbUser_branch = $row['branch'];		
		$dbUser_username = $row['username'];		
		$dbUser_password = $row['password'];		
		$dbUser_firstname = $row['firstname'];		
		$dbUser_lastname = $row['lastname'];		
		$dbUser_role = $row['user_role'];	
		$dbUser_isLogged = $row['isLogged'];	
	}

	
if ($password == $dbUser_password){
		
		$_SESSION['user_id'] = $dbUser_id;
		$_SESSION['branch'] = $dbUser_branch;
		$_SESSION['username'] = $dbUser_username;
		$_SESSION['firstname'] = $dbUser_firstname;
		$_SESSION['lastname'] = $dbUser_lastname;
		$_SESSION['user_role'] = $dbUser_role;
		$_SESSION['branch'] = $dbUser_branch;
		$_SESSION['login'] = true;
		$logName = $_SESSION['username'];


		//Set isLogged to 1 in users table
		$islog = "UPDATE users SET isLogged = 1 WHERE user_id = $dbUser_id;";
		$islogE = mysqli_query($connection, $islog);



			if ($_SESSION['user_role'] == 'Admin') {

				if ($_SESSION['branch'] == 'BS') {
					header("Location: ../admin");

				} elseif ($_SESSION['branch'] == 'TD') {
					header("Location: ../admin");

				} elseif ($_SESSION['branch'] == 'FV') {
					header("Location: ../admin");
				}

			} else

			if ($_SESSION['user_role'] == 'Salesman') {
				header("Location: ../salesman");
			}

		

} else {

		echo "
		<script>
			alert('Invalid Username/Password!');
			window.location = '../index.php';
		</script>";

	}

}
?>