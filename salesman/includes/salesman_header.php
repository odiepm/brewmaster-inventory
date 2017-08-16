<?php include '../includes/db.php'; ?>
<?php ob_start(); ?>
<?php session_start(); ?>
<?php 

//Validation
if ($_SESSION['login'] != true) {
    header("LOCATION: ../index.php");
}

if ($_SESSION['user_role'] != 'Salesman') {
 header("LOCATION: ../index.php");   
}

//Prefix
$prefix = strtolower($_SESSION['branch']) .'_';
$capitalPrefix = strtoupper($_SESSION['branch']);

date_default_timezone_set('Asia/Manila');
$activityDate = date("Y-m-d h:i:sa");
//Init expirate date
$expiryDateMin = date("Y-m-d");

//set session username to a variable
$activityUsernameInit = $_SESSION['username'];
$activityUsername = ucfirst($activityUsernameInit);

$displayDate = date('m/d/Y');

$selectSettings = "SELECT * FROM users WHERE user_role = 'Salesman'";
$selectSettingsE = mysqli_query($connection, $selectSettings);

while ($row = mysqli_fetch_array($selectSettingsE)) {
    $isUserManagement = $row['isUserManagement'];
    $isProductManagement = $row['isProductManagement'];
    $isStockManagement = $row['isStockManagement'];
    $isSalesmanWithdrawal = $row['isSalesmanWithdrawal'];
    $isOrderManagement = $row['isOrderManagement'];
    $isReports = $row['isReports'];
    $isSettings = $row['isSettings'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Brewmaster Inventory - Salesman</title>

    <!-- Bootstrap Core CSS -->
    <link href="/final/admin/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/final/admin/css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/final/admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="/final/admin/css/styles.css" rel="stylesheet" type="text/css">

    <!-- DataTable CSS-->
    <link href="/final/admin/js/dataTable/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
    
    <!-- jQuery -->
    <script src="/final/admin/js/jquery-3.1.1.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/final/admin/js/bootstrap.min.js"></script>
    
    <!-- Bootbox JS -->
    <script src="/final/admin/js/bootbox.min.js"></script>

    <!-- DataTable JS -->
    <script src="/final/admin/js/dataTable/js/jquery-1.12.3.js"></script>
    <script src="/final/admin/js/dataTable/js/jquery.dataTables.min.js"></script>
    <script src="/final/admin/js/dataTable/js/dataTables.bootstrap.min.js"></script>
    
    <!-- Personal Scripts -->
    <script src="/final/admin/js/scripts.js"></script>
</head>
<body>
    <script>
        $(document).on("click", ".bbValid", function(e) {
    var link = $(this).attr("href"); // "get" the intended link in a var
    e.preventDefault();    
    bootbox.confirm("Are you sure?", function(result) {    
        if (result) {
            document.location.href = link;  // if result, "set" the document location       
        }    
    });
});

</script>

<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/final/salesman/index.php" style="padding: 10px;"><i class="fa fa-fw fa-home"></i>Brewmaster Inventory (<?php echo $capitalPrefix; ?>) <?php echo $displayDate . " "; ?><label id="lblTime" style=" font-weight:bold"></label></a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo strtoupper($_SESSION['username']); ?><b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="/final/includes/logout.php" class="bbValid"><i class="fa fa-fw fa-power-off"></i> Log Out</a></li>
                </ul>
            </li>
        </ul>

        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <?php 
                if ($isProductManagement == 1) {
                 ?>
                 <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo1"><i class="fa fa-cubes"></i> Product Management </a>
                    <ul id="demo1" class="collapse">
                        <li><a href="view_inventory.php">View Inventory</a></li>
                    </ul>
                </li>  
                <?php } ?>

                <?php 
                if ($isSalesmanWithdrawal == 1) {
                 ?>
                 <li>
                    <a href="select_salesman.php" data-toggle="collapse" data-target="#demo2"><i class="glyphicon glyphicon-briefcase"></i>  Salesman Management </a>
                </li>
                <?php 
            }
            ?>
            
            <?php if ($isReports == 1) { ?>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo4"><i class="glyphicon glyphicon-list-alt"></i> Reports </a>
                <ul id="demo4" class="collapse">
                    <li><a href="reports_today.php">Sales Today</a></li>
                    <li><a href="reports.php">Sales By Date</a></li>
                    <li><a href="orders_today.php">Orders Today</a></li>
                    <li><a href="orders.php">Orders By Date</a></li>
                    <li><a href="report_interbranch.php">Interbranch Report Today</a></li>
                    <li><a href="report_interbranch_first.php">Interbranch Report (Date)</a></li>
                    <li><a href="history_transaction.php">History of Transactions</a></li>
                    <li><a href="history_sales.php">History of Sales</a></li>
                    <li><a href="history_interbranch.php">History of Interbranch Transfer</a></li>
                </ul>
            </li>
            <?php } ?>
            
        </div>


       <!-- /.navbar-collapse -->
    </nav>
    <div id="page-wrapper">

        <div class="container-fluid">

        <!-- Page Heading -->