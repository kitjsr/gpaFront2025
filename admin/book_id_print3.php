<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
//require_once("models/header.php");

if(!empty($_GET)) {
			
			$libid1 = trim($_GET['libid1']);
			$libid2 = trim($_GET['libid2']);

			if($libid1 == "")
			{
				$errors[] = lang("ENTER_BOOK_ID");
			}
			if($libid2 == "")
			{
				$errors[] = lang("ENTER_BOOK_ID");
			}
			
			///////// Duplicate Entry Checking
			if(empty($errors)) {
				//
				////////////// BOOK ISSUE ID FOUND //////////
				
				//////////////////////
				
				///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d  h:i:s A");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="Book Return";
$saveRecord=addUserRecord($user, $ip, $browser, $pageName, $user_activity, $date);
/////////////////////////////////////////////////////////////////////////////////
			
			}
		}
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
    <style type='text/css'>
    .row{
        width:100%;
    }
    .col-md-3{
        width:24%;
        float:left;
    }
    </style>
	<script language='Javascript1.2'>
  <!--
  function printpage() {
  window.print();
  }
  //-->
</script>
<body onload='printpage()'>
";
                        
						echo resultBlock($errors,$successes);
						echo"
                                <div class='row'>";
                                for($i=$libid1;$i<=$libid2;$i++){
                                    echo"<div class='col-md-3' align='center' style='padding:5px 0;'><img alt='' src='barcode.php?codetype=Code39&size=40&text=".str_pad($i, 10, '0', STR_PAD_LEFT)."' /></br>".str_pad($i, 10, '0', STR_PAD_LEFT)."</div>";
                                    
                                }
                                echo"
                                 </div>     
                                
							";
						
					?>
                            
                  

       
       
        

    </body>
</html>