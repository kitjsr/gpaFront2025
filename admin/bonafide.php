<?php
require_once("models/config.php");
if(!empty($_POST)) {
	$agree = trim($_POST['CHECKBOX_1']);
	$mobile = trim($_POST['mobile']);
	if($agree==1)
	{
		date_default_timezone_set('Asia/Calcutta');
		$date=date("Y-m-d  h:i:s A");
		$currentYear=date("Y");
		//echo $app_id;
		//finalSubmit($app_id, $final_submit=1, $date);
		$countRequest=checkNoOfBoRequest($mobile);
		
		
		if($countRequest['no']>0)
		{
			///////  Last Apply Date
		$lastRequestId=checkLastBo($mobile);
		$lastBoRequest=fetchLastBoRequest($lastRequestId['max']);
		// Difference between Apply Date and Current Date
		//creating a date object
			$todays_date=date("d-m-Y");
			$date11=date_create(date( "d-m-Y h:i:s", strtotime($lastBoRequest['date'])));
			$date22 = date_create($todays_date);
			//calculating the difference between dates
			//the dates must be provided to the function as date objects that's why we were setting them as 
			//date objects and not just as strings
			//date_diff returns an date object wich can be accessed as seen below
			$diff1122 = date_diff($date22, $date11);

			//accesing days
			$ldDays = $diff1122->d;
			//accesing months
			$ldMonths = $diff1122->m;
			//accesing years
			$ldYears = $diff1122->y;
			$diff=($ldYears*12)+$ldMonths;
		
		if($diff>1){
			/////// Last Bonafide Status Change to 0 Close
			$updateStatus=updateLastBoStatus($lastRequestId['max'], $status=0);
			///// Bonafide Request
			$bno=checkNoOfBoYear($currentYear);
			$nextBno=$bno['no']+1;
			$nextBoId="".$nextBno."/".$currentYear."";
			$addDetails=addboRequest($nextBoId,$mobile, $date,$currentYear);
			$successes[] = lang("BONAFIDE_REQUEST");
		}
		else{
			$errors[] = lang("BO_REQUEST_DIFF");
		}
		}
		else{
			///// Bonafide Request
			$bno=checkNoOfBoYear($currentYear);
			$nextBno=$bno['no']+1;
			$nextBoId="".$nextBno."/".$currentYear."";
			$addDetails=addboRequest($nextBoId,$mobile, $date,$currentYear);
			$successes[] = lang("BONAFIDE_REQUEST");
		}
		
		
	}
	
}
require_once("models/header.php");

///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d  h:i:s A");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="Grievance Cell";
$saveRecord=addUserRecord($user, $ip, $browser, $pageName, $user_activity, $date);
/////////////////////////////////////////////////////////////////////////////////
echo"<script type='text/javascript' language='JavaScript'>
<!--
function checkCheckBoxes(theForm) {
	if (
	theForm.CHECKBOX_1.checked == false ) 
	{
		alert ('You didn\'t choose I agree checkbox!');
		return false;
	} else { 	
		return true;
	}
}
//-->
</script> ";
?>
<style type="text/css">
.process-step .btn:focus{outline:none}
.process{display:table;width:100%;position:relative}
.process-row{display:table-row}
.process-step button[disabled]{opacity:1 !important;filter: alpha(opacity=100) !important}
.process-row:before{top:40px;bottom:0;position:absolute;content:" ";width:100%;height:1px;background-color:#ccc;z-order:0}
.process-step{display:table-cell;text-align:center;position:relative;}
.process-step p{margin-top:4px}
.btn-circle1{width:80px;height:80px;text-align:center;font-size:12px;border-radius:10%; background: #feaf33 !important}
</style>
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
                        <i class='ion ion-document-text'></i> Bonafide
                        <small>Dashboard</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="account.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><i class='ion ion-document-text'></i> Bonafide</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- top row -->
                     <div class='row'>
						 <div class='box box-warning'>
                                <div class='box-header'>
                                    <h3 class='box-title'>Online Bonafide Request Process</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                    <div class='box-body'>
  <div class='process'>
   <div class='process-row nav nav-tabs'>
    <div class='process-step'>
     <button type='button' class='btn btn-default btn-circle1' data-toggle='tab' href='#menu1'><i class='fa fa-info fa-3x'></i></button>
     <p><small><strong>Send</strong><br />Online Request</small></p>
    </div>
    <div class='process-step'>
     <button type='button' class='btn btn-default btn-circle1' data-toggle='tab' href='#menu2'><i class='fa fa-print fa-3x'></i></button>
     <p><small><strong>Print</strong><br />Documents</small></p>
    </div>
    <div class='process-step'>
     <button type='button' class='btn btn-default btn-circle1' data-toggle='tab' href='#menu3'><i class='fa  fa-institution fa-3x'></i></button>
     <p><small><strong>Submit</strong><br />Documents</small></p>
    </div>
    <div class='process-step'>
     <button type='button' class='btn btn-default btn-circle1' data-toggle='tab' href='#menu4'><i class='fa  fa-clock-o fa-3x'></i></button>
     <p><small><strong>Wait</strong><br />Some Working Days</small></p>
    </div>
    <div class='process-step'>
     <button type='button' class='btn btn-default btn-circle1' data-toggle='tab' href='#menu5'><i class='fa fa-file-text-o fa-3x'></i></button>
     <p><small><strong>Issue</strong><br />Bonafide Certificate</small></p>
    </div>
   </div>
  </div>
										</box><!--box-body-->
							 </box><!--box-->
 </div>
                    <!-- /.row -->
					
                    <div class="row">
						<div class='col-md-6'>
					<!-- general form elements -->
                            <div class='box box-primary'>
                                <div class='box-header'>
                                    <h3 class='box-title'>Online Bonafide Request</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                    <div class='box-body'>
										<?php
										echo resultBlock($errors,$successes);
										echo"
										<form action='".$_SERVER['PHP_SELF']."' method='post' id='formID' onsubmit=\"return checkCheckBoxes(this);\">
										<div class='form-group'>
                                            <div class='box-body pad'>
												<input type='hidden' name='mobile' value='".$student['mobile']."'/>
												<input type='checkbox' class='' name='CHECKBOX_1' value='1'> I agree terms &amp; conditions.  
											</div>
                                        </div>
						
										<input type='submit' class='btn btn-small btn-info' value='Apply Now'>
										</form>";
										?>
								</div>
								</div>
						</div>
						<?php
						$status=checkActiveBo($student['mobile']);
						if($status['no']==1)
						{
							$row=fetchActiveBoRequest($student['mobile']);
							function checkStatus($i)
							{
								switch($i){
								case 1 : $status=" <small class='label label-danger'><i class='fa fa-clock-o'></i>  Waiting</small>";
										break;
								case 2: $status=" <small class='label label-info'><i class='fa fa-check-circle'></i>  Processing</small>";
										break;
								case 3 : $status=" <small class='label label-success'><i class='fa fa-clock-o'></i>  Issued</small>";
										break;
								}
								return $status;
							}
							
							echo"<div class='col-md-6'>
					<!-- general form elements -->
                            <div class='box box-primary'>
                                <div class='box-header'>
                                    <h3 class='box-title'>Bonafide Request Status</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                    <div class='box-body'>";
									echo"<!-- row -->
                    <div class='row'>                        
                        <div class='col-md-12'>
                            <!-- The time line -->
                            <ul class='timeline'>
                                <!-- timeline time label -->
                                <li class='time-label'>
                                    <span class='bg-red'>
                                        ".date( "j M. Y", strtotime($row['date']))."
                                    </span>
                                </li>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <li>
                                    <i class='fa fa-info bg-blue'></i>
                                    <div class='timeline-item'>
                                        <span class='time'><i class='fa fa-clock-o'></i> ".date( "H:i", strtotime($row['date']))."</span>
                                        <h3 class='timeline-header'><a href='#'>Receive Online Request</a></h3>
                                        <div class='timeline-body'>
                                            Received Online Request. Now you print and submit document(s) to Academic Section, Govt. Polytechnic, Adityapur.
                                        </div>
                                        <div class='timeline-footer'>
                                            <div>".checkStatus($row['status'])."</div>
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->";
							if($row['status']==2 || $row['status']==3)
							{
							echo"
                                <!-- timeline item -->
                                <li>
                                    <i class='fa fa-clock-o bg-aqua'></i>
                                    <div class='timeline-item'>
                                        <span class='time'></span>
                                        <h3 class='timeline-header no-border'><a href='#'>Receive Document(s)!</a> </h3>
										<div class='timeline-body'>
                                            Your Bonafide request with document(s) receive by Academic Section, Government Polytechnic, Adityapur.
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->";
							}
							
							if($row['status']==3)
							{
								
								echo"
                                
                                <!-- timeline time label -->
                                <li class='time-label'>
                                    <span class='bg-green'>
                                       ".date( "j M. Y", strtotime($row['issue_date']))."
                                    </span>
                                </li>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <li>
                                    <i class='fa fa-comments bg-yellow'></i>
                                    <div class='timeline-item'>
                                        <span class='time'><i class='fa fa-clock-o'></i> ".date( "H:i", strtotime($row['issue_date']))."</span>
                                        <h3 class='timeline-header'><a href='#'>Issue Bonafide Certificate</h3>
                                        <div class='timeline-body'>
                                            Your Bonafide Certificate issued by Academic Section, Government Polytechnic, Adityapur.
                                        </div>
                                        <div class='timeline-footer'>
                                            <p class=''>For more detail conatct Academic Section, Govt. Polytechnic, Adityapur</p>
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->";
								
								
							}
							echo"
                                <li>
                                    <i class='fa fa-clock-o'></i>
                                </li>
                            </ul>
                        </div><!-- /.col -->
                    </div><!-- /.row -->";
							echo"
										
									</div>
								</div>
						</div>";
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
        <script type="text/javascript">
		</script>

    </body>
</html>