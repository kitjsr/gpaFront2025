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
	$password = trim($_POST["password"]);
	
	//Perform some validation
	//Feel free to edit / change as required
	if($username == "")
	{
		$errors[] = lang("ACCOUNT_SPECIFY_USERNAME_ST");
	}
	if($password == "")
	{
		$errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
	}

	if(count($errors) == 0)
	{
		//A security note here, never tell the user which credential was incorrect
		if(!usernameExists($username))
		{
			$errors[] = lang("ACCOUNT_MOBILE_OR_PASS_INVALID");
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
					$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
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


?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Student Managment System</title>
<!-- mobile responsive meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="http://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="http://www.gpadp.org.in/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
@import url("//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css");
.login-block{
    background: #DE6262;  /* fallback for old browsers */
background: -webkit-linear-gradient(to bottom, #FFB88C, #DE6262);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to bottom, #FFB88C, #DE6262); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
float:left;
width:100%;
padding : 50px 0;
}
.banner-sec{background:url(img/gpa.jpg)  no-repeat left bottom; background-size:cover; min-height:500px; border-radius: 0 10px 10px 0; padding:0;}
.container{background:#fff; border-radius: 10px; box-shadow:15px 20px 0px rgba(0,0,0,0.1);}
.carousel-inner{border-radius:0 10px 10px 0;}
.carousel-caption{text-align:left; left:5%;}
.login-sec{padding: 40px 30px; position:relative;}
.login-sec .copy-text{position:absolute; width:80%; bottom:20px; font-size:13px; text-align:center; font-weight: bold;}
.login-sec .copy-text i{color:#FEB58A; font-weight: bold;}
.login-sec .copy-text a{color:#E36262;}
.login-sec h2{margin-bottom:30px; font-weight:800; font-size:30px; color: #DE6262;}
.login-sec h2:after{content:" "; width:100px; height:5px; background:#FEB58A; display:block; margin-top:20px; border-radius:3px; margin-left:auto;margin-right:auto}
.btn-login{background: #DE6262; color:#fff; font-weight:600;}
.banner-text{width:70%; position:absolute; bottom:40px; padding-left:20px;}
.banner-text h2{color:#fff; font-weight:600;}
.banner-text h2:after{content:" "; width:100px; height:5px; background:#FFF; display:block; margin-top:20px; border-radius:3px;}
.banner-text p{color:#fff;}
	.btn {margin-bottom:10px;}
</style>
	

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

<body>

  <?php
	
	echo"<section class='login-block'>
    <div class='container'>
	<div class='row'>
		<div class='col-md-4 login-sec'>
		    <h2 class='text-center'>Login Now</h2>";
	
			echo resultBlock($errors,$successes);
			echo"<form name='login' action='".$_SERVER['PHP_SELF']."' method='post' role='form' class='login-form' id='formID'>
  <div class='form-group'>
    <label for='exampleInputEmail1'>Mobile No.</label>
    <input type='text' name='username' class='form-control validate[required, custom[phone],ajax[validateUserNameMob], minSize[10], maxSize[10]]' placeholder='Enter Mobile No' autocomplete='off' data-inputmask='\"mask\": \"9999999999\"' data-mask>
    
  </div>
  <div class='form-group'>
    <label for='exampleInputPassword1'>Password</label>
    <input type='password' name='password' class='form-control validate[required]' placeholder='Enter Password'>
  </div>
  
  
    <div class='form-check'>
    
	<button type='submit' class='btn btn-login float-right'>Submit</button>
  </div>
  
</form>

<div class='copy-text'>

<i class='fa fa-laptop'></i> Developed By <a href='tel:9470312947'>Kunal Mahto</a></div>
		</div>
		<div class='col-md-8 banner-sec'>
            <div class='' style='position:absolute;bottom:50px; text-align:center;margin:0 auto; width:100%;' align='center'>
            <div class='alert alert-info'>
            If you have Admission Permission Receipt then Register Here.
            
	<a href='student_registration11.php' class='btn btn-success' style='border:0px solid #de6262 !important; bottom:0px;text-align:center;'><i class='fa fa-file'></i> New Student Registration</a>
	</div>
	<!--
            <div class='alert alert-info'>
            Second Year Registration Link <i class='fa fa-hand-o-right'></i>
            
	<a href='second_year.php' class='btn btn-success' style='border:0px solid #de6262 !important; bottom:0px;text-align:center;'><i class='fa fa-file'></i> Second Year Registration</a>
	</div>
            <div class='alert alert-info'>
            Third Year Registration Link <i class='fa fa-hand-o-right'></i>
            
	<a href='third_year.php' class='btn btn-success' style='border:0px solid #de6262 !important; bottom:0px;text-align:center;'><i class='fa fa-file'></i> Third Year Registration</a>
	</div>
	-->
</div>
   
            </div>	   
		    
		</div>
	</div>
</div>
</section>";
	?>
   

    </body>
<script src="js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
        <script src="js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
        <script src="js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
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
</html>