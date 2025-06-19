<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d  h:i:s A");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="User Setting";
$saveRecord=addUserRecord($user, $ip, $browser, $pageName, $user_activity, $date);
/////////////////////////////////////////////////////////////////////////////////
//Prevent the user visiting the logged in page if he is not logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }
/*
if(isset($_POST['submit'])){
    // File upload configuration
    $targetDir = "uploads/";
    $allowTypes = array('jpg','png','jpeg','gif');
    
        $image_name = $_FILES['photo']['name'];
        $tmp_name   = $_FILES['photo']['tmp_name'];
        $size       = $_FILES['photo']['size'];
        $type       = $_FILES['photo']['type'];
        $error      = $_FILES['photo']['error'];
        
        // File upload path
        $fileName = basename($_FILES['photo']['name']);
        $targetFilePath = $targetDir . $fileName;
        
        // Check whether file type is valid
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        if(in_array($fileType, $allowTypes)){    
            // Store images on the server
            if(move_uploaded_file($_FILES['photo']['tmp_name'],$targetFilePath)){
                //$images_arr[] = $targetFilePath;
            }
        }
    }
*/
require_once("models/header.php");
?>
      <!-- jQuery 2.0.2 -->
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function (e) {
	$("#photo").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "upload_photo.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
			$("#photoLayer").html(data);
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
	$("#sign").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "upload_sign.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
			$("#signLayer").html(data);
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
	$("#thumb").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "upload_thumb.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
			$("#thumbLayer").html(data);
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
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
                        <i class="fa fa-upload"></i> Uploads
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="account.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><i class="fa fa-upload"></i> Uploads</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Small boxes (Stat box) -->
                    

                    <!-- top row -->
                    <div class="row">
                        <div class="col-xs-12 connectedSortable">
                            
                        </div><!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row col-xs-12">
                    <?php
					echo resultBlock($errors,$successes);
					echo"
					<div class='col-md-4'>
					<!-- general form elements -->
                            <div class='box box-primary'>
                                <div class='box-header'>
                                    <h3 class='box-title'><i class='fa fa-upload'></i> Upload Photo</h3>
									
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                    <div class='box-body'>
									<div class='row'>
									<div class='callout callout-info'>
									<ul>
										<li>Format : JPG/JPEG/PNG</li>
										<li>Dimensions : 200px X 230px (W X H)</li>
										<li>Size : Max 1MB</li>
									</ul>
									</div>
									</div>
									<form name='photo' id='photo' action='upload_photo.php' method='post'>
									<input type='hidden' name='mobile' value='".$loggedInUser->username."'>
										<div class='form-group'>
                                            <label for='password'>Photo</label>
                                            <input type='file' name='photo' class='form-control' style='padding-bottom:40px;' />
                                        </div>
										<div id='photoLayer' class='row' style='padding-left:15px'>";
                                         if(!empty($student['photo'])){
											echo"<img src='uploads/".$student['photo']."' class='img-rounded img-responsive' style='margin:0 auto !important'>"; 
										 }
										else{
											echo"<img src='img/noimage.jpg' class='img-rounded img-responsive' style='margin:0 auto !important'>";
										}
                                        echo"</div>

									</div><!-- /.box-body -->

                                    <div class='box-footer'>
                                        <button type='submit' class='btn btn-primary'>Update</button>
                                    </div>
                                </form>
                            </div><!-- /.box -->
</div>";
						echo"
					<div class='col-md-4'>
					<!-- general form elements -->
                            <div class='box box-primary'>
                                <div class='box-header'>
                                    <h3 class='box-title'>Upload Sign</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                    <div class='box-body'>
									<div class='row'>
									<div class='callout callout-info'>
									<ul>
										<li>Format : JPG/JPEG/PNG</li>
										<li>Dimensions : 250px X 110px (W X H)</li>
										<li>Size : Max 0.5MB</li>
									</ul>
									</div>
									</div>
										<form name='sign' id='sign' action='upload_sign.php' method='post'>
										<input type='hidden' name='mobile' value='".$loggedInUser->username."'>
										<div class='form-group'>
                                            <label for='sign'>Sign</label>
                                            <input type='file' name='sign' class='form-control' style='padding-bottom:40px;' />
                                        </div>
										<div id='signLayer' class='row' style='padding-left:15px'>";
                                         if(!empty($student['sign'])){
											echo"<img src='uploads/".$student['sign']."' class='img-rounded img-responsive' style='margin:0 auto !important'>"; 
										 }
										else{
											echo"<img src='img/noimage.jpg' class='img-rounded img-responsive' style='margin:0 auto !important'>";
										}
                                        echo"
                                        </div>

									</div><!-- /.box-body -->

                                    <div class='box-footer'>
                                        <button type='submit' class='btn btn-primary'>Update</button>
                                    </div>
                                </form>
                            </div><!-- /.box -->
</div>";
						echo"
					<div class='col-md-4'>
					<!-- general form elements -->
                            <div class='box box-primary'>
                                <div class='box-header'>
                                    <h3 class='box-title'>Upload Thumb</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                    <div class='box-body'>
									<div class='row'>
									<div class='callout callout-info'>
									<ul>
										<li>Format : JPG/JPEG/PNG</li>
										<li>Dimensions : 250px X 110px (W X H)</li>
										<li>Size : Max 0.5MB</li>
									</ul>
									</div>
									</div>
										<form name='thumb' id='thumb' action='upload_thumb.php' method='post'>
										<input type='hidden' name='mobile' value='".$loggedInUser->username."'>
										<div class='form-group'>
                                            <label for='thumb'>Thumb</label>
                                            <input type='file' name='thumb' class='form-control' style='padding-bottom:40px;' />
                                        </div>
										<div id='thumbLayer' class='row' style='padding-left:15px'>";
                                         if(!empty($student['thumb'])){
											echo"<img src='uploads/".$student['thumb']."' class='img-rounded img-responsive' style='margin:0 auto !important'>"; 
										 }
										else{
											echo"<img src='img/noimage.jpg' class='img-rounded img-responsive' style='margin:0 auto !important'>";
										}
                                        echo"
                                        </div>

									</div><!-- /.box-body -->

                                    <div class='box-footer'>
                                        <button type='submit' class='btn btn-primary'>Update</button>
                                    </div>
                                </form>
                            </div><!-- /.box -->
</div>";
?>
					</div><!-- /.main area-->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


  
        <!-- jQuery UI 1.10.3 -->
<script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
<script src="js/bootstrap.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
<script src="js/AdminLTE/app.js" type="text/javascript"></script>
        
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="js/AdminLTE/dashboard.js" type="text/javascript"></script>        

</body>
</html>

