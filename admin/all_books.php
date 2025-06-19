<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$allb=fetchBookList();
//Add New Book on Book List
		if(!empty($_POST)) {
			$bid= trim($_POST['bid']);
			$q = trim($_POST['q']);
			
			date_default_timezone_set('Asia/Calcutta');
			$date=date("Y-m-d  h:i:s A");
			//Validate request
			
			if($bid == "")
			{
				$errors[] = lang("CHOOSE_BOOK");
			}
			
			if($q == "")
			{
				$errors[] = lang("ENTER_QUANTITY");
			}
			if(empty($errors)) {
				for($i=1;$i<=$q;$i++){
					$addBookL=addBookLibrary($bid,$date);
				}
				$successes[] = lang("BOOK_ADD_SUCCESSFUL");
				$allbookLibrary=fetchBookLibrary();
				//////////////////////
				
				///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d  h:i:s A");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="Add Books on Library";
$saveRecord=addUserRecord($user, $ip, $browser, $pageName, $user_activity, $date);
/////////////////////////////////////////////////////////////////////////////////
			
			}
		}
require_once("models/header.php");
$allbookLibrary=fetchBookLibrary();

///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d  h:i:s A");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="Book List";
$saveRecord=addUserRecord($user, $ip, $browser, $pageName, $user_activity, $date);
/////////////////////////////////////////////////////////////////////////////////
echo "
<link rel='stylesheet' href='css/bootstrap-select.min.css' />
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
                        <i class="fa fa-book"></i> All Book 
                        <small>Library</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="account.php"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="library_admin.php"><i class="fa fa-book"></i> Library</a></li>
                        <li class="active"><i class="fa fa-book"></i> All Book</li>
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
                                    <h3 class='box-title'>All Book Details Available Here</h3>   
									
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
								<th style='text-align:center;'>Available</th>
								<th style='text-align:left;'>Name</th>
								<th style='text-align:left;'>Author</th>
								<th style='text-align:left;'>Publisher</th>
								<th style='text-align:center;'>Place</th>
                                <th style='text-align:center;'></th>
                            </thead>
                            <tbody>
                            <?php
							echo resultBlock($errors,$successes);
							$bno=checkNoOfBookLib();
							if($bno['no']>0)
							{
								foreach ($allbookLibrary as $row){
									$noBooks=checkNoOfBook($row['bid']);
									$book=fetchSingleBook($row['bid']);
									
									//////////////////
									$allLibBooks=fetchAllBookList($row['bid']);
									$count=0;
									foreach ($allLibBooks as $data){
										//echo $data['libid'];
										$val=countSingleIssueBook($data['libid']);
										
										$count=$count+$val['no'];
										
									}
									
									$singlePlace=fetchSinglePlace($book['pid']);
									/////////////
								echo"
                            	<tr>
                                	<td style='text-align:center;'>".($noBooks['no']-$count)."/".$noBooks['no']."</td>
									<td style='text-align:left;'>".$book['bname']."</td>
									<td style='text-align:left;'>".$book['author']."</td>
									<td style='text-align:left;'>".$book['publisher']."</td>
									<td style='text-align:center;'>".$singlePlace['pcode']."</td>
									<td style='text-align:center;'><input type='button' name='view' value='view' bid='".$row['bid']."' class='btn btn-info btn-xs view_data' /></td>
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
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Books on Library</h4>
                    </div>
                    <?php echo "<form action='".$_SERVER['PHP_SELF']."' method='post' id='formID'>
                        <div class='modal-body'>
                            			
							<div class='row'>
                                        <div class='form-group col-md-12'>
                                            <label for='isbn'>Book Name</label>
                                            <select class='selectpicker form-control validate[required]' data-show-subtext='true' data-live-search='true' name='bid'>
											<option value=''> --- Choose Book Name --- </option>";
											foreach ($allb as $row){
									
											echo"<option value='".$row['bid']."'>".$row['bname']."</option>";
											}
											echo"
      										</select>
                                        </div>
										<div class='form-group col-md-12'>
                                            <label for='isbn'>Quantity</label>
                                            <input type='text' name='q' class='form-control validate[required,custom[integer],min[1]] text-input'  placeholder='Enter Book Quantity'>
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
        <script src="js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
        <script src="js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

        

        <!-- Page script -->
        <script type="text/javascript">
            $(function() {
                
                $("[data-mask]").inputmask();

          $(document).ready(function() {
    			$('#example1').DataTable( {
        			order: [[ 1, 'desc' ]]
    				} );
		  		} );
            });
			
        </script>
        <script>  
 	$(document).ready(function(){  
      $('.view_data').click(function(){  
           var bid = $(this).attr("bid");  
           $.ajax({  
                url:"select.php",  
                method:"post",  
                data:{bid:bid},  
                success:function(data){  
                     $('#book_details').html(data);  
                     $('#display-data').modal("show");  
                }  
           });  
      });  
 });  
 </script>

    </body>
</html>