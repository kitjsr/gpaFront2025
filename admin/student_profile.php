<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");

/**
 * Simple PHP age Calculator
 * 
 * Calculate and returns age based on the date provided by the user.
 * @param   date of birth('Format:yyyy-mm-dd').
 * @return  age based on date of birth
 */
date_default_timezone_set('Asia/Calcutta');
function ageCalculator($dob){
	if(!empty($dob)){
		$birthdate = new DateTime($dob);
		date_default_timezone_set("Asia/Kolkata");
		$date=date("Y-m-d");
		$today   = new DateTime($date);
		$age = $birthdate->diff($today)->y;
		return $age;
	}else{
		return 0;
	}
}
//$dob = '1992-03-18';
//echo ageCalculator($student['dob']);



	
	


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
                        Student Profile
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="account.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><i class="fa fa-user"></i> Student Profile</li>
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

	
	/////
	list($v1, $v2,$v3)  = admType($student['adm_type'],$student['adm_date']); 

//will print out values from someFunc
//echo "$var1 $var2"; 					
	
	
	
                    	
						echo"
                              <div class='box-body table-responsive no-padding'>  
								<table class='table table-responsive no-padding'>

<tbody>
	
	<tr>
		<th colspan='2' class='title'>:: Personal Details</th>
		<td colspan='1' rowspan='7' style='text-align:center !important; vertical-align:middle !important;'>";
						if(!empty($student['photo'])){
											echo"<img width='200px' height='230px' src='uploads/".$student['photo']."' class='img-rounded img-responsive' style='margin:0 auto !important'>"; 
										 }
										else{
											echo"<img src='img/noimage.jpg' class='img-rounded img-responsive'>";
										}
						echo"</td>
		<th style='text-align:center;'>College ID</th>
	</tr>
	<tr>
		<td>Name</td>
		<td>".$student['name']."</td>
		<td rowspan='3' style='text-align:center; vertical-align:middle;'><img alt='' src='barcode.php?codetype=Code39&size=40&text=".str_pad($student['cid'], 10, '0', STR_PAD_LEFT)."' /></br>".str_pad($student['cid'], 10, '0', STR_PAD_LEFT)."</td>
		
	</tr>
	<tr>
		<td>Father's Name</td>
		<td>".$student['father_name']."</td>
		
	</tr>
	<tr>
		<td>Mother's Name</td>
		<td>".$student['mother_name']."</td>
	</tr>
	<tr>
		<td>Date of Birth</td>
		<td>".date( "j M, Y", strtotime($student['dob']))."</td>
	</tr>
	<tr>
		<td>Gender</td>
		<td>".gender($student['gender'])."</td>
		<td rowspan='2' style='text-align:center; vertical-align:middle;'>
			<a class='btn btn-info' href='student_print.php?mobile=".$student['mobile']."' target='_blank'><i class='fa fa-print'></i> Print</a>
		</td>
	</tr>
	<tr>
		<td>Age</td>
		<td>".ageCalculator($student['dob'])." Years</td>
		
	</tr>
	<tr>
		<th colspan='4' class='title'>:: Admission Details</th>
	</tr>
	<tr>
		<td>Session</td>
		<td>".date( "Y", strtotime($v2))."-".date( "Y", strtotime($v3))."</td>
		<td>Branch</td>
		<td>".branch($student['branch'])."</td>
	</tr>
	<tr>
		<td>Board Roll No.</td>
		<td>".$student['broll']."</td>
		<td>Class Roll No.</td>
		<td>".$student['roll']."</td>
	</tr>
	<tr>
		<td>Semester</td>
		<td>".$student['sem']."</td>
		<td>Category</td>
		<td>".category($student['category'])."</td>
	</tr>
	<tr>
		<td>Admission Type</td>
		<td>".$v1."</td>
		<td>TFW</td>
		<td>".tfw($student['tfw'])."</td>
	</tr>
	<tr>
		<th colspan='4' class='title'>:: Permanent Address</th>
	</tr>
	<tr>
		<td>At/Vill.</td>
		<td>".$student['at']."</td>
		<td>Post</td>
		<td>".$student['post']."</td>
	</tr>
	<tr>
		<td>City</td>
		<td>".$student['city']."</td>
		<td>Dist.</td>
		<td>".$student['dist']."</td>
		
	</tr>
	<tr>
		<td>State</td>
		<td>".$student['state']."</td>
		<td>PIN</td>
		<td>".$student['pin']."</td>
	</tr>
	<tr>
		<th colspan='4' class='title'>:: Correspondence Address</th>
	</tr>
	<tr>
		<td>At/Vill.</td>
		<td>".$student['cat']."</td>
		<td>Post</td>
		<td>".$student['cpost']."</td>
	</tr>
	<tr>
		
		<td>City</td>
		<td>".$student['ccity']."</td>
		<td>Dist.</td>
		<td>".$student['cdist']."</td>
	</tr>
	<tr>
		<td>State</td>
		<td>".$student['cstate']."</td>
		<td>PIN</td>
		<td>".$student['cpin']."</td>
	</tr>
	<tr>
		<th colspan='4' class='title'>:: Contact Details</th>
	</tr>
	<tr>
		<td>Mobile</td>
		<td>".$student['mobile']."</td>
		<td>E-Mail</td>
		<td>".$student['email']."</td>
	</tr>";
						if($student['sign']!=null &&$student['thumb']!=null){
						echo"
	<tr>
		<td colspan='2'><img src='uploads/".$student['sign']."' alt='Signature' width='250px' height='110px'></td>
		<td colspan='2'><img src='uploads/".$student['thumb']."' alt='Thumb Impression' width='250px' height='110px'></td>
	</tr>
	";	
						}
						
						echo"
						
</tbody>
</table>
</div>";

?>
								
    </div>
                    <!-- /.row -->
                    

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar app modal -->


       <!-- jQuery 2.0.2 -->
        <script src="js/jquery.min.js"></script>
       <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                
            });
        </script>

    </body>
</html>