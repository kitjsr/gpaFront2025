<?php
$alert="";
if(!empty($_POST))
{
		$mobile		= $_POST['mobile'];
		
		$error="";
        if(empty($mobile)){    
            $error.="<li>Please Enter Mobile.</li>";
        }
		
	
		if($error!=null)
		{
			$alert="<div class='col-md-12'>
					<div class='alert alert-danger'>
                      <b>Alert!</b> <br>
					  <ul>
					  	".$error."
					</ul>
                 </div>
				 </div>";
		}
		
		else{
				//////////////////////
				include("include/setting.php");
				///////////////// USER'S ACTIVITY RECORD /////////////
				$gstatus=mysql_query("SELECT * FROM grievances WHERE mobile=".$mobile."", $db_conn);
			
				$now=1;
			///////////////
			
			////////////////////
			
            
		}
}
?>       
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="Government Polytechnic, Adityapur is among one of the 13 Polytechnics in Jharkhand founded to groom the technical manpower and contribute to our state and country through excellence..." />
<meta name="keywords" content="polytechnic, government, adityapur, jamshedpur, tata, tatanagar, best, top, engineering, diploma, skill, development, state, jharkhand, higher, technical, education, course, excellence, engg, adityapur, aiada, seraikella, kharsawan, india" />
<meta name="author" content="metatags generator">
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="3 month">
<title>Grievance | Government Polytechnic Adityapur| Jamshedpur | Jharkhand | 832109</title>
<meta name="google-site-verification" content="kNWVDOCYEP17bhOQzlmmI7hV-fSizHQQcPWVr1KEFbo" />
<meta name="msvalidate.01" content="1917F2FCC97BD98C375558BC098AE0D3" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <!--        <link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">-->


        <!--For Plugins external css-->
        <link rel="stylesheet" href="assets/css/plugins.css" />

        <!--Theme custom css -->
        <link rel="stylesheet" href="assets/css/style.css">

        <!--Theme Responsive css-->
        <link rel="stylesheet" href="assets/css/responsive.css" />
		   
        <script src="assets/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
		<link rel='stylesheet' href='http://admin.gpadp.org.in/css/validationEngine.jquery.css' type='text/css'/>
	 <!-- jQuery 2.0.2 -->
<script src="http://admin.gpadp.org.in/js/jquery.min.js"></script>

	<script src='http://admin.gpadp.org.in/js/jquery.validationEngine-en.js' type='text/javascript' charset='utf-8'>
	</script>
	<script src='http://admin.gpadp.org.in/js/jquery.validationEngine.js' type='text/javascript' charset='utf-8'>
	</script>
	<script>
		jQuery(document).ready( function() {
			// binds form submission and fields to the validation engine
			jQuery('#formID1').validationEngine();
		});
	</script>
    </head>
    <body data-spy="scroll" data-target="#main-navbar">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please upgrade your browser to improve your experience.</p>
        <![endif]-->
		
		
        <div id="menubar" class="main-menu">	
           
            <nav class="navbar navbar-default">
               <div class="container">
				<div class="col-md-12">
					<div class="col-md-3" style="text-align: right">
						<img src="img/jhlogo.png" class="logo">
					</div>
					<div class="col-md-9" style="text-align: left">
						<h2>Government Polytechnic Adityapur</h2>
						<p><b>Department of Higher, Technical Education &amp; Skill Development, Govt. of Jharkhand</b></p>
					</div>
				</div>
					
				
                               
				<!-- END MAIN NAVIGATION -->
			</div>
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
                        <ul class="nav navbar-nav navbar-left" style="margin-top:10px !important">
                            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
		                    <li><a href="about.php"><i class="fa fa-building"></i> About Us</a></li>
                        	<li><a href="admission.php"><i class="fa fa-file"></i> Admission</a></li>
                        	<li><a href="faculty.php"><i class="fa fa-user"></i> Faculties</a></li>
                        	<li><a href="notice.php"><i class="fa fa-file-pdf-o"></i> Notice</a></li>
                        	<li><a href="gallery.php"><i class="fa fa-camera"></i> Gallery</a></li>
							<li class="active"><a href="contact.php"><i class="fa fa-envelope"></i> Contact Us</a></li>

                        </ul>
                    </div><!-- /.navbar-collapse -->
                    
                </div><!-- /.container-fluid -->
				</div><!-- col-md-10 -->
            <div class="col-md-12" style="text-align: right">
           			<ul><?php
						include("include/setting.php");
							echo"This Site updated on: ".date( "j M, Y", strtotime($updateDetails['date']))."";
							?></ul>
           		</div>
            </nav>
        </div>

        <!-- Sections -->
        <section id="course" class="sections">
            <div class="container">

                <div class="row">
                    <div class="heading">
                        <div class="title text-center arrow-right">
                            <h4 class="">Grievance Status</h4>
                            <img class="hidden-xs" src="assets/images/right-arrow.png" alt="" />

                        </div>
                    </div>	


                    <!-- Example row of columns -->

                    <div class="portfolio-wrap">
						
						<?php
						echo $alert;
						echo"
					<div id='photoLayer'></div>		
				<form name='formID' action='".$_SERVER['PHP_SELF']."' method='post' id='formID1'>
					
					<div class='col-sm-12'>
						<div class='row'>
							<div class='col-sm-6 form-group'>
								<label>Mobile</label>
								<input class='form-control validate[required, custom[phone], minSize[10], maxSize[10]]' placeholder='Enter Mobile Number' name='mobile' data-prompt-position='bottomLeft' autocomplete='off' data-inputmask='\"mask\": \"9999999999\"' data-mask/>
							</div>
							
						</div>	
						
						<div>
							<input type='submit' class='btn btn-info' value='Submit'>
							<input type='reset' class='btn btn-danger' value='Reset'>
					</div>
						</div>";
						if($now==1)
						   {
							   $num_rows = mysql_num_rows($gststus);
							echo $num_rows;
			if($num_rows!=0)
			{
			echo "<table id='example1' class='table table-bordered table-striped table-hover'>
                        	<thead>
								<th style='text-align:center;'>ID</th>
								<th style='text-align:left;'>Grievance</th>
								<th style='text-align:center;'>Status</th>
								<th style='text-align:center;'>Date</th>
                                <th style='text-align:center;'><span class='glyphicon glyphicon-eye' aria-hidden='true'></span></th>
                            </thead>";
			while($row=mysql_fetch_array($gststus))
			{
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
			echo "</table>";
			}
			else
			{
				echo"<div class='alert alert-danger'>
							<strong>Alert!</strong> Grievance Status Not Found...
						</div>";
			}
						   }
						
						?>
                    </div>
                </div>
            </div>


            <!-- /container -->       
        </section>

        <div class="scroll-top">

            <div class="scrollup">
                <i class="fa fa-angle-double-up"></i>
            </div>

        </div>

        <!--Footer-->
        <footer id="footer" class="footer">
            <div class="container">

                <div class="row">
                    <div class="main-footer">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="footer-item">
                                <h2>GET IN TOUCH</h2>
                                <address>
					<strong>Government Polytechnic Adityapur</strong><br>
					 Adityapur Industrial Area<br>
					 Seraikella-Kharsawan, Jharkhand<br>
                     PIN - 832109 </address>
                           <p><i class="fa fa-phone"></i> <a href="tel:+916572383303">+91-657 2383303</a></p>
                           <p><i class="fa fa-envelope"></i> <a href="mailto:gpa2010@rediffmail.com">gpa2010@rediffmail.com</a></p>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="footer-item">
                                <h2>MENU ITEMS</h2>
                                <ul>
                                    <li><a href="admin/student_login.php" target="_blank">Student Panel</a></li>
									<li><a href="admin/login.php" target="_blank">Admin Panel</a></li>
									<li><a href="downloads.php">Downloads</a></li>
									<li><a href="disclaimer.php">Disclaimer</a></li>
									<li><a href="privacy_policy.php">Privacy Policy</a></li>
									<li><a href="return_policy.php">Return Policy</a></li>

                                </ul>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="footer-item">
                                <h2>VISITOR DETAILS</h2>
                                <?php
									date_default_timezone_set('Asia/Calcutta');
									$date=date("Y-m-d  h:i:s A");
									$ip = $_SERVER['REMOTE_ADDR'];
									$browser = $_SERVER['HTTP_USER_AGENT'];
									echo"<strong>Your IP</strong> - ".$ip."</br> <strong>Your Browser</strong> - ".$browser." </br> <strong>Today</strong> - ".$date."</br>";
									?>
									<div> <!-- Histats.com  START (html only)-->
								<a href="http://www.histats.com/viewstats/?act=2&sid=3655566" alt="page hit counter" target="_blank" >
								<embed src="http://s10.histats.com/601.swf"  flashvars="jver=1&acsid=3655566&domi=4"  quality="high"  width="110" height="30" name="601.swf"  align="middle" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" /></a>
                            		</div>
							</div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="footer-item">
                                <h2>IMPORTANT LINKS</h2>
                                <ul>
                                    <li><a href="http://www.mhrd.gov.in/" target="_blank">MHRD</a></li>
						<li><a href="http://www.aicte-india.org/" target="_blank">AICTE</a></li>
						<li><a href="http://www.jharkhand.gov.in/" target="_blank">Govt. of Jharkhand</a></li>
						<li><a href="http://www.jharkhand.gov.in/new_depts/scite/scite_fr.html" target="_blank">Dept. of Higher, Technical Education &amp; Skill Development</a></li>
						<li><a href="http://www.sbtejharkhand.nic.in/" target="_blank">SBTE Jhrakhand</a></li>

                                </ul>
                            </div>
                        </div>

                    </div>

                    <div class="socio-copyright">
						<div class="social">
                            
                        </div>
                        <p>Developed By <i class="fa fa-pencil"></i> <a target="_blank" href="tel:9470312947"> Kunal Mahto(PTL) </a></p>
                    </div>

                </div>	
            </div>

        </footer>

        <script src="assets/js/vendor/bootstrap.min.js"></script>

        <script src="assets/js/plugins.js"></script>
        <script src="assets/js/main.js"></script>
		<!-- InputMask -->
        <script src="http://admin.gpadp.org.in/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
        <script src="http://admin.gpadp.org.in/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
        <script src="http://admin.gpadp.org.in/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
		
<script type="text/javascript">
            $(function() {
                //Datemask dd/mm/yyyy
                $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                //Datemask2 mm/dd/yyyy
                $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
                //Money Euro
                $("[data-mask]").inputmask();


                
            });
        </script>
		
    </body>
</html>
