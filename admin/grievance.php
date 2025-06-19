<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
//Add New Notice
		if(!empty($_POST)) {
			$gtitle = trim($_POST['gtitle']);
			$g = trim($_POST['g']);
			date_default_timezone_set('Asia/Calcutta');
			$date=date("Y-m-d  h:i:s A");
			//Validate request
			$student=fetchSingleStudent($loggedInUser->username);
			$mobile=$student['mobile'];
			if($gtitle == "")
			{
				$errors[] = lang("ADD_G_TITLE");
			}
			if($g == "")
			{
				$errors[] = lang("ADD_G_DETAILS");
			}
			if(empty($errors)) {
				$successes[] = lang("G_ADD_SUCCESSFUL");
				$addg=addg($mobile, $gtitle, $g,$date);
				$allg=fetchAllg();
				//////////////////////
				$messageAdmin="Respected Sir! A Grievance receieved from Online Grievance System.";
				$messageStudent="Hi ".$loggedInUser->displayname."! Your Grievance received by Grievance Cell, Govt. Polytechnic, Adityapur. Your Grievance will solve shortly.";
				////////////////////////// MAIL - ADMIN ///////////////////////////////
				$subject = 'Grievance Application';
				$mail_toAdmin="kunalkumar1987@gmail.com,gpa2010@rediffmail.com";
				$from="contact@gpadp.org.in";

				$mail_statusAdmin = mail($mail_toAdmin, $subject, $messageAdmin,"From:".$from);
				////////////////////////// MAIL - STUDENT ///////////////////////////////	
				
				$mail_statusStudent = mail($loggedInUser->email, $subject, $messageStudent,"From:".$from);
				///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d  h:i:s A");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="Add Grievance";
$saveRecord=addUserRecord($user, $ip, $browser, $pageName, $user_activity, $date);
/////////////////////////////////////////////////////////////////////////////////
			
			}
		}
require_once("models/header.php");
$allg=fetchAllgStudent($loggedInUser->username);

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
echo "

<link rel='stylesheet' href='css/validationEngine.jquery.css' type='text/css'/>
	<script src='js/jquery.min.js' type='text/javascript'>
	</script>
	<script src='js/jquery.validationEngine-en.js' type='text/javascript' charset='utf-8'>
	</script>
	<script src='js/jquery.validationEngine.js' type='text/javascript' charset='utf-8'>
	</script>
	<script>
		jQuery(document).ready( function() {
			// binds form submission and fields to the validation engine
			jQuery('#formID').validationEngine();
		});
	</script>
	";

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
                        <i class='fa  fa-comments'></i> Grievance
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="account.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><i class='fa  fa-comments'></i> Grievance</li>
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
                        <div class='box'>
                                <div class='box-header'>
                                    <h3 class='box-title'>All Grievance Available Here</h3>   
									
                                </div>
								<div class='box-body table-responsive'>
                                <div class='table-toolbar'>
									<div class='btn-group'>
										<a class='btn  btn-primary' data-toggle='modal' data-target='#compose-modal'><i class='fa fa-plus'></i> Add New</a>
									</div>
									<div class='btn-group pull-right'>
										
										
									</div>
									</div>
                                <div class='box-body table-responsive no-padding'>
                                    <table id='example1' class='table table-bordered table-striped table-hover'>
                        	<thead>
								<th style='text-align:center;'>ID</th>
								<th style='text-align:left;'>Grievance</th>
								<th style='text-align:center;'>Status</th>
								<th style='text-align:center;'>Date</th>
                                <th style='text-align:center;'><span class='glyphicon glyphicon-eye' aria-hidden='true'></span></th>
                            </thead>
                            <tbody>
                            <?php
								echo resultBlock($errors,$successes);
							$gno=checkNoOfGrievance($student['mobile']);
							if($gno['no']>0)
							{
								foreach ($allg as $row){
									if($row['status']==1){
										$status=" <small class='label label-danger'><i class='fa fa-clock-o'></i>  Waiting</small>";
									}
									else{
										$status=" <small class='label label-success'><i class='fa fa-check-circle'></i>  Solved</small>";
									}
								echo"
                            	<tr>
                                	<td style='text-align:center;'>".str_pad($row['gid'], 10, '0', STR_PAD_LEFT)."</td>
									<td style='text-align:left;'>".$row['gtitle']."</td>
									<td style='text-align:center;'>".$status."</td>
									<td style='text-align:center;'>".date( "j M, Y", strtotime($row['date']))."</td>
									<td style='text-align:center;'><a onClick='return confirmSubmit()' href='grievance_solution.php?gid=".$row['gid']."'><span class='fa fa-eye' aria-hidden='true'></span> View</a></td>
                                </tr>";
								}
							}
							
							?>
                            </tbody>
                            <tfoot>
                                         
                                        </tfoot>
                                    </table>
                                </div>
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
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Grievance</h4>
                    </div>
                    <?php echo "<form action='".$_SERVER['PHP_SELF']."' method='post' id='formID'>
                        <div class='modal-body'>
                            			
				
                                        <div class='form-group'>
                                            <label for='eventName'>Grievance Title</label>
                                            <input type='text' name='gtitle' class='form-control validate[required] text-input'  placeholder='Enter Grievance Title'>
                                        </div>
                                        <div class='form-group'>
                                            <label for='eventType'>Grievance Details</label>
                                            <div class='box-body pad'>
												<textarea  name='g' class='form-control validate[required] text-input' >
                                        		</textarea>  
											</div>
                                        </div>
										
										
                        </div>
                        <div class='modal-footer clearfix'>

                            <button type='button' class='btn btn-danger' data-dismiss='modal'><i class='fa fa-times'></i> Discard</button>

                            <button type='submit' class='btn btn-primary pull-left'><i class='fa fa-plus'></i> Add</button>
                        </div>
                    </form>
					"; ?>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


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