<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$allBranch=fetchAllBranch();
$sid=$_GET['sid'];
$app=fetchAdmAppReviewDetails($sid);
if(!empty($_POST)) {
			$sid = trim($_POST['sid']);
			$branchcode = trim($_POST['branch_code']);
			$idtype = trim($_POST['idtype']);
			$idno = trim($_POST['idno']);
			//Validate request

			$errors = array();
			if($branchcode == "")
			{
				$errors[] = lang("PLEASE_SELECT_BRANCH");
			}
			if(!empty($_POST['prog_code']))
			{
				$progcode = trim($_POST['prog_code']);
				if($progcode == "")
				{
					$errors[] = lang("PLEASE_SELECT_PROGRAM");
				}
			}
			if(empty($_POST['prog_code']))
			{
				$errors[] = lang("PLEASE_SELECT_PROGRAM");
			}
			if(!empty($_POST['batch_id']))
			{
				$batchcode = trim($_POST['batch_id']);
				if($batchcode == "")
				{
					$errors[] = lang("PLEASE_SELECT_BATCH");
				}
			}
			if(empty($_POST['batch_id']))
			{
				$errors[] = lang("PLEASE_SELECT_BATCH");
			}
			if($idtype == "")
			{
					$errors[] = lang("PLEASE_CHOOSE_ID_TYPE");
			}
			if($idno == "")
			{
					$errors[] = lang("PLEASE_ENTER_ID_NO");
			}
			if(count($errors) == 0)
			{	
				$addDetails=addAdmADetails($sid, $branchcode, $progcode, $batchcode, $idtype, $idno);
				
					//$successes[] = lang("PERSONAL_DETAILS_SAVE_SUCCESSFUL");
					header("Location: upload_photo.php?sid=".$sid."");
					die();
			}
			
		}

require_once("models/header.php");


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
<script>
$(document).ready(function(){
$("select#drop1").change(function(){

	var branch_id =  $("select#drop1 option:selected").attr('value'); 
// alert(branch_id);	
	$("#program").html( "" );
	$("#trainer").html( "" );
	if (branch_id.length > 0 ) { 
		
	 $.ajax({
			type: "POST",
			url: "fetch_program_for_trainee.php",
			data: "branch_id="+branch_id,
			cache: false,
			beforeSend: function () { 
				$('#program').html('<img src="loader.gif" alt="" width="24" height="24">');
			},
			success: function(html) {    
				$("#program").html( html );
			}
		});
	} 
});
});
</script>
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
                            <img src="img/avatar2.png" class="img-circle" alt="User Image" />
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
                        Admission Details
                        <small>Student Registration</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="account.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#"><i class="fa fa-file"></i> Student Registration</a></li>
                        <li class="active">Admission Details</li>
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
                    	<div class="stepwizard">
    						<div class="stepwizard-row">
        						<div class="stepwizard-step">
            					<button type="button" class="btn btn-default btn-circle">1</button>
            					<p>Personal Details</p>
        						</div>
        						<div class="stepwizard-step">
            					<button type="button" class="btn btn-primary btn-circle">2</button>
            					<p>Admission Details</p>
        						</div>
        						<div class="stepwizard-step">
            					<button type="button" class="btn btn-default btn-circle">3</button>
            					<p>Upload Photo</p>
        						</div>
                                <div class="stepwizard-step">
            					<button type="button" class="btn btn-default btn-circle" disabled="disabled">4</button>
            					<p>Review/Finalize</p>
    						</div>
						</div>
					</div>
                    
                    <!-- top row -->
                    <div class="row col-xs-12">
                        
                          <?php
						echo resultBlock($errors,$successes);
					echo"
						<form action='".$_SERVER['PHP_SELF']."?sid=".$sid."' method='post' id='formID'>
						<input type='hidden' name='sid'  value='".$sid."'>
						<div class='col-md-12'>
                            <!-- general form elements -->
                            <div class='box box-primary'>
                                <div class='box-header'>
                                    <h3 class='box-title'>Admission Details</h3>
                                </div><!-- /.box-header -->
                                
                                    <div class='box-body col-md-12' style='background:#FFF !important'>
									<div class='col-md-6'>
                                        <div class='form-group'>
                                            <label for='section'>Branch Code</label>
											<select class='form-control validate[required]' name='branch_code' id='drop1'>
                                            	<option value=''>--- Choose Branch ---</option>";
												//Display list of branch
												foreach ($allBranch as $branch) {
												echo "<option value='".$branch['id']."'>BR - ".str_pad($branch['id'], 4, '0', STR_PAD_LEFT)." (".$branch['name'].")</option>";
												}
                  								echo"
											</select>
                                        </div>
										
										<div id='program'></div> 
										
										<div id='batch'></div>
										
                                        </div><!-- col-md-6 -->
										
										<div class='col-md-6'>
										
										<div class='form-group'>
                                            <label for='section'>ID Type</label>
                                            <select class='form-control validate[required]' name='idtype'>
                                                ";
												if($app['idtype']==null)
												{
													echo"<option value=''>--- Select ID Type ---</option>";
												}
												if($app['idtype']!=null)
												{
													echo"<option value='".$app['idtype']."'>".$app['idtype']."</option>";
												}
												echo"
												<option value='AADHAR CARD'>AADHAR CARD</option>
												<option value='VOTER ID CARD'>VOTER ID CARD</option>
												<option value='BANK PASSBOOK'>BANK PASSBOOK</option>
												<option value='RASHAN CARD'>RASHAN CARD</option>
												<option value='PASSPORT'>PASSPORT</option>
                                            </select>
                                        </div>
										<div class='form-group'>
                                            <label for='section'>ID Serial No.</label> ";
												if($app['idno']==null)
												{
													echo"<input type='text' name='idno' class='form-control validate[required]' placeholder='Serial No. of Identity Card'>";
												}
												if($app['idno']!=null)
												{
													echo"<input type='text' name='idno' class='form-control validate[required]' placeholder='Serial No. of Identity Card' value='".$app['idno']."'>";
												}
												echo"
                                            
                                        </div>
										
										</div><!-- col-md-6 -->
										
										
                                        </div>

										
										<div class='box-footer col-md-12'>
                                        <button type='submit' class='btn btn-primary'>Save &amp; Continue</button>
                                    	</div>
										
									</div>
								</div>
							</div>
							</form>
							";
						
					?>
                    </div>
                    <!-- /.row -->
                    

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->


      
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- InputMask -->
        <script src="js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
        <script src="js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
        <script src="js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
        
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

        

        <!-- Page script -->
        <script type="text/javascript">
            $(function() {
                //Datemask dd/mm/yyyy
                $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                //Datemask2 mm/dd/yyyy
                $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
                //Money Euro
                $("[data-mask]").inputmask();

                

                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                    checkboxClass: 'icheckbox_minimal',
                    radioClass: 'iradio_minimal'
                });
                //Red color scheme for iCheck
                $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                    checkboxClass: 'icheckbox_minimal-red',
                    radioClass: 'iradio_minimal-red'
                });
                //Flat red color scheme for iCheck
                $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                    checkboxClass: 'icheckbox_flat-red',
                    radioClass: 'iradio_flat-red'
                });

                
            });
        </script>

    </body>
</html>