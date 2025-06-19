<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
$gid=$_GET['gid'];
$enquiry=fetchSingleg($gid);

if($enquiry['extra']!=NULL){
	$extra_data=explode(",",$enquiry['extra']);
	$email=$extra_data[0];
	$name=$extra_data[1];
	$dob=$extra_data[2];
	$branch=$extra_data[3];
	$sem=$extra_data[4];
	$broll=$extra_data[5];
}
else{
	
	$student=fetchSingleStudent($enquiry['mobile']);
	$email=$student['email'];
	$name=$student['name'];
	$dob=$student['dob'];
	$branch=$student['branch'];
	$sem=$student['sem'];
	$broll=$student['broll'];
}

///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d  h:i:s A");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="Grievance Solution ".$gid."";
$saveRecord=addUserRecord($user, $ip, $browser, $pageName, $user_activity, $date);
/////////////////////////////////////////////////////////////////////////////////
/// Read Message


//$sample_date = date( "Y-m-d  H:i:s", strtotime($enquiry['date']));        //year-month-day hour:minute:second
//$result = time_difference($sample_date); // 1 year ago

if(!empty($_POST['ans'])) {
	$ans= trim($_POST['ans']);
	$mobile= trim($_POST['mobile_to']);
	$email_to= trim($_POST['email_to']);
	$gid= trim($_POST['gid']);
	

////////// SENT MESSAGE DETAILS //////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d  h:i:s A");
$addGr=addGrSol($gid,$ans, $date);
$updateStatus=updateGrStatus($gid, $status=0);
///////////////////////////////////////////////////////////////////	
$mail_to = $email_to;
$subject = 'Message from Grievance Cell, Govt. Polytechnic, Adityapur';
$body_message= 'Message: '.$ans;

$from="info@gpadp.org.in";

$mail_status = mail($mail_to, $subject, $body_message,"From:".$from);


}
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
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
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
                        Grievance Details
                        <small>Grievance</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="account.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="inbox.php"><i class='fa fa-comments'></i> Grievance</a></li>
                        <li class="active"><i class='fa fa-envelope-o'></i> Grievance Details</li>
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
					
                    <!-- top row -->
                    <div class="row col-xs-12">
                        <div class='col-md-6'>
                            <div class='box'>
                                <div class='box-header'>
                                    <h3 class='box-title'>Read Grievance</h3>
                                </div><!-- /.box-header -->
                                <div class='box-body'>
									<?php
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
                                            <td><strong>Name</strong> </td>
                                            <td> ".$name."</td>  
                                        </tr>
										<tr>
                                            <td><strong>Branch</strong> </td>
                                            <td> ".branch($branch)."</td>  
                                        </tr>
										<tr>
                                            <td><strong>Semester</strong> </td>
                                            <td> ".$sem."</td>  
                                        </tr>
										<tr>
                                            <td><strong>Board Roll No.</strong></td>
                                            <td> ".$broll."</td>  
                                        </tr>
                                        <tr>
                                            <td><strong>Mobile</strong></td>
                                            <td><a href='tel:".$enquiry['mobile']."'>".$enquiry['mobile']."</a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>E-Mail</strong></td>
                                            <td><a href='mailto:".$email."'>".$email."</a></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Grievance</strong></td>
                                            <td>".$enquiry['g']."</td>
                                        </tr>
                                        
                                        <tr>
                                            <td><strong>Date</strong></td>
                                            <td>".date( "j M, Y h:i:s A", strtotime($enquiry['date']))."</td>
                                        </tr>
                                        
                                    </table>";
									?>
                                </div><!-- /.box-body -->
                                <div class='box-footer clearfix'>
                                    
                                    <a class="btn btn-block btn-primary" data-toggle="modal" data-target="#compose-modal"><i class="fa fa-pencil"></i> Compose Grievance Reply</a>
                                </div>
                            </div><!-- /.box -->
                         </div>
                         
                         
                         <div class='col-md-6'>
                            <!-- general form elements -->
                            <div class='box box-primary'>
                                <div class='box-header'>
                                <?php
									$gsno=checkNoOfGsolution($gid);
										echo"
                                    <h3 class='box-title'>Reply Grievance(s)-".$gsno['no']."</h3>
                                </div><!-- /.box-header -->
                               
                                    <div class='box-body'>";
                                        
                                        
										
										if($gsno['no']>0)
										{
                                        echo"
										
                                        <table class='table table-bordered'>
                                        <tr>
                                            <th>Message</td>
                                            <th>Date & Time</th>
                                        </tr>";
										$allReply=fetchAllgSolution($gid);
                                        foreach ($allReply as $reply){
										echo"
                                        <tr>
                                            <td>".$reply['ans']."</td>
                                            <td>".date( "j M, Y", strtotime($reply['date']))." | ".date( "h:i:s A", strtotime($reply['date']))."</td>
                                        </tr>";
										}
										echo "
											</table>";
										}
										else
										{
										echo"
											<div class='alert alert-danger alert-dismissable'>
                                        <i class='fa fa-ban'></i>
                                       
                                        <b>Alert!</b> No message reply to this grievance.
                                    </div>";
										}
										?>
                                    </div><!-- /.box-body -->

                                    <div class='box-footer'>
                                    </div>
                                </form>
                            </div><!-- /.box -->
							</div>
                         
                         
                    </div>
                    <!-- /.row -->
                    

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
<!-- COMPOSE MESSAGE MODAL -->
        <div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-envelope-o"></i> Compose New Message</h4>
                    </div>
                    <?php echo "<form action= '".$_SERVER['PHP_SELF']."?gid=".$gid."' method='post'>"; ?>
					<?php echo "<input type='hidden' name='gid' value='".$gid."'>"; ?>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Email TO :</span>
                                    <?php echo "<input name='email_to' type='text' class='form-control' disabled='' value='".$email."'>"; ?>
                                    <?php echo "<input name='email_to' type='hidden' class='form-control'  value='".$student['email']."'>"; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Mobile TO :</span>
                                    <?php echo "<input name='mobile_to' type='text' class='form-control' disabled='' value='".$enquiry['mobile']."'>"; ?>
                                    <?php echo "<input name='mobile_to' type='hidden' class='form-control' value='".$enquiry['mobile']."'>"; ?>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea name="ans" id='message' class="form-control" placeholder="Write Grievance Solution ..." style="height: 120px;"></textarea>
                            </div>
                            <div>
											<p id='sms-counter'>
                                            <span class='remaining'></span>/<span class='messages'></span>
                                            </p>
											</div>

                        </div>
                        <div class="modal-footer clearfix">

                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>

                            <button type="submit" class="btn btn-primary pull-left"><i class="fa fa-envelope"></i> Reply Grievance</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- add new calendar event modal -->


       <!-- jQuery 2.0.2 -->
        <script src="js/jquery.min.js"></script>
       <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
<script type='text/javascript' src='js/sms_counter.min.js'></script>
	
	<script>
		$('#message').countSms('#sms-counter');
	</script>

    </body>
</html>