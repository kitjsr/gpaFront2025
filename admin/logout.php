<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
///////////////// USER'S ACTIVITY RECORD /////////////
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d  h:i:s A");
$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$user=$loggedInUser->displayname;
$pageName = basename($_SERVER['PHP_SELF']);
$user_activity="Logout";
$saveRecord=addUserRecord($user, $ip, $browser, $pageName, $user_activity, $date);
/////////////////////////////////////////////////////////////////////////////////
//Log the user out
if(isUserLoggedIn())
{
	$loggedInUser->userLogOut();
}

if(!empty($websiteUrl)) 
{
	$add_http = "";
	
	if(strpos($websiteUrl,"http://") === false)
	{
		$add_http = "http://";
	}
// 	if ($loggedInUser->checkPermission(array(4))){
	header("Location: student_login.php");
	die();
// 	}
}
else
{
	header("Location: http://".$_SERVER['HTTP_HOST']);
// header("Location: student_login.php");
	die();
}	

?>