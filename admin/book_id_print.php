<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");

///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d  h:i:s A");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="Library";
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
                        <i class="fa fa-book"></i> Book Id
                        <small>Print</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="account.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="print.php"><i class="fa fa-print"></i> Print</a></li>
                        <li><a href="barcode_print.php"><i class="fa fa-barcode"></i> Barcode</a></li>
                        <li class="active"><i class="fa fa-book"></i> Book</li>
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
                        
                          <?php
						echo resultBlock($errors,$successes);
						echo"
						<div class='col-md-6'>
                            <!-- general form elements -->
                            <div class='box box-primary'>
                                <div class='box-header'>
                                    <h3 class='box-title'>Book Id Barcode Print</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form role='form' action='book_id_print2.php' method='post' id='formID'>
                                    <div class='box-body'>
                                        <div class='form-group col-md-6'>
                                            <label for='isbn'>Book Id(Min)</label>
											<div class='input-group'>
											<div class='input-group-addon'>
                                                <i class='fa fa-barcode'></i>
                                            </div>
                                            <input type='text' name='libid1' class='form-control validate[required,custom[integer,minSize[10],maxSize[10],min[1]] text-input'  placeholder='Enter Book Id' data-inputmask='\"mask\": \"9999999999\"' data-mask>
											</div>
                                        </div>
                                        <div class='form-group col-md-6'>
                                            <label for='isbn'>Book Id(Max)</label>
											<div class='input-group'>
											<div class='input-group-addon'>
                                                <i class='fa fa-barcode'></i>
                                            </div>
                                            <input type='text' name='libid2' class='form-control validate[required,custom[integer,minSize[10],maxSize[10],min[1]] text-input'  placeholder='Enter Book Id' data-inputmask='\"mask\": \"9999999999\"' data-mask>
											</div>
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class='box-footer'>
                                        <button type='submit' class='btn btn-primary'>Submit</button>
                                    </div>
                                </form>
                            </div><!-- /.box -->
							</div>
							
							";
						
					?>
                            
                    </div>
                    <!-- /.row -->
                    

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

       
       <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
        <!-- InputMask -->
        <script src="js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
        <!-- Page script -->
        <script type="text/javascript">
            $(function() {
                
                $("[data-mask]").inputmask();

          
            });
			
        </script>
        

    </body>
</html>