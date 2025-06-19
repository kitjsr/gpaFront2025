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
		$errors[] = lang("ACCOUNT_SPECIFY_USERNAME");
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
			$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
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

require_once("models/header.php");
?>

<link href="http://www.gpadp.org.in/css/style.css" rel="stylesheet" type="text/css">
<body>
    <section id='content'>
<div class='container'>

<div class='row'>
    <div class='col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3'>
    <?php
	echo"
		<form name='login' action='".$_SERVER['PHP_SELF']."' method='post' role='form' class='register-form'>
			<h2>Sign in <small>manage your account</small></h2>
			<hr class='colorgraph'>

			<div class='form-group'>
				<input type='text' name='username' id='email' class='form-control input-lg' placeholder='Username' tabindex='4'>
			</div>
			<div class='form-group'>
				<input type='password' name='password' class='form-control input-lg' id='exampleInputPassword1' placeholder='Password'>
			</div>

			<div class='row'>
				<div class='col-xs-4 col-sm-3 col-md-3'>
					<span class='button-checkbox'>
						<button type='button' class='btn' data-color='info' tabindex='7'>Remember me</button>
                        <input type='checkbox' name='t_and_c' id='t_and_c' class='hidden' value='1'>
					</span>
				</div>
			</div>
			
			<hr class='colorgraph'>
			<div class='row'>
				<div class='col-xs-12 col-md-6'><input type='submit' value='Sign in' class='btn btn-primary btn-block btn-lg' tabindex='7'></div>
			</div>
		</form>";
		?>
	</div>
</div>

</div>
	</section>

  
<!-- jQuery 2.0.2 -->
        <script src="js/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>