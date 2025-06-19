<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
//Add New Notice
		if(!empty($_POST)) {
			$title = trim($_POST['title']);
			$home = trim($_POST['home']);
			$new = trim($_POST['new']);
			date_default_timezone_set('Asia/Calcutta');
			$date=date("Y-m-d h:i:s");
			
			$targetDir = "uploads/";
			$allowTypes = array('pdf','doc','docx');
    
        $image_name = $_FILES['notice']['name'];
        $tmp_name   = $_FILES['notice']['tmp_name'];
        $size       = $_FILES['notice']['size'];
        $type       = $_FILES['notice']['type'];
        $error      = $_FILES['notice']['error'];
		$fileinfo = @getimagesize($_FILES["notice"]["tmp_name"]);
    	$width = $fileinfo[0];
    	$height = $fileinfo[1];
		$file_ext	= substr($image_name, strrpos($image_name, '.')); //file extension
			
			$RandNumber   		= rand(0, 9999999999); //Random number to make each filename unique.
		$NewFileName = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower("notice"));
		$NewFileName = $NewFileName."_".$RandNumber.$file_ext;
        // File upload path
        $fileName = basename($_FILES['notice']['name']);
        $targetFilePath = $targetDir.$NewFileName;
        
        // Check whether file type is valid
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
			//Validate request

			if($title == "")
			{
				$errors[] = lang("ADD_TITLE");
			}
			else if($_FILES['notice']['size'] <= 0){
				$errors[] = lang("CHOOSE_NOTICE");
			}
			else if(!in_array($fileType, $allowTypes)){  
				$errors[] = lang("FILE_FORMAT_NOT_SUPPORTED");
			}
			else if($size > 5000000){
				$errors[] = lang("FILE_SIZE_ISSUE");
			}
			else {
				// Store images on the server
            if(move_uploaded_file($_FILES['notice']['tmp_name'],$targetFilePath)){
                $successes[] = lang("NOTICE_ADD_SUCCESSFUL");
				$addNotice=addNotice($title, $NewFileName, $home, $new, $date);
				///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d  h:i:s");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="Add Notice ".$title."";
$saveRecord=addUserRecord($user, $ip, $browser, $pageName, $user_activity, $date);
/////////////////////////////////////////////////////////////////////////////////
            }
				
			
			}
		}
require_once("models/header.php");
$allNotice=fetchAllNotice();

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
                        All Notice
                        <small>Notice</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="account.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#"><i class="fa fa-file"></i> Notice</a></li>
                        <li class="active">All Notice</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
					<?php echo resultBlock($errors,$successes); ?>
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
                                    <h3 class='box-title'>All notice details available here</h3>                                    
                                </div>
                                <div class='box-body table-responsive'>
                                <div class='table-toolbar'>
									<div class='btn-group'>
										<a class='btn  btn-primary' data-toggle='modal' data-target='#compose-modal'><i class='fa fa-plus'></i> Add New</a>
									</div>
									<div class='btn-group pull-right'>
										<button type='button' class='btn btn-primary'><i class='fa fa-gear'></i> Tools</button>
                                            <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>
                                                <span class='caret'></span>
                                                <span class='sr-only'>Toggle Dropdown</span>
                                            </button>
										<ul class='dropdown-menu pull-right'>
											<li><a href='print_notice.php' target='_blank' ><i class='fa fa-print'></i> Print</a></li>
											<li><a href='save_notice.php' target='_blank'><i class='fa fa-file-pdf-o'></i> Save as PDF</a></li>
											<li><a href='save_notice_excel.php' target='_blank'><i class='fa fa-file-excel-o'></i> Export to Excel</a></li>
										</ul>
									</div>
									</div>
                                    <?php
									echo"
                                    <table id='example1' class='table table-bordered table-striped'>
                        	<thead>
                            	<th>Title</th>
                                <th style='text-align:center'>File</th>
								<th style='text-align:center'>New</th>
                                <th style='text-align:center'>Home</th>
                                <th style='text-align:center'>Date</th>
                                <th style='text-align:center'></th>
                                <th style='text-align:center'></th>
                            </thead>
                            <tbody>
                            ";
							//Display list of pages
							foreach ($allNotice as $notice) {
							if($notice['new']==1)
							{
								$new="Yes";
							}
							else
							{
								$new="No";
							}
							if($notice['home']==1)
							{
								$home="Yes";
							}
							else
							{
								$home="No";
							}
							echo "
								<tr>
									<td style='text-align:left'>".$notice['title']."</td>
									<td style='text-align:center'>
									<a target='_blank' href='uploads/".$notice['notice']."' ><span class='glyphicon glyphicon-file' aria-hidden='true'></span> File</a>
									</td>
									<td style='text-align:center'>".$new."</td>
									<td style='text-align:center'>".$home."</td>
									<td style='text-align:center'>".date( "j M, Y", strtotime($notice['date']))."</td>
									<td style='text-align:center'>
									<a onClick='return confirmSubmit()' title='Edit'  href='notice_edit.php?id=".$notice['id']."' ><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a>
									</td>
									
									<td style='text-align:center'>
									<a onClick='return confirmSubmit()' title='Delete'  href='notice_delete.php?id=".$notice['id']."' ><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>
									</td>
								</tr>";
							}
							?>
                            </tbody>
                            
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
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Notice</h4>
                    </div>
                    <?php echo "<form action='".$_SERVER['PHP_SELF']."' method='post' id='formID' enctype='multipart/form-data'>
                        <div class='modal-body'>
                            			
				
                                        <div class='form-group'>
                                            <label for='eventName'>Notice Title</label>
                                            <input type='text' name='title' class='form-control validate[required] text-input'  placeholder='Enter Notice Title'>
                                        </div>
                                        <div class='form-group'>
                                            <label for='eventName'>Notice File</label>
                                            <input type='file' name='notice' class='form-control validate[required] text-input'  placeholder='Enter Notice File Link'>
                                        </div>
										
										<div class='form-group'>  
										<label for='eventType'>Show on Home Page </label>                                  
                                        <label>
                                            <input type='radio' name='home' value='1' class='flat-red' checked/> Yes
                                        </label>
                                        <label>
                                            <input type='radio' name='home' value='2' class='flat-red'/> No
                                        </label>
                                        
                                    	</div>
										
										<div class='form-group'>  
										<label for='eventType'>Show New Icon </label>                                  
                                        <label>
                                            <input type='radio' name='new' value='1' class='flat-red' checked/> Yes
                                        </label>
                                        <label>
                                            <input type='radio' name='new' value='2' class='flat-red'/> No
                                        </label>
                                        
                                    	</div>
										
										
			

                        </div>
                        <div class='modal-footer clearfix'>

                            <button type='button' class='btn btn-danger' data-dismiss='modal'><i class='fa fa-times'></i> Discard</button>

                            <button type='submit' class='btn btn-primary pull-left'><i class='fa fa-plus'></i> Add Notice</button>
                        </div>
                    </form>
					"; ?>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

       <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
        
        <script src="js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
		 
        <!-- page script -->
        <script type="text/javascript">
           
			$(document).ready(function() {
    $('#example1').DataTable( {
        order: [[ 3, 'desc' ]]
    } );
} );
        </script>
        <script type="text/javascript">
            $(function() {
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('editor1');
                //bootstrap WYSIHTML5 - text editor
                $(".textarea").wysihtml5();
            });
        </script> 
        
        <script LANGUAGE='JavaScript'>
function confirmSubmit()
{
var agree=confirm('Do you want to continue ?');
if (agree)
 return true ;
else
 return false ;
}
</script>

    </body>
</html>