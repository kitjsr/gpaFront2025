<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
$fid=$_GET['fid'];
$fdata=fetchPayDetails($fid);
if ($loggedInUser->checkPermission(array(2))){
			$student=fetchSingleStudentCid($fdata['sid']);
									
			}
///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d  h:i:s A");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="Fee Receipt";
//$saveRecord=addUserRecord($user, $ip, $browser, $pageName, $user_activity, $date);
/////////////////////////////////////////////////////////////////////////////////

function convert_number_to_words($number) {
   
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
   
    if (!is_numeric($number)) {
        return false;
    }
   
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
   
    $string = $fraction = null;
   
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
   
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
   
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
   
    return $string;
}
?>
<style type="text/css">
#invoice{
    padding: 0px;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 15px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #3989c6
}

.invoice .company-details {
    text-align: right;
	padding-right: 15px;
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px;
	padding-right: 15px;
}

.invoice .invoice-to {
    text-align: left;
	padding-left: 15px;
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #3989c6
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -10px;
    font-size: 2em;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice table td,.invoice table th {
    padding: 10px;
    background: #eee;
    border-bottom: 1px solid #000
}
	
.invoice table th {
    white-space: nowrap;
    font-weight: bold;
    font-size: 16px;
	background:#3989c6;
}

.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #3989c6;
    font-size: 1.2em
}

.invoice table .qty,.invoice table .total {
    text-align: right;
    font-size: 1.2em
}
.invoice table .unit {
    font-size: 1.2em
}

.invoice table .no {
    color: #fff;
    font-size: 1.6em;
    background: #3989c6
}

.invoice table .unit {
    background: #ddd
}



.invoice table tbody tr:last-child td {
    border: none
}

.invoice table tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 1.2em;
    border-top: 1px solid #aaa
}

.invoice table tfoot tr:first-child td {
    border-top: none;
	color: #3989c6;
    font-size: 1.4em;
}

.invoice table tfoot tr:last-child td {
    color: #3989c6;
    font-size: 1.4em;
    border-top: 1px solid #3989c6
}

.invoice table tfoot tr td:first-child {
    border: none
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}

@media print {
    .invoice {
        font-size: 11px!important;
        overflow: hidden!important
    }

    .invoice footer {
        position: absolute;
        bottom: 10px;
        page-break-after: always
    }

    .invoice>div:last-child {
        page-break-before: always
    }
}
</style>
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
								echo "
                                    <img src='upload_images/".$student['photo']."' class='img-circle' alt='User Image' />";
								}
								else{
								echo "
                                    <img src='img/avatar3.png' class='img-circle' alt='User Image' />";
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
                        Dashboard
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
					<div id="invoice">

    <div class="toolbar hidden-print">
        <div class="text-right">
            <button id="printInvoice" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
            <button class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export as PDF</button>
        </div>
        <hr>
    </div>
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    
                    <div class="col company-details">
                        <h3>Government of Jharkhand</h3>
                        <h2 class="name">Government Polytechnic Adityapur</h2>
                        <div>Adityapur Industrial Area, Jamshedpur, Jharkhand - 832109</div>
                        <div>+91-657 2383303 | gpa2010@rediffmail.com | www.gpadp.org.in</div>
                        
                    </div>
                </div>
            </header>
			<?php
			function feeCalc($category,$tfw,$gender,$admyear){
				switch($admyear){
					case 1:
						if($category==2 || $category==3 || $tfw==1 || $gender==2){
							$admfee=5;
							$tutionfee=0;
							$cautionfee=0;
							$specialfee=200;
							$totalfee=$admfee+$tutionfee+$cautionfee+$specialfee;
						}
						else{
							$admfee=5;
							$tutionfee=0;
							$cautionfee=0;
							$specialfee=0;
							$totalfee=$admfee+$tutionfee+$cautionfee+$specialfee;
						}

						break;
					case 2:
						if($tfw==1 || $gender==2){
							$admfee=5;
							$tutionfee=0;
							$cautionfee=0;
							$specialfee=0;
							$totalfee=$admfee+$tutionfee+$cautionfee+$specialfee;
						}
						else if($category==2 || $category==3){
							$admfee=5;
							$tutionfee=0;
							$cautionfee=0;
							$specialfee=0;
							$totalfee=$admfee+$tutionfee+$cautionfee+$specialfee;
						}
						else{
							$admfee=5;
							$tutionfee=0;
							$cautionfee=0;
							$specialfee=0;
							$totalfee=$admfee+$tutionfee+$cautionfee+$specialfee;
						}
						break;
					default:
						echo "Something Wrong";
				}
				return array($totalfee,$admfee,$tutionfee,$cautionfee,$specialfee);
			}
			list($f1,$f2,$f3,$f4,$f5)  = feeCalc($student['category'],$student['tfw'],$student['gender'],1); 
			
			function branch($j)
			{
				switch ($j)
				{
					case 1: $branch="Mechanical Engineering";
					break;
					case 2 : $branch="Electrical Engineering";
					break;
					case 3 : $branch="Metallurgical Engineering";
					break;
					case 4 : $branch="Computer Sc. &amp; Engineering";
					break;
					default : $branch="N/A";
					break;

				}
				return $branch;
			}

			///////////
			function admType($k, $adm_date)
			{
				switch ($k)
				{
					case 1: 
						$adm_type="Regular";
						$session = date( "Y-m-d", strtotime($adm_date));//existing date
						$sessionEnd =  date('Y-m-d', strtotime($session .'+3 years')); //added +3 years along with the $date
					break;
					case 2 : $adm_type="Lateral";
						$session = date( "Y-m-d", strtotime($adm_date));//existing date
						$sessionEnd =  date('Y-m-d', strtotime($session .'+2 years')); //added +2 years along with the $date
					break;

				}

				return array($adm_type,$session,$sessionEnd);
			}
			/////
			list($v1, $v2,$v3)  = admType($student['adm_type'],$student['adm_date']); 

		//will print out values from someFunc
		//echo "$var1 $var2"; 					

			function category($l)
			{
				switch ($l)
				{
					case 1: $category="General";
					break;
					case 2 : $category="SC";
					break;
					case 3: $category="ST";
					break;
					case 4 : $category="BC-I";
					break;
					case 5: $category="BC-II";
					break;

				}
				return $category;
			}

			function tfw($m)
			{
				switch ($m)
				{
					case 1: $tfw="Yes";
					break;
					case 2 : $tfw="No";
					break;

				}
				return $tfw;
			}
	

			?>
            <main>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <div class="text-gray-light">INVOICE TO:</div>
                        <h3 class="to"><?php echo $student['name']; ?></h3>
						<?php
							if($student['adm_date']=="")
							{
								echo "<span style='border-bottom:dotted 1px #000'>Re Admission</p>";
							}
							else{
								echo"<div class='address'><strong>Session </strong> - ".date( "Y", strtotime($v2))."-".date( "Y", strtotime($v3))." </div>
								<div class='address'><strong>Board Roll No.</strong> - ".$student['broll']."</div>
								<div class='address'><strong>Class Roll No</strong> - ".$student['roll']."</div>";
							}
						?>
                        
                        <div class="address"><strong>Admission Type </strong> - <?php echo $v1; ?></div>
                        <div class="address"><strong>TFW </strong> - <?php echo tfw($student['tfw']); ?></div>
                        <div class="address"><strong>Category </strong> - <?php echo category($student['category']); ?></div>
                        <div class="address"><strong>Branch</strong> - <?php echo branch($student['branch']); ?></div>
						<div class="address"><strong>Year</strong> - First/Second(L) Year</div>
						
						<div class="address"><strong>Mobile</strong> - <?php echo $student['mobile']; ?></div>
                        <div class="email"><?php echo $student['email']; ?></div>
                    </div>
                    <div class="col invoice-details">
                        <h1 class="invoice-id">INVOICE</h1>
                        <div class="date"><strong>Date of Invoice</strong>: <?php echo date( "j M, Y", strtotime($fdata['date'])); ?></div>
                        <div><strong>Invoice No. रसीद संख्या </strong>: <?php echo $fdata['fid']; ?></div>
                    </div>
                </div>
				<div style="overflow-x: auto">
					<table border="0" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<th>#</th>
								<th class="text-left">DESCRIPTION</th>
								<th class="text-left">TRANSACTION ID</th>
								<th class="text-right">AMOUNT</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="no">01</td>
								<td class="text-left"><h3>
									<a target="_blank" href="#">
									Re-Admission Fee पुनः प्रवेश शुल्क 
									</a>
									</h3>

								</td>
								<td class="unit" rowspan="4">
									<p><?php echo $fdata['trno']; ?></p>
									<p><?php echo $fdata['brno']; ?></p>
									<p><?php echo $fdata['authstatus']; ?></p>
									<p>Purpose : <?php echo $fdata['pcode']; ?></p>
									<p>Amount : <?php echo $fdata['amount']; ?></p>
									<p><?php echo date( "j M, Y H:i:s", strtotime($fdata['txndate'])); ?></p>
								</td>
								<td class="total">&#8377; <?php echo number_format($f2,2); ?></td>
							</tr>
							<tr>
								<td class="no">02</td>
								<td class="text-left"><h3>
									<a target="_blank" href="#">
									Tution Fee शिक्षण शुल्क
									</a>
									</h3>

								</td>
								<td class="total">&#8377; <?php echo number_format($f3,2); ?></td>
							</tr>
							<tr>
								<td class="no">03</td>
								<td class="text-left"><h3>
									<a target="_blank" href="#">
									Caution Money 
									</a>
									</h3>

								</td>
								<td class="total">&#8377; <?php echo number_format($f4,2); ?></td>
							</tr>
							<tr>
								<td class="no">04</td>
								<td class="text-left"><h3>
									<a target="_blank" href="#">
									Special Fee विशेष शुल्क
									</a>
									</h3>

								</td>
								<td class="total">&#8377; <?php echo number_format($f5,2); ?></td>
							</tr>

						</tbody>
						<tfoot>
							<tr>
								<td colspan="2">TOTAL</td>
								<td colspan="2">&#8377; <?php echo number_format($f1,2); ?></td>
							</tr>


							<tr>
								<td colspan="2">TOTAL</td>
								<td colspan="2" style="text-transform: capitalize;"><?php echo "".convert_number_to_words($f1)." only"; ?></td>
							</tr>
						</tfoot>
					</table>
				</div>
                
                <div class="thanks">Thank you!</div>
                <div class="notices">
                    <div>NOTICE:</div>
                    <div class="notice">One copy deposit on Fee Collection Department, Government Polytechnic Adityapur.</div>
                </div>
            </main>
            <footer>
               This is Computer Generated Invoice and is valid without the signature and seal.
            </footer>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


        <!-- jQuery 2.0.2 -->
        <script src="js/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
        
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="js/AdminLTE/dashboard.js" type="text/javascript"></script>    
		<script type="text/javascript">
			 $('#printInvoice').click(function(){
            Popup($('.invoice')[0].outerHTML);
            function Popup(data) 
            {
                window.print();
                return true;
            }
        });	
		</script>

    </body>
</html>