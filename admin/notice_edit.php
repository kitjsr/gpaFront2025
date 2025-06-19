<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
$id=$_GET['id'];
$singleNotice=fetchSingleNotice($id);

//Forms posted
if(!empty($_POST)) {	
	///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d  h:i:s A");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="Edit Notice ".$id."";
$saveRecord=addUserRecord($user, $ip, $browser, $pageName, $user_activity, $date);
/////////////////////////////////////////////////////////////////////////////////
	//Update Notice Title
	if(!empty($_POST['title_new'])) {
			
		if ($singleNotice['title'] != $_POST['title_new']){
		$title_new = trim($_POST['title_new']);
			
			//Validate Notice Title
			if (minMaxRange(1, 100, $title_new)){
				$errors[] = lang("TITLE_CHAR_LIMIT", array(1, 100));	
			}
			else {
				if (updateNoticeTitle($id, $title_new)){
					$successes[] = lang("TITLE_UPDATED", array($title_new));
					$singleNotice=fetchSingleNotice($id);
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
			
		}
		else {
			$title_new = $singleNotice['title'];
		}
			
	}
	//Update Notice
	if(!empty($_POST['notice_new'])) {
			
		if ($singleNotice['notice'] != $_POST['notice_new']){
		$notice_new = trim($_POST['notice_new']);
			
				if (updateNotice($id, $notice_new)){
					$successes[] = lang("NOTICE_UPDATED");
					$singleNotice=fetchSingleNotice($id);
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			
		}
		else {
			$notice_new = $singleNotice['notice'];
		}
			
	}
	//Update Notice
	if(!empty($_POST['home_new'])) {
			
		if ($singleNotice['home'] != $_POST['home_new']){
		$home_new =$_POST['home_new'];
			
				if (updateHome($id, $home_new)){
					$successes[] = lang("DISPLAY_ON_HOME_UPDATED");
					$singleNotice=fetchSingleNotice($id);
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			
		}
		else {
			$home_new = $singleNotice['home'];
		}
	}
	//Update New Icon Display
	if(!empty($_POST['new_new'])) {
			
		if ($singleNotice['new'] != $_POST['new_new']){
		$new_new = $_POST['new_new'];
			//echo $new_new;
				if (updateNew($id, $new_new)){
					$successes[] = lang("NEW_ICON_SETTING_UPDATED");
					$singleNotice=fetchSingleNotice($id);
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			
		}
		else {
			$new_new = $singleNotice['new'];
		}
	}
}
$new=$singleNotice['new'];
$home=$singleNotice['home'];

if($new==1)
{
	$selectNew="<label>
                                            <input type='radio' name='new_new' value='1' class='flat-red' checked/> Yes
                                        </label>
                                        <label>
                                            <input type='radio' name='new_new' value='2' class='flat-red'/> No
                                        </label>";
}
else {
	$selectNew="<label>
                                            <input type='radio' name='new_new' value='1' class='flat-red' /> Yes
                                        </label>
                                        <label>
                                            <input type='radio' name='new_new' value='2' class='flat-red' checked/> No
                                        </label>";
}
if($home==1)
{
	//$selectHome="<input name='home_new' type='radio' value='1' checked='checked' />Yes <input name='home_new' type='radio' value='2' />No";
	$selectHome="<label>
                                            <input type='radio' name='home_new' value='1' class='flat-red' checked/> Yes
                                        </label>
                                        <label>
                                            <input type='radio' name='home_new' value='2' class='flat-red'/> No
                                        </label>";
}
else {
	$selectHome="<label>
                                            <input type='radio' name='home_new' value='1' class='flat-red' /> Yes
                                        </label>
                                        <label>
                                            <input type='radio' name='home_new' value='2' class='flat-red' checked/> No
                                        </label>";
}
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
			jQuery('#formID1').validationEngine();
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
                        Edit Notice
                        <small>Notice</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Notice</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <?php
				echo resultBlock($errors,$successes);
				echo"
				<form action='".$_SERVER['PHP_SELF']."?id=".$id."' method='post' id='formID'>
				<div class='col-md-8'>
                            <!-- general form elements -->
                            <div class='box box-primary'>
                                <div class='box-header'>
                                    <h3 class='box-title'>Edit Notice Details</h3>
                                </div><!-- /.box-header -->
                                
                                    <div class='box-body'>
                                        <div class='form-group'>
                                            <label for='eventName'>Notice Title</label>
                                            <input type='text' name='title_new' value ='".$singleNotice['title']."' class='form-control validate[required] text-input'  placeholder='Enter Notice Title'>
                                        </div>
                                        <div class='form-group'>
                                            <label for='eventType'>Notice Details</label>
                                            <div class='box-body pad'>
		<textarea id='editor1' name='notice_new' rows='10'cols='80'>".$singleNotice['notice']."
                                        </textarea>  </div>
                                        </div>
										
										<div class='form-group'>  
										<label for='eventType'>Show on Home Page </label>                                  
                                        ".$selectHome."
                                        
                                    	</div>
										
										<div class='form-group'>  
										<label for='eventType'>Show New Icon </label>                                  
                                        ".$selectNew."
                                        
                                    	</div>
										
										<div class='box-footer'>
                                        <button type='submit' class='btn btn-primary'>Update</button>
                                    </div>
										
									</div>
								</div>
							</div>
		
				
			
</form>";
			?>
            </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        

        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
          
        <script src="js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(function() {
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('editor1');
                //bootstrap WYSIHTML5 - text editor
                $(".textarea").wysihtml5();
            });
        </script>     

    </body>
</html>