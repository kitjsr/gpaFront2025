<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");

///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d h:i:s");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="Fee Deposit";
$saveRecord=addUserRecord($user, $ip, $browser, $pageName, $user_activity, $date);
/////////////////////////////////////////////////////////////////////////////////
?>

    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="account.php" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                Admin Panel
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <?php
						include("right_top_dropdown_menu.php");
						?>
                        <!-- User Account: style can be found in dropdown.less -->
                        <?php
						include("account_dropdown_menu.php");
						?>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <?php
							if ($loggedInUser->checkPermission(array(4))){
								if($student['photo']!=null){
									echo "
                                   <img src='uploads/".$student['photo']."' class='img-circle' alt='Photo' />";
								}
								else{
								echo "<img src='img/avatar3.png' class='img-circle' alt='Photo' />";
								}
							}
else{
								echo "<img src='img/avatar3.png' class='img-circle' alt='Photo' />";
								}
                            ?>
                        </div>
                        <div class="pull-left info">
                            <p><?php  echo"$loggedInUser->displayname"; ?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                      <?php
					include("left-nav.php");
					?>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <i class='fa fa-rupee'></i> Fee Deposit
                        <small>Dashboard</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="account.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><i class='fa fa-rupee'></i> Fee Deposit</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- top row -->
                    <div class="row">
                        <div class="col-xs-12 connectedSortable">
                            
                        </div><!-- /.col -->
                    </div>
                    <!-- /.row -->
					<div class="row">
						<?php
					
							$msg=$_POST['msg'];
							$data=explode("|",$msg);
							//echo $data[13];
							$sid=$data[1];
							$cid=$data[16];
							$trno=$data[2];
							$brno=$data[3];
							$amount=$data[4];
							$authstatus=$data[14];
							$tdata=explode(" ",$data[13]);
							$tdate=explode("-",$tdata[0]);
							$txndate="".$tdate[2]."-".$tdate[1]."-".$tdate[0]." ".$tdata[1]."";
							$pcode=$data[19];// Payment Code
							//echo $txndate;
							//
							if($authstatus==300)
							{
								// Insert Payment Details
								addPay($sid,$cid,$pcode,$trno,$brno,$amount,$authstatus,$txndate,$date);
								echo "<script>alert('Successfully Payment Recieved!')</script>";
								//header ('Location: fee_deposit.php');
							}
							else{
								echo "<script>alert('Payment Failed! Try Again!')</script>";
								//header ('Location: fee_deposit.php');
							}
						
						?>
					</div>
                    
                    

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

       


       <!-- jQuery 2.0.2 -->
        <script src="js/jquery.min.js"></script>
       <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- page script -->
        

    </body>
</html>