<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");

///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d H:i:s");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="Login on Admin Panel";
//$saveRecord=addUserRecord($user, $ip, $browser, $pageName, $user_activity, $date);
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
							if($loggedInUser->checkPermission(array(4))){
								if($student['photo']!=null){
									echo "
                                   <a href='student_profile.php'><img src='uploads/".$student['photo']."' class='img-circle profilepic' alt='Photo' /></a>";
								}
								else{
								echo "<a href='student_profile.php'><img src='img/avatar3.png' class='img-circle profilepic' alt='User Image' /></a>";
								}
							}
							else{
								echo "<img src='img/avatar3.png' class='img-circle' alt='User Image' />";
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
                       <i class="fa fa-dashboard"></i> Dashboard
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
					<?php
					if ($loggedInUser->checkPermission(array(2))){
						echo"
						<!-- Small boxes (Stat box) -->
                    <div class='row'>
                        <div class='col-lg-3 col-xs-6'>
                            <!-- small box -->
                            <div class='small-box bg-aqua'>
                                <div class='inner'>
                                    <h3>
                                        Notice
                                    </h3>
                                    <p>
                                        &nbsp;
                                    </p>
                                </div>
                                <div class='icon'>
                                    <i class='ion ion-document-text'></i>
                                </div>
                                <a href='notices.php' class='small-box-footer'>
                                    More info <i class='fa fa-arrow-circle-right'></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class='col-lg-3 col-xs-6'>
                            <!-- small box -->
                            <div class='small-box bg-green'>
                                <div class='inner'>
                                    <h3>Syllabus</h3>
                                    <p>&nbsp;</p>
                                </div>
                                <div class='icon'>
                                    <i class='ion ion-person-stalker'></i>
                                </div>
                                <a href='#' class='small-box-footer'>
                                    More info <i class='fa fa-arrow-circle-right'></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class='col-lg-3 col-xs-6'>
                            <!-- small box -->
                            <div class='small-box bg-yellow'>
                                <div class='inner'>
                                    <h3>Class Routine</h3>
                                    <p>
                                        Received Resume
                                    </p>
                                </div>
                                <div class='icon'>
                                    <i class='ion ion-person'></i>
                                </div>
                                <a href='#.php' class='small-box-footer'>
                                    More info <i class='fa fa-arrow-circle-right'></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class='col-lg-3 col-xs-6'>
                            <!-- small box -->
                            <div class='small-box bg-red'>
                                <div class='inner'>
                                    <h3>Principal</h3>
                                    <p>&nbsp;</p>
                                </div>
                                <div class='icon'>
                                    <i class='fa fa-rupee'></i>
                                </div>
                                <a href='#' class='small-box-footer'>
                                    More info <i class='fa fa-arrow-circle-right'></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- /.row -->";
					}
					if ($loggedInUser->checkPermission(array(4))){
						$gno=checkNoUnsolveg($student['mobile']);
						echo"
						<!-- Small boxes (Stat box) -->
                    <div class='row'>
                    <!--
                        <div class='col-lg-3 col-xs-6'>
                            
                            <div class='small-box bg-aqua'>
                                <div class='inner'>
                                    <h3>
                                        Bonafide
                                    </h3>
                                    <p>
                                        &nbsp;
                                    </p>
                                </div>
                                <div class='icon'>
                                    <i class='ion ion-document-text'></i>
                                </div>
                                <a href='bonafide.php' class='small-box-footer'>
                                    More info <i class='fa fa-arrow-circle-right'></i>
                                </a>
                            </div>
                        </div>
                        -->
                        <!-- ./col -->
                        <div class='col-lg-3 col-xs-6'>
                            <!-- small box -->
                            <div class='small-box bg-green'>
                                <div class='inner'>
                                    <h3>Library</h3>
                                    <p>&nbsp;</p>
                                </div>
                                <div class='icon'>
                                    <i class='fa fa-book'></i>
                                </div>
                                <a href='library.php' class='small-box-footer'>
                                    More info <i class='fa fa-arrow-circle-right'></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                      
                        
                        
                        <div class='col-lg-3 col-xs-6'>
                            <!-- small box -->
                            <div class='small-box bg-yellow'>
                                <div class='inner'>
                                    <h3>Fee Deposit</h3>
                                    <p>VISA / Master Debit Card not accepted.</p>
                                </div>
                                <div class='icon'>
                                    <i class='fa fa-rupee'></i>
                                </div>
                                <a href='fee2022.php' class='small-box-footer'>
                                    More info <i class='fa fa-arrow-circle-right'></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- /.row -->
					<div class='row'>
					    <div class='col-12'>
					        <div class='alert alert-danger'>
						        <h4 class='alert-heading'>Important Notice!</h4>
						        <ul class='list-unstyled'>
						            <li>Step 1 : Goto <b>Fee Deposit Section</b></li>
						            <li>Step 2 : For Payment Choose Correct Option and Proceed to Pay.</li>
						        </ul> 
						        <hr>
						        <p>If Fee mismatched then Don't Pay,  contact Cash Section, Government Polytechnic Adityapur or Mr. Kunal Mahto, Lecturer (CSE) - <a href='tel:9470312947'>9470312947</a></p>
						  </div>
					    </div>
					</div>
					<div class='row'>
						<div class='col-md-6'>
							<div class='box box-danger'>
                                <div class='box-header'>
									<h3 class='box-title'>Welcome <b>".$student['name']."</b>!</h3>
                                </div><!-- /.box-header -->
                                <div class='box-body'>
								";
						if(empty($student['photo']) || empty($student['sign'])||empty($student['thumb'])){
								echo"
									<table class='table table-bordered'>
                                        <tr>
                                            <th style='width: 10px'>#</th>
                                            <th>Task</th>
                                            <th>Progress</th>
                                            <th style='width: 40px'>Label</th>
                                        </tr>";
								$icount=0;
								$iprogress=70;
							if($student['photo']==null)
							{
								$icount+=1;
								echo"
                                        <tr>
                                            <td>".$icount.".</td>
                                            <td><a href='upload.php'>Upload Photo</a></td>
                                            <td>
                                                <div class='progress xs'>
                                                    <div class='progress-bar progress-bar-danger' style='width: ".$iprogress."%'></div>
                                                </div>
                                            </td>
                                            <td><span class='badge bg-red'>".$iprogress."%</span></td>
                                        </tr>";
							}
							else{
								$iprogress+=10;
							}
							if($student['sign']==null){
								$icount+=1;
								echo"
										<tr>
                                            <td>".$icount.".</td>
                                            <td><a href='upload.php'>Upload Sign</a></td>
                                            <td>
                                                <div class='progress xs'>
                                                    <div class='progress-bar progress-bar-danger' style='width:".$iprogress."%'></div>
                                                </div>
                                            </td>
                                            <td><span class='badge bg-red'>".$iprogress."%</span></td>
                                        </tr>";
							}else{
								$iprogress+=10;
							}
							if($student['thumb']==null){
								$icount+=1;
								echo"
										<tr>
                                            <td>".$icount.".</td>
                                            <td><a href='upload.php'>Upload Thumb</a></td>
                                            <td>
                                                <div class='progress xs'>
                                                    <div class='progress-bar progress-bar-danger' style='width:".$iprogress."%'></div>
                                                </div>
                                            </td>
                                            <td><span class='badge bg-red'>".$iprogress."%</span></td>
                                        </tr>
									</table>";
							}else{
								$iprogress+=10;
							}
							
					}
					else{
	function branch($j)
	{
		switch ($j)
		{
			case 1: $branch="Mechanical Engineering";
			break;
			case 2 : $branch="Electrical Engineering";
			break;
			case 3 : $branch="Metallurgical Engineering";
			break;
			case 4 : $branch="Computer Sc. &amp; Engineering";
			break;
			default : $branch="N/A";
			break;
		
		}
		return $branch;
	}
						echo"
								<table class='table table-bordered'>
                                        <tr>
                                            <td rowspan='6' style='text-align:center !important; vertical-align:middle !important;'><img src='uploads/".$student['photo']."' class='img-rounded img-responsive' width='200px' height='230px' style='margin:0 auto !important'></td>
                                            <td style='text-align:center !important; vertical-align:middle !important;'><img alt='' src='barcode.php?codetype=Code39&size=40&text=".str_pad($student['cid'], 10, '0', STR_PAD_LEFT)."' /></br>".str_pad($student['cid'], 10, '0', STR_PAD_LEFT)."</td>
                                        </tr>
										<tr>
                                            <td><strong>Branch</strong> : ".branch($student['branch'])."</td>  
                                        </tr>
										<tr>
                                            <td><strong>Semester</strong> : ".$student['sem']."</td>  
                                        </tr>
										<tr>
                                            <td><strong>Board Roll No.</strong> : ".$student['broll']."</td>  
                                        </tr>
										<tr>
                                            <td><strong>Class Roll No.</strong> : ".$student['roll']."</td>  
                                        </tr>
								</table>";
						}
						echo"
						 		</div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
						<div class='col-md-6'>
							<div class='box box-info'>
                                <div class='box-body'>
                                    <div id='carousel-example-generic' class='carousel slide' data-ride='carousel'>
                                        <ol class='carousel-indicators'>
                                            <li data-target='#carousel-example-generic' data-slide-to='0' class='active'></li>
                                            <li data-target='#carousel-example-generic' data-slide-to='1' class=''></li>
                                            <li data-target='#carousel-example-generic' data-slide-to='2' class=''></li>
											<li data-target='#carousel-example-generic' data-slide-to='3' class=''></li>
											<li data-target='#carousel-example-generic' data-slide-to='4' class=''></li>
                                        </ol>
                                        <div class='carousel-inner'>
                                            <div class='item active'>
                                                <img src='http://placehold.it/900x500/00acd7/ffffff&text=Bonafide' alt='First slide'>
                                                <div class='carousel-caption'>
                                                    Bonafide Certificate
                                                </div>
                                            </div>
                                            <div class='item'>
                                                <img src='http://placehold.it/900x500/009551/ffffff&text=Library' alt='Second slide'>
                                                <div class='carousel-caption'>
                                                    Library
                                                </div>
                                            </div>
                                            <div class='item'>
                                                <img src='http://placehold.it/900x500/da8c10/ffffff&text=Fee+Deposit' alt='Third slide'>
                                                <div class='carousel-caption'>
                                                    Fee Deposit
                                                </div>
                                            </div>
											<div class='item'>
                                                <img src='http://placehold.it/900x500/dc5e4b/ffffff&text=Grievance' alt='Third slide'>
                                                <div class='carousel-caption'>
                                                    Grievance Cell
                                                </div>
                                            </div>
											<div class='item'>
                                                <img src='http://placehold.it/900x500/00acd7/ffffff&text=CLC' alt='Third slide'>
                                                <div class='carousel-caption'>
                                                    College Leaving Certificate
                                                </div>
                                            </div>
                                        </div>
                                        <a class='left carousel-control' href='#carousel-example-generic' data-slide='prev'>
                                            <span class='glyphicon glyphicon-chevron-left'></span>
                                        </a>
                                        <a class='right carousel-control' href='#carousel-example-generic' data-slide='next'>
                                            <span class='glyphicon glyphicon-chevron-right'></span>
                                        </a>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
					</div>
					<div class='row'>
						<div class='col-md-12'>
                        <div class='pull-right'>&copy; Govt. Polytechnic, Adityapur<div>
						</div>
					</div>";
					}
					?>
                    

                    

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


        <!-- jQuery 2.0.2 -->
        <script src="js/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Morris.js charts -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="js/plugins/morris/morris.min.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- fullCalendar -->
        <script src="js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        
        
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
        
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="js/AdminLTE/dashboard.js" type="text/javascript"></script>        

    </body>
</html>