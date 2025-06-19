<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

require_once("models/header.php");
$allProgram=fetchAllProgram();
///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d  h:i:s A");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="Institute Setting";
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
                            <img src="img/avatar3.png" class="img-circle" alt="User Image" />
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
                        Institute Setting
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="account.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Institute Setting</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
					<?php
						echo"
						<!-- Small boxes (Stat box) -->
                    <div class='row'>
                        <div class='col-lg-3 col-xs-6'>
                            <!-- small box -->
                            <div class='small-box bg-aqua'>
                                <div class='inner'>
                                    <h3>
                                        Branch
                                    </h3>
                                    <p>
                                        &nbsp;
                                    </p>
                                </div>
                                <div class='icon'>
                                    <i class='fa fa-location-arrow'></i>
                                </div>
                                <a href='view_branch.php' class='small-box-footer'>
                                    View Details <i class='fa fa-arrow-circle-right'></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class='col-lg-3 col-xs-6'>
                            <!-- small box -->
                            <div class='small-box bg-green'>
                                <div class='inner'>
                                    <h3>
                                        Program
                                    </h3>
                                    <p>
                                        &nbsp;
                                    </p>
                                </div>
                                <div class='icon'>
                                    <i class='fa fa-code-fork'></i>
                                </div>
                                <a href='view_program.php' class='small-box-footer'>
                                    View Details <i class='fa fa-arrow-circle-right'></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class='col-lg-3 col-xs-6'>
                            <!-- small box -->
                            <div class='small-box bg-yellow'>
                                <div class='inner'>
                                    <h3>
                                         Trainer
                                    </h3>
                                    <p>
                                        &nbsp;
                                    </p>
                                </div>
                                <div class='icon'>
                                    <i class='ion ion-person'></i>
                                </div>
                                <a href='view_trainer.php' class='small-box-footer'>
                                    View Details <i class='fa fa-arrow-circle-right'></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class='col-lg-3 col-xs-6'>
                            <!-- small box -->
                            <div class='small-box bg-red'>
                                <div class='inner'>
                                    <h3>
                                        Batch
                                    </h3>
                                    <p>
                                        &nbsp;
                                    </p>
                                </div>
                                <div class='icon'>
                                    <i class='fa fa-bookmark'></i>
                                </div>
                                <a href='view_branch.php' class='small-box-footer'>
                                    View Details <i class='fa fa-arrow-circle-right'></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- /.row -->
					 <!-- Small boxes (Stat box) -->
                    <div class='row'>
                        <div class='col-lg-3 col-xs-6'>
                            <!-- small box -->
                            <div class='small-box bg-blue'>
                                <div class='inner'>
                                    <h3>Message</h3>
                                    <p>Template</p>
                                </div>
                                <div class='icon'>
                                    <i class='fa fa-envelope-o'></i>
                                </div>
                                <a href='#' class='small-box-footer'>
                                    More info <i class='fa fa-arrow-circle-right'></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class='col-lg-3 col-xs-6'>
                            <!-- small box -->
                            <div class='small-box bg-purple'>
                                <div class='inner'>
                                    <h3>Alert</h3>
                                    <p>SMS/E-Mail</p>
                                </div>
                                <div class='icon'>
                                    <i class='fa fa-envelope'></i>
                                </div>
                                <a href='#' class='small-box-footer'>
                                    More info <i class='fa fa-arrow-circle-right'></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class='col-lg-3 col-xs-6'>
                            <!-- small box -->
                            <div class='small-box bg-teal'>
                                <div class='inner'>
                                    <h3>Users</h3>
                                    <p>&nbsp;</p>
                                </div>
                                <div class='icon'>
                                    <i class='fa fa-group'></i>
                                </div>
                                <a href='admin_users.php' class='small-box-footer'>
                                    More info <i class='fa fa-arrow-circle-right'></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class='col-lg-3 col-xs-6'>
                            <!-- small box -->
                            <div class='small-box bg-maroon'>
                                <div class='inner'>
                                    <h3>
                                        160
                                    </h3>
                                    <p>
                                        Visitors
                                    </p>
                                </div>
                                <div class='icon'>
                                    <i class='ion ion-ios7-pricetag-outline'></i>
                                </div>
                                <a href='records.php' class='small-box-footer'>
                                    More info <i class='fa fa-arrow-circle-right'></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- /.row -->";
					
					?>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

       <!-- jQuery 2.0.2 -->
        <script src="js/jquery.min.js"></script> 
       <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

    </body>
</html>