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
						<div class="col-md-6">
						    <div class='alert alert-danger'>If you have valid Fee Deposit Permission then Pay Now!</div>
						    <table class="table table-bordered table-hover table-striped">
            <tr>
                <th>सामान्य/पिछड़ा वर्ग</th>
                <th>राशि</th>
                <th>अनुसूचित जाति/जनजाति</th>
                <th>राशि</th>
                <th>TFW/छात्राओं</t>
                <th>राशि</th>
            </tr>
            <tr>
                <td>नामांकन शुल्क</td>
                <td class="text-right">05</td>
                <td>नामांकन शुल्क</td>
                <td class="text-right">05</td>
                <td>नामांकन शुल्क</td>
                <td class="text-right">05</td>
            </tr>
            <tr>
                <td>शिक्षण शुल्क</td>
                <td class="text-right">2400</td>
                <td>शिक्षण शुल्क</td>
                <td class="text-right">600</td>
                <td>शिक्षण शुल्क</td>
                <td class="text-right">00</td>
            </tr>
            <tr>
                <td>विशेष शुल्क</td>
                <td class="text-right">200</td>
                <td>विशेष शुल्क</td>
                <td class="text-right">200</td>
                <td>विशेष शुल्क</td>
                <td class="text-right">200</td>
            </tr>
            <tr>
                <td>कॉशन मनी</td>
                <td class="text-right">200</td>
                <td>कॉशन मनी</td>
                <td class="text-right">200</td>
                <td>कॉशन मनी</td>
                <td class="text-right">200</td>
            </tr>
            <tr>
                <td><b>कुल राशि</b></td>
                <td class="text-right">2805</td>
                <td><b>कुल राशि</b></td>
                <td class="text-right">1005</td>
                <td><b>कुल राशि</b></td>
                <td class="text-right">405</td>
            </tr>
            <tr>
                <td class='table-info'>Hostel Fee</td>
                <td class="text-right">840</td>
                <td colspan='4'></td>
            </tr>
        </table>
						<form method='POST' action='confirmfee2022.php'>
                                <select name='pcode' class='form-control' required>
                                    <option value=''>--- Choose Any One ---</option>
                                    <option value='101'>101 - New Admission(Gen/BC-I/BC-II) </option>
                                    <option value='102'>102 - New Admission(SC/ST/TFW/Female) </option>
                                    <option value='103'>103 - New Admission(Transfer) </option>
                                    <option value='104'>104 - New Admission(Re-Admission) </option>
                                    <option value='105'>105 - First Year(Re-Admission) Gen/BC-I/BC-II </option>
                                    <option value='106'>106 - First Year(Re-Admission) SC/ST/TFW/Female</option>
                                    <option value='201'>201 - Second Year Admission(Gen/BC-I/BC-II) </option>
                                    <option value='202'>202 - Second Year Admission(SC/ST) </option>
                                    <option value='203'>203 - Second Year Admission(TFW/Female) </option>
                                    <option value='204'>204 - Second Year Admission(Re-Admission) </option>
                                    <option value='301'>301 - Third Year Admission(Gen/BC-I/BC-II) </option>
                                    <option value='302'>302 - Third Year Admission(SC/ST) </option>
                                    <option value='303'>303 - Third Year Admission(TFW/Female) </option>
                                    <option value='304'>304 - Third Year Admission(Re-Admission) </option>
                                    <option value='501'>501 - Hostel Fee </option>
                                
                                </select>
                                <input type='submit' class='btn btn-danger' value='Next' />
                            </form>
									
										
										
						</div>
						<!-- col-md-6-->
						<div class="col-md-6">
							<h2>Transaction Details</h2>
                          	<table id='example1' class='table table-bordered table-striped table-hover'>
                        	<thead>
								<th style='text-align:left;'>Purpose</th>
								<th style='text-align:center;'>Trans. Id</th>
                                <th style='text-align:center;'>Amount</th>
                                <th style='text-align:center;'>Date</th>
                                <th></th>
                            </thead>
                            <tbody>
                            <?php
								$data=fetchSingleStudentPay($student['sid']);
								foreach ($data as $row){
								echo"
                            	<tr>
                                	<td style='text-align:left;'>".$row['pcode']."</td>
									<td style='text-align:center;'>".$row['trno']."</td>
									<td style='text-align:right;'>".$row['amount']."</td>
									<td style='text-align:center;'>".date( "j M, Y", strtotime($row['txndate']))."</td>
									<td style='text-align:center;'><a href='invoice_2022.php?fid=".$row['fid']."' target='_blank'><i class='fa fa-file'></i></a></td>
                                </tr>";
								}
							
							
							?>
                            </tbody>
                            <tfoot>
                                         
                                        </tfoot>
                                    </table>
                                
						</div>
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