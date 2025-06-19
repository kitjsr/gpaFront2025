<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
//Add New Book on Book List
		if(!empty($_POST)) {
			$cid= trim($_POST['cid']);
			$libid = trim($_POST['libid']);
			date_default_timezone_set('Asia/Calcutta');
			$date=date("Y-m-d  h:i:s A");
			//Validate request
			
			if($cid == "")
			{
				$errors[] = lang("ENTER_COLLEGE_ID");
			}
			//////// Check Student is Valid or Not
			elseif(!checkValidStudent($cid))
			{
				$errors[] = lang("INVALID_STUDENT");
			}
			if($libid == "")
			{
				$errors[] = lang("ENTER_BOOK_ID");
			}
			elseif(!checkBookLibraryAvailable($libid)){
				$errors[] = lang("INVALID_BOOK");
			}
			elseif(checkonBookStatus($libid))
			{
				if(!checkBookStatus($libid))
				{
					$errors[] = lang("BOOK_NOT_AVAILABLE");
				}
			}
			///////// Duplicate Entry Checking
			if(empty($errors)) {
				$successes[] = lang("BOOK_ISSUE_SUCCESSFUL");
				$issueBook=issueBook($cid,$libid,$date);
				//$allIssueBook=fetchIssueBook();
                header("Location: issue_book.php");
				//////////////////////
				
				///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d  h:i:s A");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="Book Issue";
$saveRecord=addUserRecord($user, $ip, $browser, $pageName, $user_activity, $date);
/////////////////////////////////////////////////////////////////////////////////
			
			}
		}
require_once("models/header.php");
$allIssueBook=fetchIssueBook();
///////////
function get_time_ago( $time )
{
    $time_difference = time() - $time;

    if( $time_difference < 1 ) { return 'less than 1 second ago'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return '' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
        }
    }
}
///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d  h:i:s A");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="Book Issue Section";
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
                        <i class="fa fa-leanpub"></i> Issue Book
                        <small>Library</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="account.php"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="library_admin.php"><i class="fa fa-book"></i> Library</a></li>
                        <li class="active"><i class="fa fa-leanpub"></i> Issue Book</li>
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
                                    <h3 class='box-title'>Book Issue Details Available Here</h3>   
									
                                </div>
								<div class='box-body table-responsive'>
                                <div class='table-toolbar'>
									<div class='btn-group'>
										<a class='btn  btn-primary' data-toggle='modal' data-target='#compose-modal'><i class='fa fa-leanpub'></i> Issue Book</a>
									</div>
									<div class='btn-group pull-right'>
										
										
									</div>
									</div>
                                <div class='box-body table-responsive no-padding'>
                                    <table id='example1' class='table table-bordered table-striped table-hover'>
                        	<thead>
								<th style='text-align:center;'>Student Id</th>
								<th style='text-align:center;'>Book Id</th>
								<th style='text-align:center;'>Issue Date</th>
								<th style='text-align:center;'>Status</th>
                                <th style='text-align:center;'></th>
                            </thead>
                            <tbody>
                            <?php
							echo resultBlock($errors,$successes);
							$bno=countIssueBook();
							if($bno['no']>0)
							{
								foreach ($allIssueBook as $row){
									
								echo"
                            	<tr>
                                	<td style='text-align:center;'>".str_pad($row['cid'], 10, '0', STR_PAD_LEFT)."</td>
                                	<td style='text-align:center;'>".str_pad($row['libid'], 10, '0', STR_PAD_LEFT)."</td>
									<td style='text-align:center;'>".date( "j M, Y", strtotime($row['issue_date']))."</td>
									<td style='text-align:center;'>".get_time_ago( strtotime($row['issue_date']) )."</td>
									<td style='text-align:center;'><button name='view' libid='".$row['libid']."' class='btn btn-info btn-xs view_data' onClick='return confirmSubmit()' title='Return Book'><span class='fa fa-mail-reply'</button></td>
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
                        <h4 class="modal-title"><i class="fa fa-leanpub"></i> Issue Book</h4>
                    </div>
                    <?php echo "<form action='".$_SERVER['PHP_SELF']."' method='post' id='formID'>
                        <div class='modal-body'>
                            			
							<div class='row'>
                                        
										<div class='form-group col-md-6'>
                                            <label for='isbn'>Student ID</label>
											<div class='input-group'>
											<div class='input-group-addon'>
                                                <i class='fa fa-barcode'></i>
                                            </div>
                                            <input type='text' name='cid' class='form-control validate[required,custom[integer,minSize[10],maxSize[10],min[1]] text-input'  placeholder='Enter Student College Id' data-inputmask='\"mask\": \"9999999999\"' data-mask>
											</div>
                                        </div>
										<div class='form-group col-md-6'>
                                            <label for='isbn'>Book Id</label>
											<div class='input-group'>
											<div class='input-group-addon'>
                                                <i class='fa fa-barcode'></i>
                                            </div>
                                            <input type='text' name='libid' class='form-control validate[required,custom[integer,minSize[10],maxSize[10],min[1]] text-input'  placeholder='Enter Book Id' data-inputmask='\"mask\": \"9999999999\"' data-mask>
											</div>
                                        </div>
							</div>
                        </div>
                        <div class='modal-footer clearfix'>

                            <button type='button' class='btn btn-danger' data-dismiss='modal'><i class='fa fa-times'></i> Discard</button>

                            <button type='submit' class='btn btn-primary pull-left'><i class='fa fa-book'></i> Issue Book</button>
                        </div>
                    </form>
					"; ?>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
            
        <!-- COMPOSE MESSAGE MODAL -->
        <div class="modal fade" id="display-data" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-book"></i> Book Details</h4>
                    </div>
                        <div class='modal-body' id='book_details'>
                            
							
                        </div>
                        
                  
					
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
            
            
       <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
		<!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- InputMask -->
        <script src="js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

        

        <!-- Page script -->
        <script type="text/javascript">
            $(function() {
                
                $("[data-mask]").inputmask();

          $(document).ready(function() {
    			$('#example1').DataTable( {
        			order: [[ 2, 'desc' ]]
    				} );
		  		} );
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
<script>  
 	$(document).ready(function(){  
      $('.view_data').click(function(){  
           var libid = $(this).attr("libid");  
           $.ajax({  
                url:"return_direct.php",  
                method:"post",  
                data:{libid:libid},  
                success:function(data){  
                     $('#book_details').html(data);  
                     $('#display-data').modal("show");  
                }  
           });  
      });  
 });  
 </script>
            <script>
                $('#display-data').on('hidden.bs.modal', function () {
     location.reload();
});
            </script>        
                
    </body>
</html>