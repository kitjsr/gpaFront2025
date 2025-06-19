<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
//Add New Book on Book List
		if(!empty($_POST)) {
			$isbn= trim($_POST['isbn']);
			$bname = trim($_POST['bname']);
			$author = trim($_POST['author']);
			$publisher = trim($_POST['publisher']);
			$edition = trim($_POST['edition']);
			$category = trim($_POST['category']);
			$price = trim($_POST['price']);
			$year = trim($_POST['year']);
			date_default_timezone_set('Asia/Calcutta');
			$date=date("Y-m-d  h:i:s A");
			//Validate request
			
			if($isbn == "")
			{
				$errors[] = lang("ENTER_ISBN");
			}
			if($bname == "")
			{
				$errors[] = lang("ENTER_BNAME");
			}
			if($author == "")
			{
				$errors[] = lang("ENTER_AUTHOR");
			}
			if($publisher == "")
			{
				$errors[] = lang("ENTER_PUBLISHER");
			}
			if($edition == "")
			{
				$errors[] = lang("ENTER_EDITION");
			}
			if($category == "")
			{
				$errors[] = lang("CHOOSE_CATEGORY");
			}
			if($price == "")
			{
				$errors[] = lang("ENTER_PRICE");
			}
			if($year == "")
			{
				$errors[] = lang("ENTER_YEAR");
			}
			if(empty($errors)) {
				$successes[] = lang("BOOK_ADD_SUCCESSFUL");
				$addb=addBookList($isbn,$bname,$author,$publisher,$edition,$category,$price,$year,$date);
				$allb=fetchBookList();
				//////////////////////
				
				///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d  h:i:s A");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="Add Book on Book List";
$saveRecord=addUserRecord($user, $ip, $browser, $pageName, $user_activity, $date);
/////////////////////////////////////////////////////////////////////////////////
			
			}
		}
require_once("models/header.php");
$allb=fetchBookList();

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
<link rel='stylesheet' href='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css' />
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
								<th style='text-align:center;'>Book Id</th>
								<th style='text-align:center;'>Category</th>
								<th style='text-align:left;'>Name</th>
								<th style='text-align:center;'>Rack</th>
                                <th style='text-align:center;'></th>
                                <th style='text-align:center;'></th>
                            </thead>
                            <tbody>
                            <?php
							echo resultBlock($errors,$successes);
							$bno=checkNoOfBookList();
							if($bno['no']>0)
							{
								foreach ($allb as $row){
									
								echo"
                            	<tr>
                                	<td style='text-align:center;'>".$row['isbn']."</td>
									<td style='text-align:left;'>".$row['bname']."</td>
									<td style='text-align:left;'>".$row['author']."</td>
									<td style='text-align:left;'>".$row['bcat']."</td>
									<td style='text-align:center;'><a onClick='return confirmSubmit()' href='book_details.php?bid=".$row['bid']."'><span class='fa fa-eye' aria-hidden='true'></span></a></td>
									<td style='text-align:center;'><a onClick='return confirmSubmit()' href='book_edit.php?bid=".$row['bid']."'><span class='fa fa-edit' aria-hidden='true'></span></a></td>
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
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Book</h4>
                    </div>
                    <?php echo "<form action='".$_SERVER['PHP_SELF']."' method='post' id='formID'>
                        <div class='modal-body'>
                            			
							<div class='row'>
                                        <div class='form-group col-md-6'>
                                            <label for='isbn'>ISBN</label>
                                            <input type='text' name='isbn' class='form-control validate[required] text-input'  placeholder='Enter Book ISBN'>
                                        </div>
                                        <div class='form-group col-md-6'>
                                            <label for='isbn'>Book Name</label>
                                            <select class='selectpicker' data-show-subtext='true' data-live-search='true' class='form-control validate[required]'>
        <option data-subtext='Rep California'>Tom Foolery</option>
        <option data-subtext='Sen California'>Bill Gordon</option>
        <option data-subtext='Sen Massacusetts'>Elizabeth Warren</option>
        <option data-subtext='Rep Alabama'>Mario Flores</option>
        <option data-subtext='Rep Alaska'>Don Young</option>
        <option data-subtext='Rep California' disabled='disabled'>Marvin Martinez</option>
      </select>
                                        </div>
										<div class='form-group col-md-6'>
                                            <label for='isbn'>Author Name</label>
                                            <input type='text' name='author' class='form-control validate[required] text-input'  placeholder='Enter Book Author Name'>
                                        </div>
										<div class='form-group col-md-6'>
                                            <label for='isbn'>Publisher</label>
                                            <input type='text' name='publisher' class='form-control validate[required] text-input'  placeholder='Enter Book Publisher Name'>
                                        </div>
										<div class='form-group col-md-6'>
                                            <label for='isbn'>Book Edition</label>
                                            <input type='text' name='edition' class='form-control validate[required,custom[integer],min[1]] text-input'  placeholder='Enter Book Edition'>
                                        </div>
										<div class='form-group col-md-6'>
                                            <label for='isbn'>Book Category</label>
                                            <select name='category' class='form-control validate[required]' >
												<option value=''> --- Choose Book Category --- </option>
												<option value='1'>Mechanical Engineering</option>
												<option value='2'>Electrical Engineering</option>
												<option value='3'>Metallurgy Engineering</option>
												<option value='4'>Computer Sc. &amp; Engineering</option>
												<option value='5'>Physics</option>
												<option value='6'>Chemistry</option>
												<option value='7'>Mathematics</option>
												<option value='8'>English</option>
												<option value='9'>Managment</option>
												<option value='10'>Other</option>
											</select>
                                        </div>
										<div class='form-group col-md-6'>
                                            <label for='isbn'>Book Price</label>
                                            <input type='text' name='price' class='form-control validate[required,custom[number,min[0]] text-input'  placeholder='Enter Book Price'>
                                        </div>
										<div class='form-group col-md-6'>
                                            <label for='isbn'>Published Year</label>
                                            <input type='text' name='year' class='form-control validate[required,custom[integer,minSize[4],maxSize[4],min[1900]] text-input'  placeholder='Enter Book Published Year' data-inputmask='\"mask\": \"9999\"' data-mask>
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
        

    </body>
</html>