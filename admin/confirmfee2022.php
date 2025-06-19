<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");

///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d h:i:s");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="Fee Deposit";
$saveRecord=addUserRecord($user, $ip, $browser, $pageName, $user_activity, $date);
/////////////////////////////////////////////////////////////////////////////////
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
                        <i class='fa fa-rupee'></i> Fee Deposit
                        <small>Dashboard</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="account.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><i class='fa fa-rupee'></i> Fee Deposit</li>
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
					<div class="row">
						<div class="col-md-6">
						    <div class='alert alert-danger'>If you have valid Fee Deposit Permission then Pay Now! </div>
						<?php
						////////
					
								$pcode=$_POST['pcode'];
							//echo $pcode;
							
						///////////
						function feeCalc($pcode){
							switch($pcode){
								case 101:
										$totalfee=1805;
										break;
								case 102:
										$totalfee=405;
										break;
								case 103:
										$totalfee=405;
										break;
								case 104:
										$totalfee=5;
										break;
								case 105:
										$totalfee=1605;
										break;
								case 106:
										$totalfee=205;
										break;
								case 201:
										$totalfee=2605;
										break;
								case 202:
										$totalfee=805;
										break;
								case 203:
										$totalfee=205;
										break;
								case 204:
										$totalfee=5;
										break;
								case 301:
										$totalfee=2605;
										break;
								case 302:
										$totalfee=805;
										break;
								case 303:
										$totalfee=205;
										break;
								case 304:
										$totalfee=5;
										break;
								case 501:
										$totalfee=840;
										break;
								default:
									$totalfee=0;
							}
							return $totalfee;
						}
						

							//////////////
							$MerchantID="GOVPOLCADT";
							$CustomerID=uniqid(rand()); //every time unique id
							$TxnAmount=feeCalc($pcode);//amount
							$SecurityID="govpolcadt";
							$AdditionalInfo1=$student['sid'];//sid
							$AdditionalInfo2=$student['name'];//name
							$AdditionalInfo3=$student['branch'];//branch
							$AdditionalInfo4=$student['sem'];//sem
							$AdditionalInfo5=$pcode;//pcode - payment code
							$AdditionalInfo6=$pcode;//pcode - payment code
							//$Filler1="";
							//$BankID="";
							//$Filler2="";
							//$Filler3="";
							//$CurrencyType="";
							//$ItemCode="";
							//$TypeField1="";
							//$Filler4="";
							//$Filler5="";

							/////////////
							//$str = 'TESTME|UATTXN0001|NA|2|NA|NA|NA|INR|NA|R|NA|NA|NA|F|Andheri|Mumbai|02240920005|support@billdesk.com|NA|NA|NA|https://www.billdesk.com';
							$str = "".$MerchantID."|".$CustomerID."|NA|".$TxnAmount."|NA|NA|NA|INR|NA|R|".$SecurityID."|NA|NA|F|".$AdditionalInfo1."|".$AdditionalInfo2."|".$AdditionalInfo3."|".$AdditionalInfo4."|".$AdditionalInfo5."|".$AdditionalInfo6."|NA|NA";

							$checksum = hash_hmac('sha256',$str,'qxPCDqF1ppdIt890j4F2IVxZtwYVndTx', false); 
							$checksum = strtoupper($checksum);
							$final_msg="".$str."|".$checksum."";

					?>
					<script src="https://pgi.billdesk.com/payments-checkout-widget/src/app.bundle.js"></script>




					 <center><a class="main-btn w3-button w3-round-large w3-blue" href="javascript:void(0)" onclick="validateForm()"
										data-animation="fadeInUp" data-delay="1.5s" class="w3-button w3-blue btn btn-danger">Proceed To Pay</a></center>
					<script src="https://pgi.billdesk.com/payments-checkout-widget1/src/app.bundle.js"></script>

					 <form method="post" action="" name="form1" id="form1">


						   <!-- <input type="text" name="childMsgString" value="merchantid|9876543210|NA|1|NA|NA|NA|INR|NA|R|security id|NA|NA|F|DSFDSF|sds@g.c|TDC 1ST YEAR|ARTS|NA|NA|NA|NA|checksumvalue">-->
							<input type="hidden" name="childMsgString" value="<?php echo $final_msg; ?>">


						</form>
					<script type="text/javascript">
							function validateForm() {

									bdPayment.initialize({
										msg: document.form1.childMsgString.value,options: {enableChildWindowPosting: true,
											enablePaymentRetry: true,
								retry_attempt_count: 3},
										callbackUrl:'https://www.gpa.ac.in/admin/gpaymentstatus.php'

										})

							}
										</script>
										
										
						</div>
						<!-- col-md-6-->
						<div class="col-md-6">
							<h2>Transaction Details</h2>
                          	<table id='example1' class='table table-bordered table-striped table-hover'>
                        	<thead>
								<th style='text-align:left;'>Purpose</th>
								<th style='text-align:center;'>Trans. Id</th>
                                <th style='text-align:center;'>Amount</th>
                                <th style='text-align:center;'>Date</th>
                                <th></th>
                            </thead>
                            <tbody>
                            <?php
								$data=fetchSingleStudentPay($student['sid']);
								foreach ($data as $row){
								echo"
                            	<tr>
                                	<td style='text-align:left;'>".$row['pcode']."</td>
									<td style='text-align:center;'>".$row['trno']."</td>
									<td style='text-align:right;'>".$row['amount']."</td>
									<td style='text-align:center;'>".date( "j M, Y", strtotime($row['txndate']))."</td>
									<td style='text-align:center;'><a href='invoice_2022.php?fid=".$row['fid']."' target='_blank'><i class='fa fa-file'></i></a></td>
                                </tr>";
								}
							
							
							?>
                            </tbody>
                            <tfoot>
                                         
                                        </tfoot>
                                    </table>
                                
						</div>
					</div>
                    
                    

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

       


       <!-- jQuery 2.0.2 -->
        <script src="js/jquery.min.js"></script>
       <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- page script -->
        

    </body>
</html>