<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) { header("Location: account.php"); die(); }

//Forms posted
if(!empty($_POST))
{
	$errors = array();
	$username = sanitize(trim($_POST["username"]));
	$d = trim($_POST["password"]);
			
	
	//Perform some validation
	//Feel free to edit / change as required
	if($username == "")
	{
		$errors[] = lang("PLEASE_ENTER_MOBILE");
	}
	if($d == "")
	{
		$errors[] = lang("PLEASE_ENTER_DOB");
	}

	if(count($errors) == 0)
	{
			$date_array = explode("/",$d); // split the array
			$var_day = $date_array[0]; //day seqment
			$var_month = $date_array[1]; //month segment
			$var_year = $date_array[2]; //year segment
			$password = "".$var_year."-".$var_month."-".$var_day.""; // join them together
		//A security note here, never tell the user which credential was incorrect
		if(!usernameExists($username))
		{
			$errors[] = lang("INVALID_MOBILE");
		}
		else
		{
			$userdetails = fetchUserDetails($username);
			//See if the user's account is activated
			if($userdetails["active"]==0)
			{
				$errors[] = lang("ACCOUNT_INACTIVE");
			}
			else
			{
				//Hash the password and use the salt from the database to compare the password.
				$entered_pass = generateHash($password,$userdetails["password"]);
				
				if($entered_pass != $userdetails["password"])
				{
					//Again, we know the password is at fault here, but lets not give away the combination incase of someone bruteforcing
					$errors[] = lang("ACCOUNT_MOBILE_OR_DOB_INVALID");
				}
				else
				{
					//Passwords match! we're good to go'
					
					//Construct a new logged in user object
					//Transfer some db data to the session object
					$loggedInUser = new loggedInUser();
					$loggedInUser->email = $userdetails["email"];
					$loggedInUser->user_id = $userdetails["id"];
					$loggedInUser->hash_pw = $userdetails["password"];
					$loggedInUser->title = $userdetails["title"];
					$loggedInUser->displayname = $userdetails["display_name"];
					$loggedInUser->username = $userdetails["user_name"];
					
					//Update last sign in
					$loggedInUser->updateLastSignIn();
					$_SESSION["userCakeUser"] = $loggedInUser;
					
					//Redirect to user account page
					header("Location: account.php");
					die();
				}
			}
		}
	}
}

require_once("models/header.php");
echo"<script src='js/jquery.min.js' type='text/javascript'>
	</script>
	<link rel='stylesheet' type='text/css' href='css/jquery.datepick.css'> 
<script type='text/javascript' src='js/jquery.plugin.js'></script> 
<script type='text/javascript' src='js/jquery.datepick.js'></script>
<script>
$(function() {
	$('#popupDatepicker').datepick({dateFormat: 'dd/mm/yyyy'});
	$('#inlineDatepicker').datepick({onSelect: showDate} );
	
});

function showDate(date) {
	alert('The date chosen is ' + date);
}
</script>

<!--
$(selector).datepick({dateFormat: 'yyyy-mm-dd'});
-->
";
?>
<body style="background:url(img/blur-background08.jpg) no-repeat center center fixed;
		-webkit-background-size: cover !important;
		-moz-background-size: cover !important;
		-o-background-size: cover !important;
		background-size: cover !important;
        font-family: 'Open Sans', sans-serif;
    font-size:14px;
    line-height:25px;
   background-color:#000;
   color:#fff;
	">
    <div id="pre-div">
        <div id="loader">
        </div>
    </div>
    <!--/. PRELOADER END -->
    
    <!--./ NAV BAR END -->
    <div id="home" >
        <div class="overlay">
            <div class="container">
            <?php
			echo resultBlock($errors,$successes);
			?>
				<div class="span3">
				<div class="title_index">
				<div class="row-fluid">
				</div></div>
                    <div class="col-lg-4 col-md-5">
                        <div class="div-trans">
						
                            <?php
							
                           echo "
	<div class='row'>
        <div class='form-box' id='login-box' style='margin:0px auto 0 !important;'>
            <div class='header'>Student Panel</div>
            <form name='login' action='".$_SERVER['PHP_SELF']."' method='post'>
                <div class='body bg-gray'>
                    <div class='form-group'>
                        <input type='text' name='username' class='form-control' placeholder='Mobile No.' autocomplete='off' data-inputmask='\"mask\": \"9999999999\"' data-mask/>
                    </div>
                    <div class='form-group'>
                        <input type='text' name='password' id='popupDatepicker' class='form-control' placeholder='Date of Birth' data-inputmask=\"'alias': 'dd/mm/yyyy'\" data-mask/>
                    </div>
                </div>
                <div class='footer'>                                                               
                    <button type='submit' class='btn btn-primary btn-large'>Sign me in</button>  
                    
                    
                </div>
            </form>
           <div class='margin text-center'>
                <span>Developed By : <strong>Kunal Mahto</strong>, +91-9934347907</br> <a href='mailto:kunalkumar1987@gmail.com'>kunalkumar1987@gmail.com</a></span>

            </div>
        </div>
		
	";
?>


                        </div>
                    </div>
					
                </div>

				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<div class="row-fluid">
				<div class="col-md-6 col-md-offset-1">
				<div class="span3"><img class="index_logo img-responsive" height="236" width="700" src="img/sms.png"></div>
						
				</div></div>
				
				
				<div class="row-fluid">
				<div class="col-md-5 col-md-offset-1">
				<h4><span id=tick2>
				</span>&nbsp;| 
<script>
				function show2(){
				if (!document.all&&!document.getElementById)
				return
				thelement=document.getElementById? document.getElementById("tick2"): document.all.tick2
				var Digital=new Date()
				var hours=Digital.getHours()
				var minutes=Digital.getMinutes()
				var seconds=Digital.getSeconds()
				var dn="PM"
				if (hours<12)
				dn="AM"
				if (hours>12)
				hours=hours-12
				if (hours==0)
				hours=12
				if (minutes<=9)
				minutes="0"+minutes
				if (seconds<=9)
				seconds="0"+seconds
				var ctime=hours+":"+minutes+":"+seconds+" "+dn
				thelement.innerHTML=ctime
				setTimeout("show2()",1000)
				}
				window.onload=show2
				//-->
</script>
	      <?php
            $date = new DateTime();
            echo $date->format('l, F jS, Y');
          ?><h4>
          	
            </div>
            </div>
			
			</div>
			</div>
			
        </div>


    </div>
   <div id="footser-end">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                   <center>Alrights Reserved &copy; <?php echo date("Y")?></center>
                </div>
            </div>

        </div>
    </div>
    <!--./ FOOTER SECTION END -->

        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>     
        <!-- InputMask -->
        <script src="js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
        <script src="js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
        <script src="js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
        
        <!-- AdminLTE App -->
        

        <!-- Page script -->
        <script type="text/javascript">
            $(function() {
                //Datemask dd/mm/yyyy
                $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
                //Datemask2 mm/dd/yyyy
                $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
                //Money Euro
                $("[data-mask]").inputmask();

                

                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                    checkboxClass: 'icheckbox_minimal',
                    radioClass: 'iradio_minimal'
                });
                //Red color scheme for iCheck
                $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                    checkboxClass: 'icheckbox_minimal-red',
                    radioClass: 'iradio_minimal-red'
                });
                //Flat red color scheme for iCheck
                $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                    checkboxClass: 'icheckbox_flat-red',
                    radioClass: 'iradio_flat-red'
                });

                
            });
        </script>   

    </body>
</html>