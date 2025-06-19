<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$gid=$_GET['gid'];
require_once("models/header.php");
$g=fetchSingleg($gid);
$gsno=checkNoOfGsolution($gid);
if($g['status']==1){
	$status=" <small class='label label-danger'><i class='fa fa-clock-o'></i>  Waiting</small>";
}
else{
	$status=" <small class='label label-success'><i class='fa fa-check-circle'></i>  Solved</small>";
}
///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d  h:i:s A");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="Grievance Cell - Solution";
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
                        <i class='fa  fa-comments'></i> Grievance Solution
                        <small>Grievance</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="account.php"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="grievance.php"><i class='fa  fa-comments'></i> Grievance</a></li>
                        <li class="active"><i class='fa  fa-comments'></i> Grievance Solution</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- top row -->
                    <div class="row">
                        <div class="col-xs-12 connectedSortable">
							<?php 
                            
							
								echo"<!-- row -->
                    <div class='row'>                        
                        <div class='col-md-12'>
                            <!-- The time line -->
                            <ul class='timeline'>
                                <!-- timeline time label -->
                                <li class='time-label'>
                                    <span class='bg-red'>
                                        ".date( "j M. Y", strtotime($g['date']))."
                                    </span>
                                </li>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <li>
                                    <i class='fa fa-envelope bg-blue'></i>
                                    <div class='timeline-item'>
                                        <span class='time'><i class='fa fa-clock-o'></i> ".date( "H:i", strtotime($g['date']))."</span>
                                        <h3 class='timeline-header'><a href='#'>".$g['gtitle']."</a></h3>
                                        <div class='timeline-body'>
                                            ".$g['g']."
                                        </div>
                                        <div class='timeline-footer'>
                                            <div>".$status."</div>
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <!-- timeline item -->
                                <li>
                                    <i class='fa fa-clock-o bg-aqua'></i>
                                    <div class='timeline-item'>
                                        <span class='time'><i class='fa fa-clock-o'></i> ".date( "H:i", strtotime($g['date']))."</span>
                                        <h3 class='timeline-header no-border'><a href='#'>Keep Patience!</a> Your grievance receive by Grievence Cell, Government Polytechnic, Adityapur and forward to concern department and resolved shortly.</h3>
                                    </div>
                                </li>
                                <!-- END timeline item -->";
							if($gsno['no']>0)
							{
								$solution=fetchAllgSolution($gid);
								foreach ($solution as $row){
								echo"
                                
                                <!-- timeline time label -->
                                <li class='time-label'>
                                    <span class='bg-green'>
                                       ".date( "j M. Y", strtotime($row['date']))."
                                    </span>
                                </li>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <li>
                                    <i class='fa fa-comments bg-yellow'></i>
                                    <div class='timeline-item'>
                                        <span class='time'><i class='fa fa-clock-o'></i> ".date( "H:i", strtotime($row['date']))."</span>
                                        <h3 class='timeline-header'><a href='#'>Govt. Polytechnic, Adityapur</a> replied on your grievance</h3>
                                        <div class='timeline-body'>
                                            ".$row['ans']."
                                        </div>
                                        <div class='timeline-footer'>
                                            <a class='btn btn-warning btn-flat btn-xs'>For more detail conatct Grievance Cell, Govt. Polytechnic, Adityapur</a>
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->";
								}
								
							}
							echo"
                                <li>
                                    <i class='fa fa-clock-o'></i>
                                </li>
                            </ul>
                        </div><!-- /.col -->
                    </div><!-- /.row -->";
							
							?>
                        </div><!-- /.col -->
                    </div>
                    <!-- /.row -->
					
                  

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

        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $('#example1').DataTable( {
        order: [[ 3, 'desc' ]]
    } );
                
            });
    
        </script>

    </body>
</html>