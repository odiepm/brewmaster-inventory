<?php include 'includes/db.php' ?>
<?php ob_start(); ?>
<?php session_start(); ?>
<?php if (isset($_SESSION['login']) && $_SESSION['user_role'] == 'Admin') {
		header("LOCATION: admin/index.php");
	} 
	//https://www.facebook.com/elyjhasambrano/videos/1832343320115851/
	
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Brewmaster Inventory | Login</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/styles.css" rel="stylesheet">

</head>

	<body id="loginBg">
	<div class="container" style="margin-top:30px">
	<div class="col-md-12">
	    <div class="modal-dialog" style="margin-bottom:0">
	        <div class="modal-content">
	                    <div class="panel-heading">
	                    <img src="images/logo1.png" alt="" class="center-block image-responsive" style="width: 100px; height: 100px;">
	                    </div>
	                    <div class="panel-body">
	                        <form method="POST" action="session/loginexec.php">
	                            <fieldset>
	                                <div class="form-group">
	                                    <input class="form-control" placeholder="Username" name="username" type="text" autofocus="" autocomplete="off" required>
	                                </div>
	                                <div class="form-group">
	                                    <input class="form-control" placeholder="Password" name="password" type="password" value="" required>
	                                </div>
	                                <!-- Change this to a button or input when using this as a form -->
	                                <input type="submit" value="Login" name="login" class="btn btn-success btn-block">
	                            </fieldset>
	                        </form>
	                    </div>
	                </div>
	    </div>
	</div>
	<hr>

	</div>
	</body>

</html>