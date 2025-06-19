<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
if(!empty($_POST)){
    //echo gettype($_POST['date']);
    $mdate=date('Y-m-d',strtotime($_POST['date']));
   // echo $mdate;
    // gettype($mdate);
    $allFee=fetchAllStudentFee($mdate);
    
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
                        Fee Collection
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="account.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Fee Collection</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
					<?php echo resultBlock($errors,$successes); ?>
					
                    <!-- top row -->
                    <div class="row">
                        <div class="col">
                            <form method="post" action=
            "<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]);?>">
                                <label>Date</label>
                                <input type='date' name='date'/>
                                <input type='submit' value='View Report'/>
                            </form>
                        </div><!-- /.col -->
                    </div>
                    <!-- /.row -->
					
                    <!-- top row -->
                    <div class="row col-xs-12">
                        <div class='box'>
                                <div class='box-header'>
                                    <h3 class='box-title'>All fee collection details available here</h3>                                    
                                </div>
                                <div class='box-body table-responsive'>
                                <div class='table-toolbar'>
									<div class='btn-group'>
										<a class='btn  btn-primary' href='adm_report_print.php' target='_blank' ><i class='fa fa-print'></i>  Print</a>
									</div>
									
									</div>
                                    <?php
									echo"
                                    <table id='example1' class='table table-bordered table-striped'>
                        	<thead>
                            	<th style='text-align:left;'>Sl. No.</th>
                            	<th style='text-align:left;'>Name</th>
                            	<th style='text-align:left;'>Father Name</th>
								<th style='text-align:center;'>Branch</th>
								<th style='text-align:center;'>PCECE Roll</th>
                            	<th style='text-align:left;'>CML RANK</th>
                            	<th style='text-align:left;'>CAT</th>
                            	<th style='text-align:center;'>Adm Date</th>
                            	<th style='text-align:center;'>Mobile</th>
                            </thead>
                            <tbody>
                            ";
                            $sl=0;
							//Display list of pages
							foreach ($allFee as $row) {
						    $sl++;
							echo "
								<tr>
									<td style='text-align:left;'>".$sl."</td>
									<td style='text-align:left;'>".$row['name']."</td>
									<td style='text-align:left;'>".$row['father_name']."</td>
									<td style='text-align:center;'>".branch($row['branch'])."</td>
									<td style='text-align:center;'>".$row['broll']."</td>
									<td style='text-align:center;'>".$row['roll']."</td>
									<td style='text-align:center;'>".category($row['category'])."</td>
									<td style='text-align:center;'>".$row['txndate']."</td>
									<td style='text-align:center;'>".$row['mobile']."</td>
									
									
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

       

       <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
   
		 
        <!-- page script -->
        <script type="text/javascript">
           
			$(document).ready(function() {
    $('#example1').DataTable( {
        order: [[ 8, 'desc' ]]
    } );
} );
        </script>
       
        
      

    </body>
</html>