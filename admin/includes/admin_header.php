<?php include '../includes/db.php'; ?>
<?php ob_start(); ?>
<?php session_start(); ?>
<?php 

//Validation
if ($_SESSION['login'] != true) {
    header("LOCATION: ../index.php");
}

if ($_SESSION['user_role'] != 'Admin') {
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
 ?>
 <?php 

//GET ORDER COUNT
 $pending_count = "SELECT * FROM {$prefix}orders WHERE status = 'Pending'";
 $exec_pc = mysqli_query($connection, $pending_count);
 $count_pc = 0;
    while ($row = mysqli_fetch_array($exec_pc)) {
        $count_pc++;
    }

 $outdel_count = "SELECT * FROM {$prefix}orders WHERE status = 'Out for Delivery'";
 $exec_od = mysqli_query($connection, $outdel_count);
 $count_od = 0;
    while ($row = mysqli_fetch_array($exec_od)) {
        $count_od++;
    }

 $return_count = "SELECT * FROM {$prefix}orders WHERE status = 'Return Orders'";
 $exec_rt = mysqli_query($connection, $return_count);
 $count_rt = 0;
    while ($row = mysqli_fetch_array($exec_rt)) {
        $count_rt++;
    }

 $complete_count = "SELECT * FROM {$prefix}orders WHERE status = 'Completed'";
 $exec_cp = mysqli_query($connection, $complete_count);
 $count_cp = 0;
    while ($row = mysqli_fetch_array($exec_cp)) {
        $count_cp++;
    }

$cancel_count = "SELECT * FROM {$prefix}orders WHERE status = 'Canceled'";
$cancel_cp = mysqli_query($connection, $cancel_count);
$cancelCount = 0;
   while ($row = mysqli_fetch_array($cancel_cp)) {
       $cancelCount++;
   }







//GET TO-REQUEST COUNT
$pending_req = "SELECT * FROM stock_transfer WHERE transfer_status = 'Pending' AND
transfer_tobranch ='$capitalPrefix' GROUP BY (transfer_number);";
$exec_pr = mysqli_query($connection, $pending_req);
$toPending = 0;
    while ($row = mysqli_fetch_array($exec_pr)) {
        $toPending++;
    }

$complete_req = "SELECT * FROM stock_transfer WHERE transfer_status = 'In Progress' AND
transfer_tobranch ='$capitalPrefix' GROUP BY (transfer_number);";
$exec_cr = mysqli_query($connection, $complete_req);
$toProgress = 0;
    while ($row = mysqli_fetch_array($exec_cr)) {
        $toProgress++;
    }

$canceled_req = "SELECT * FROM stock_transfer WHERE transfer_status = 'Transfer Complete' AND
transfer_tobranch ='$capitalPrefix' GROUP BY (transfer_number);";
$exec_cd = mysqli_query($connection, $canceled_req);
$toComplete = 0;
    while ($row = mysqli_fetch_array($exec_cd)) {
        $toComplete++;
    }

$canceled_reqfrom = "SELECT * FROM stock_transfer WHERE transfer_status = 'Canceled' AND
transfer_tobranch ='$capitalPrefix' GROUP BY (transfer_number);";
$X = mysqli_query($connection, $canceled_reqfrom);
$toCanceled = 0;
while ($row = mysqli_fetch_array($X)) {
    $toCanceled++;
}

//GET FROM-REQUEST COUNT
$pending_reqfrom = "SELECT * FROM stock_transfer WHERE transfer_status = 'Pending' AND
transfer_frombranch ='$capitalPrefix' GROUP BY (transfer_number);";
$cp = mysqli_query($connection, $pending_reqfrom);
$fromPending = 0;
    while ($row = mysqli_fetch_array($cp)) {
        $fromPending++;
    }

$complete_reqfrom = "SELECT * FROM stock_transfer WHERE transfer_status = 'In Progress' AND
transfer_frombranch ='$capitalPrefix' GROUP BY (transfer_number);";
$ca = mysqli_query($connection, $complete_reqfrom);
$fromProgress = 0;
    while ($row = mysqli_fetch_array($ca)) {
        $fromProgress++;
    }

$canceled_reqfrom = "SELECT * FROM stock_transfer WHERE transfer_status = 'Transfer Complete' AND
transfer_frombranch ='$capitalPrefix' GROUP BY (transfer_number);";
$cb = mysqli_query($connection, $canceled_reqfrom);
$fromComplete = 0;
    while ($row = mysqli_fetch_array($cb)) {
        $fromComplete++;
    }

$canceled_reqfrom = "SELECT * FROM stock_transfer WHERE transfer_status = 'Canceled' AND
transfer_frombranch ='$capitalPrefix' GROUP BY (transfer_number);";
$cd = mysqli_query($connection, $canceled_reqfrom);
$fromCanceled = 0;
    while ($row = mysqli_fetch_array($cd)) {
        $fromCanceled++;
    }

$displayDate = date('m/d/Y');


  ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Brewmaster Inventory - Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="css/styles.css" rel="stylesheet" type="text/css">

    <!-- DataTable CSS-->
    <link href="js/dataTable/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
    
    <!-- jQuery -->
    <script src="js/jquery-3.1.1.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
       <!-- Bootbox JS -->
    <script src="js/bootbox.min.js"></script>

    <!-- DataTable JS -->
    <script src="js/dataTable/js/jquery-1.12.3.js"></script>
    <script src="js/dataTable/js/jquery.dataTables.min.js"></script>
    <script src="js/dataTable/js/dataTables.bootstrap.min.js"></script>
    
    <!-- Personal Scripts -->
    <script src="js/scripts.js"></script>
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
                <a class="navbar-brand" href="index.php" style="padding: 10px;"><i class="fa fa-fw fa-home"></i>Brewmaster Inventory (<?php echo $capitalPrefix; ?>) <?php echo $displayDate . " "; ?><label id="lblTime" style=" font-weight:bold"></label></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo strtoupper($_SESSION['username']); ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="../includes/logout.php" class="bbValid"><i class="fa fa-fw fa-power-off"></i> Log Out</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-user"></i> User Management </a>
                        <ul id="demo" class="collapse">
                            <li><a href="users.php">Manage Users</a></li>
                            <li><a href="manage_drivers.php">Manage Vehicles</a></li>
                            <li><a href="manage_customer.php">Manage Customer</a></li>
                            <li><a href="manage_modules.php">Manage Modules</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo1"><i class="fa fa-cubes"></i> Product Management </a>
                        <ul id="demo1" class="collapse">
                            <li><a href="manage_products.php">Manage Products</a></li>
                            <li><a href="category.php">Manage Categories</a></li>
                            <li><a href="add_products.php">Add Products</a></li> 
                            <li><a href="view_empties.php">View Empties</a></li>
                            <li><a href="view_damages.php">View Damages</a></li>
                            <!-- <li><a href="view_inventory.php">View Inventory</a></li> -->
                        </ul>
                    </li>  

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo6"><i class="glyphicon glyphicon-book"></i> Stock Management </a>
                        <ul id="demo6" class="collapse">
                            <li><a href="receive_order.php">Receive Stocks</a></li>
                            <li><a href="return_stocks.php">Return Stocks</a></li>
                            <li><a href="stock_select.php?branch=">Request Stock Transfer</a></li>
                            <li><a href="stock_manage.php">View Your Requests</a></li>
                            <li><a href="stock_manage_requests.php">Manage Requests</a></li>
                            
                        </ul>
                    </li> 
					
                    <li>
                        <a href="select_salesman.php"><i class="glyphicon glyphicon-briefcase"></i>  Salesman Withdrawal </a>
                    </li>
                    
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo3"><i class="glyphicon glyphicon-list"></i>  Order Management</a>
                        <ul id="demo3" class="collapse">
                          <li><a href="pending_order.php">Pending Orders <span class="badge" style="margin-left:34px;"><?php echo $count_pc; ?></span></a></li>
                          <li><a href="outfordel_order.php">Manage Orders <span class="badge" style="margin-left:35px; background-color:#f89406"><?php echo $count_od; ?></span></a></li>
                          <li><a href="completed_orders.php">Completed Orders <span class="badge" style="margin-left:18px; background-color: #468847"><?php echo $count_cp; ?></span></a></li>
                        </ul>
                    </li>

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
                            <li><a href="history_salesman.php">Summary of Salesman</a></li>
                            <li><a href="activity_log.php">Activity Log</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo5"><i class="glyphicon glyphicon-cog"></i> Settings </a>
                        <ul id="demo5" class="collapse">
                            <li><a href="manage_price.php">Price/Mark-Up Settings</a></li>  
                            <li><a href="backuprestore.php">Backup Database</a></li>  
                        </ul>
                    </li>





            </div>
            <!-- /.navbar-collapse -->
        </nav>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->