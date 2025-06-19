<?php

//Functions that do not interact with DB
//------------------------------------------------------------------------------

//Retrieve a list of all .php files in models/languages
function getLanguageFiles()
{
	$directory = "models/languages/";
	$languages = glob($directory . "*.php");
	//print each file name
	return $languages;
}

//Retrieve a list of all .css files in models/site-templates 
function getTemplateFiles()
{
	$directory = "models/site-templates/";
	$languages = glob($directory . "*.css");
	//print each file name
	return $languages;
}
//fetchAllStudent()
//Retrieve a list of all .php files in root files folder
function getPageFiles()
{
	$directory = "";
	$pages = glob($directory . "*.php");
	//print each file name
	foreach ($pages as $page){
		$row[$page] = $page;
	}
	return $row;
}

//Destroys a session as part of logout
function destroySession($name)
{
	if(isset($_SESSION[$name]))
	{
		$_SESSION[$name] = NULL;
		unset($_SESSION[$name]);
	}
}

//Generate a unique code
function getUniqueCode($length = "")
{	
	$code = md5(uniqid(rand(), true));
	if ($length != "") return substr($code, 0, $length);
	else return $code;
}

//Generate an activation key
function generateActivationToken($gen = null)
{
	do
	{
		$gen = md5(uniqid(mt_rand(), false));
	}
	while(validateActivationToken($gen));
	return $gen;
}

//@ Thanks to - http://phpsec.org
function generateHash($plainText, $salt = null)
{
	if ($salt === null)
	{
		$salt = substr(md5(uniqid(rand(), true)), 0, 25);
	}
	else
	{
		$salt = substr($salt, 0, 25);
	}
	
	return $salt . sha1($salt . $plainText);
}

//Checks if an email is valid
function isValidEmail($email)
{
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return true;
	}
	else {
		return false;
	}
}

//Inputs language strings from selected language.
function lang($key,$markers = NULL)
{
	global $lang;
	if($markers == NULL)
	{
		$str = $lang[$key];
	}
	else
	{
		//Replace any dyamic markers
		$str = $lang[$key];
		$iteration = 1;
		foreach($markers as $marker)
		{
			$str = str_replace("%m".$iteration."%",$marker,$str);
			$iteration++;
		}
	}
	//Ensure we have something to return
	if($str == "")
	{
		return ("No language key found");
	}
	else
	{
		return $str;
	}
}

//Checks if a string is within a min and max length
function minMaxRange($min, $max, $what)
{
	if(strlen(trim($what)) < $min)
		return true;
	else if(strlen(trim($what)) > $max)
		return true;
	else
	return false;
}

//Replaces hooks with specified text
function replaceDefaultHook($str)
{
	global $default_hooks,$default_replace;	
	return (str_replace($default_hooks,$default_replace,$str));
}

//Displays error and success messages
function resultBlock($errors,$successes){
	//Error block
	if(count($errors) > 0)
	{
		echo "<div class='alert alert-danger' role='alert'>
		<strong>Warning!</strong>
		<ul>";
		foreach($errors as $error)
		{
			echo "<li>".$error."</li>";
		}
		echo "</ul>";
		echo "</div>";
	}
	//Success block
	if(count($successes) > 0)
	{
		echo " <div class='alert alert-success fade in'>

        <a href='#' class='close' data-dismiss='alert'>&times;</a>
		<strong>Success!</strong>
		<ul>";
		foreach($successes as $success)
		{
			echo "<li>".$success."</li>";
		}
		echo "</ul>";
		echo "</div>";
	}
}

//Completely sanitizes text
function sanitize($str)
{
	return strtolower(strip_tags(trim(($str))));
}

//Functions that interact mainly with .users table
//------------------------------------------------------------------------------

//Delete a defined array of users
function deleteUsers($users) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."users 
		WHERE id = ?");
	$stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches 
		WHERE user_id = ?");
	foreach($users as $id){
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt2->bind_param("i", $id);
		$stmt2->execute();
		$i++;
	}
	$stmt->close();
	$stmt2->close();
	return $i;
}

//Check if a display name exists in the DB
function displayNameExists($displayname)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT active
		FROM ".$db_table_prefix."users
		WHERE
		display_name = ?
		LIMIT 1");
	$stmt->bind_param("s", $displayname);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Check if an email exists in the DB
function emailExists($email)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT active
		FROM ".$db_table_prefix."users
		WHERE
		email = ?
		LIMIT 1");
	$stmt->bind_param("s", $email);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Check if a user name and email belong to the same user
function emailUsernameLinked($email,$username)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT active
		FROM ".$db_table_prefix."users
		WHERE user_name = ?
		AND
		email = ?
		LIMIT 1
		");
	$stmt->bind_param("ss", $username, $email);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Retrieve information for all users
function fetchAllUsers()
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		user_name,
		display_name,
		password,
		email,
		activation_token,
		last_activation_request,
		lost_password_request,
		active,
		title,
		sign_up_stamp,
		last_sign_in_stamp
		FROM ".$db_table_prefix."users");
	$stmt->execute();
	$stmt->bind_result($id, $user, $display, $password, $email, $token, $activationRequest, $passwordRequest, $active, $title, $signUp, $signIn);
	
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'user_name' => $user, 'display_name' => $display, 'password' => $password, 'email' => $email, 'activation_token' => $token, 'last_activation_request' => $activationRequest, 'lost_password_request' => $passwordRequest, 'active' => $active, 'title' => $title, 'sign_up_stamp' => $signUp, 'last_sign_in_stamp' => $signIn);
	}
	$stmt->close();
	return ($row);
}

//Retrieve complete user information by username, token or ID
function fetchUserDetails($username=NULL,$token=NULL, $id=NULL)
{
	if($username!=NULL) {
		$column = "user_name";
		$data = $username;
	}
	elseif($token!=NULL) {
		$column = "activation_token";
		$data = $token;
	}
	elseif($id!=NULL) {
		$column = "id";
		$data = $id;
	}
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		user_name,
		display_name,
		password,
		email,
		activation_token,
		last_activation_request,
		lost_password_request,
		active,
		title,
		sign_up_stamp,
		last_sign_in_stamp
		FROM ".$db_table_prefix."users
		WHERE
		$column = ?
		LIMIT 1");
		$stmt->bind_param("s", $data);
	
	$stmt->execute();
	$stmt->bind_result($id, $user, $display, $password, $email, $token, $activationRequest, $passwordRequest, $active, $title, $signUp, $signIn);
	while ($stmt->fetch()){
		$row = array('id' => $id, 'user_name' => $user, 'display_name' => $display, 'password' => $password, 'email' => $email, 'activation_token' => $token, 'last_activation_request' => $activationRequest, 'lost_password_request' => $passwordRequest, 'active' => $active, 'title' => $title, 'sign_up_stamp' => $signUp, 'last_sign_in_stamp' => $signIn);
	}
	$stmt->close();
	return ($row);
}

//Toggle if lost password request flag on or off
function flagLostPasswordRequest($username,$value)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET lost_password_request = ?
		WHERE
		user_name = ?
		LIMIT 1
		");
	$stmt->bind_param("ss", $value, $username);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}

//Check if a user is logged in
function isUserLoggedIn()
{
	global $loggedInUser,$mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT 
		id,
		password
		FROM ".$db_table_prefix."users
		WHERE
		id = ?
		AND 
		password = ? 
		AND
		active = 1
		LIMIT 1");
	$stmt->bind_param("is", $loggedInUser->user_id, $loggedInUser->hash_pw);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if($loggedInUser == NULL)
	{
		return false;
	}
	else
	{
		if ($num_returns > 0)
		{
			return true;
		}
		else
		{
			destroySession("userCakeUser");
			return false;	
		}
	}
}

//Change a user from inactive to active
function setUserActive($token)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET active = 1
		WHERE
		activation_token = ?
		LIMIT 1");
	$stmt->bind_param("s", $token);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Change a user's display name
function updateDisplayName($id, $display)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET display_name = ?
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("si", $display, $id);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}

//Update a user's email
function updateEmail($id, $email)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET 
		email = ?
		WHERE
		id = ?");
	$stmt->bind_param("si", $email, $id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Input new activation token, and update the time of the most recent activation request
function updateLastActivationRequest($new_activation_token,$username,$email)
{
	global $mysqli,$db_table_prefix; 	
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET activation_token = ?,
		last_activation_request = ?
		WHERE email = ?
		AND
		user_name = ?");
	$stmt->bind_param("ssss", $new_activation_token, time(), $email, $username);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Generate a random password, and new token
function updatePasswordFromToken($pass,$token)
{
	global $mysqli,$db_table_prefix;
	$new_activation_token = generateActivationToken();
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET password = ?,
		activation_token = ?
		WHERE
		activation_token = ?");
	$stmt->bind_param("sss", $pass, $new_activation_token, $token);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Update a user's title
function updateTitle($id, $title)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET 
		title = ?
		WHERE
		id = ?");
	$stmt->bind_param("si", $title, $id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;	
}

//Check if a user ID exists in the DB
function userIdExists($id)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT active
		FROM ".$db_table_prefix."users
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Checks if a username exists in the DB
function usernameExists($username)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT active
		FROM ".$db_table_prefix."users
		WHERE
		user_name = ?
		LIMIT 1");
	$stmt->bind_param("s", $username);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Check if activation token exists in DB
function validateActivationToken($token,$lostpass=NULL)
{
	global $mysqli,$db_table_prefix;
	if($lostpass == NULL) 
	{	
		$stmt = $mysqli->prepare("SELECT active
			FROM ".$db_table_prefix."users
			WHERE active = 0
			AND
			activation_token = ?
			LIMIT 1");
	}
	else 
	{
		$stmt = $mysqli->prepare("SELECT active
			FROM ".$db_table_prefix."users
			WHERE active = 1
			AND
			activation_token = ?
			AND
			lost_password_request = 1 
			LIMIT 1");
	}
	$stmt->bind_param("s", $token);
	$stmt->execute();
	$stmt->store_result();
		$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Functions that interact mainly with .permissions table
//------------------------------------------------------------------------------

//Create a permission level in DB
function createPermission($permission) {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."permissions (
		name
		)
		VALUES (
		?
		)");
	$stmt->bind_param("s", $permission);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Delete a permission level from the DB
function deletePermission($permission) {
	global $mysqli,$db_table_prefix,$errors; 
	$i = 0;
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permissions 
		WHERE id = ?");
	$stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches 
		WHERE permission_id = ?");
	$stmt3 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches 
		WHERE permission_id = ?");
	foreach($permission as $id){
		if ($id == 1){
			$errors[] = lang("CANNOT_DELETE_NEWUSERS");
		}
		elseif ($id == 2){
			$errors[] = lang("CANNOT_DELETE_ADMIN");
		}
		else{
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt2->bind_param("i", $id);
			$stmt2->execute();
			$stmt3->bind_param("i", $id);
			$stmt3->execute();
			$i++;
		}
	}
	$stmt->close();
	$stmt2->close();
	$stmt3->close();
	return $i;
}

//Retrieve information for all permission levels
function fetchAllPermissions()
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		name
		FROM ".$db_table_prefix."permissions");
	$stmt->execute();
	$stmt->bind_result($id, $name);
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'name' => $name);
	}
	$stmt->close();
	return ($row);
}

//Retrieve information for a single permission level
function fetchPermissionDetails($id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		name
		FROM ".$db_table_prefix."permissions
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->bind_result($id, $name);
	while ($stmt->fetch()){
		$row = array('id' => $id, 'name' => $name);
	}
	$stmt->close();
	return ($row);
}

//Check if a permission level ID exists in the DB
function permissionIdExists($id)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT id
		FROM ".$db_table_prefix."permissions
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Check if a permission level name exists in the DB
function permissionNameExists($permission)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT id
		FROM ".$db_table_prefix."permissions
		WHERE
		name = ?
		LIMIT 1");
	$stmt->bind_param("s", $permission);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Change a permission level's name
function updatePermissionName($id, $name)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."permissions
		SET name = ?
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("si", $name, $id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;	
}

//Functions that interact mainly with .user_permission_matches table
//------------------------------------------------------------------------------

//Match permission level(s) with user(s)
function addPermission($permission, $user) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."user_permission_matches (
		permission_id,
		user_id
		)
		VALUES (
		?,
		?
		)");
	if (is_array($permission)){
		foreach($permission as $id){
			$stmt->bind_param("ii", $id, $user);
			$stmt->execute();
			$i++;
		}
	}
	elseif (is_array($user)){
		foreach($user as $id){
			$stmt->bind_param("ii", $permission, $id);
			$stmt->execute();
			$i++;
		}
	}
	else {
		$stmt->bind_param("ii", $permission, $user);
		$stmt->execute();
		$i++;
	}
	$stmt->close();
	return $i;
}

//Retrieve information for all user/permission level matches
function fetchAllMatches()
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		user_id,
		permission_id
		FROM ".$db_table_prefix."user_permission_matches");
	$stmt->execute();
	$stmt->bind_result($id, $user, $permission);
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'user_id' => $user, 'permission_id' => $permission);
	}
	$stmt->close();
	return ($row);	
}

//Retrieve list of permission levels a user has
function fetchUserPermissions($user_id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT
		id,
		permission_id
		FROM ".$db_table_prefix."user_permission_matches
		WHERE user_id = ?
		");
	$stmt->bind_param("i", $user_id);	
	$stmt->execute();
	$stmt->bind_result($id, $permission);
	while ($stmt->fetch()){
		$row[$permission] = array('id' => $id, 'permission_id' => $permission);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Retrieve list of users who have a permission level
function fetchPermissionUsers($permission_id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT id, user_id
		FROM ".$db_table_prefix."user_permission_matches
		WHERE permission_id = ?
		");
	$stmt->bind_param("i", $permission_id);	
	$stmt->execute();
	$stmt->bind_result($id, $user);
	while ($stmt->fetch()){
		$row[$user] = array('id' => $id, 'user_id' => $user);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Unmatch permission level(s) from user(s)
function removePermission($permission, $user) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches 
		WHERE permission_id = ?
		AND user_id =?");
	if (is_array($permission)){
		foreach($permission as $id){
			$stmt->bind_param("ii", $id, $user);
			$stmt->execute();
			$i++;
		}
	}
	elseif (is_array($user)){
		foreach($user as $id){
			$stmt->bind_param("ii", $permission, $id);
			$stmt->execute();
			$i++;
		}
	}
	else {
		$stmt->bind_param("ii", $permission, $user);
		$stmt->execute();
		$i++;
	}
	$stmt->close();
	return $i;
}

//Functions that interact mainly with .configuration table
//------------------------------------------------------------------------------

//Update configuration table
function updateConfig($id, $value)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."configuration
		SET 
		value = ?
		WHERE
		id = ?");
	foreach ($id as $cfg){
		$stmt->bind_param("si", $value[$cfg], $cfg);
		$stmt->execute();
	}
	$stmt->close();	
}

//Functions that interact mainly with .pages table
//------------------------------------------------------------------------------

//Add a page to the DB
function createPages($pages) {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."pages (
		page
		)
		VALUES (
		?
		)");
	foreach($pages as $page){
		$stmt->bind_param("s", $page);
		$stmt->execute();
	}
	$stmt->close();
}

//Delete a page from the DB
function deletePages($pages) {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."pages 
		WHERE id = ?");
	$stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches 
		WHERE page_id = ?");
	foreach($pages as $id){
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt2->bind_param("i", $id);
		$stmt2->execute();
	}
	$stmt->close();
	$stmt2->close();
}

//Fetch information on all pages
function fetchAllPages()
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		page,
		private
		FROM ".$db_table_prefix."pages");
	$stmt->execute();
	$stmt->bind_result($id, $page, $private);
	while ($stmt->fetch()){
		$row[$page] = array('id' => $id, 'page' => $page, 'private' => $private);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Fetch information for a specific page
function fetchPageDetails($id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		page,
		private
		FROM ".$db_table_prefix."pages
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->bind_result($id, $page, $private);
	while ($stmt->fetch()){
		$row = array('id' => $id, 'page' => $page, 'private' => $private);
	}
	$stmt->close();
	return ($row);
}

//Check if a page ID exists
function pageIdExists($id)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT private
		FROM ".$db_table_prefix."pages
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);	
	$stmt->execute();
	$stmt->store_result();	
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Toggle private/public setting of a page
function updatePrivate($id, $private)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."pages
		SET 
		private = ?
		WHERE
		id = ?");
	$stmt->bind_param("ii", $private, $id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;	
}

//Functions that interact mainly with .permission_page_matches table
//------------------------------------------------------------------------------

//Match permission level(s) with page(s)
function addPage($page, $permission) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."permission_page_matches (
		permission_id,
		page_id
		)
		VALUES (
		?,
		?
		)");
	if (is_array($permission)){
		foreach($permission as $id){
			$stmt->bind_param("ii", $id, $page);
			$stmt->execute();
			$i++;
		}
	}
	elseif (is_array($page)){
		foreach($page as $id){
			$stmt->bind_param("ii", $permission, $id);
			$stmt->execute();
			$i++;
		}
	}
	else {
		$stmt->bind_param("ii", $permission, $page);
		$stmt->execute();
		$i++;
	}
	$stmt->close();
	return $i;
}

//Retrieve list of permission levels that can access a page
function fetchPagePermissions($page_id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT
		id,
		permission_id
		FROM ".$db_table_prefix."permission_page_matches
		WHERE page_id = ?
		");
	$stmt->bind_param("i", $page_id);	
	$stmt->execute();
	$stmt->bind_result($id, $permission);
	while ($stmt->fetch()){
		$row[$permission] = array('id' => $id, 'permission_id' => $permission);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Retrieve list of pages that a permission level can access
function fetchPermissionPages($permission_id)
{
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT
		id,
		page_id
		FROM ".$db_table_prefix."permission_page_matches
		WHERE permission_id = ?
		");
	$stmt->bind_param("i", $permission_id);	
	$stmt->execute();
	$stmt->bind_result($id, $page);
	while ($stmt->fetch()){
		$row[$page] = array('id' => $id, 'permission_id' => $page);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Unmatched permission and page
function removePage($page, $permission) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches 
		WHERE page_id = ?
		AND permission_id =?");
	if (is_array($page)){
		foreach($page as $id){
			$stmt->bind_param("ii", $id, $permission);
			$stmt->execute();
			$i++;
		}
	}
	elseif (is_array($permission)){
		foreach($permission as $id){
			$stmt->bind_param("ii", $page, $id);
			$stmt->execute();
			$i++;
		}
	}
	else {
		$stmt->bind_param("ii", $permission, $user);
		$stmt->execute();
		$i++;
	}
	$stmt->close();
	return $i;
}

//Check if a user has access to a page
function securePage($uri){
	
	//Separate document name from uri
	$tokens = explode('/', $uri);
	$page = $tokens[sizeof($tokens)-1];
	global $mysqli,$db_table_prefix,$loggedInUser;
	//retrieve page details
	$stmt = $mysqli->prepare("SELECT 
		id,
		page,
		private
		FROM ".$db_table_prefix."pages
		WHERE
		page = ?
		LIMIT 1");
	$stmt->bind_param("s", $page);
	$stmt->execute();
	$stmt->bind_result($id, $page, $private);
	while ($stmt->fetch()){
		$pageDetails = array('id' => $id, 'page' => $page, 'private' => $private);
	}
	$stmt->close();
	//If page does not exist in DB, allow access
	if (empty($pageDetails)){
		return true;
	}
	//If page is public, allow access
	elseif ($pageDetails['private'] == 0) {
		return true;	
	}
	//If user is not logged in, deny access
	elseif(!isUserLoggedIn()) 
	{
		header("Location: login.php");
		return false;
	}
	else {
		//Retrieve list of permission levels with access to page
		$stmt = $mysqli->prepare("SELECT
			permission_id
			FROM ".$db_table_prefix."permission_page_matches
			WHERE page_id = ?
			");
		$stmt->bind_param("i", $pageDetails['id']);	
		$stmt->execute();
		$stmt->bind_result($permission);
		while ($stmt->fetch()){
			$pagePermissions[] = $permission;
		}
		$stmt->close();
		//Check if user's permission levels allow access to page
		if ($loggedInUser->checkPermission($pagePermissions)){ 
			return true;
		}
		//Grant access if master user
		elseif ($loggedInUser->user_id == $master_account){
			return true;
		}
		else {
			header("Location: account.php");
			return false;	
		}
	}
}

// Add Notice on Database
function addNotice($title, $notice, $home, $new, $date) {
	global $mysqli; 
	$stmt = $mysqli->prepare("INSERT INTO notice (
					title,
					notice,
					home,
					new,
					date
					)
					VALUES (
					?,
					?,
					?,
					?,
					?
					)");
	
	$stmt->bind_param( 'ssiis', $title, $notice, $home, $new, $date);
	$result = $stmt->execute();
	$stmt->close();	
	
}
//Fetch information of All Notice
function fetchAllNotice()
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		title,
		notice,
		home,
		new,
		date
		FROM notice ORDER BY id DESC ");
	$stmt->execute();
	$stmt->bind_result($id, $title, $notice, $home, $new, $date);
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'title' => $title, 'notice' => $notice, 'home' => $home, 'new' => $new, 'date' => $date);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}
//Fetch information for a single Notice
function fetchSingleNotice($id)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		title,
		notice,
		home,
		new,
		date
		FROM
		notice
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->bind_result($id, $title, $notice, $home, $new, $date);
	while ($stmt->fetch()){
		$row = array('id' => $id, 'title' => $title, 'notice' => $notice, 'home' => $home, 'new' => $new, 'date' => $date);
		
	}
	$stmt->close();
	return ($row);
}
function updateNoticeTitle($id, $title)
{
	global $mysqli;
	$stmt = $mysqli->prepare("UPDATE notice
		SET title = ?
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("si", $title, $id);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}
function updateNotice($id, $notice)
{
	global $mysqli;
	$stmt = $mysqli->prepare("UPDATE notice
		SET notice = ?
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("si", $notice, $id);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}
function updateHome($id, $home)
{
	global $mysqli;
	$stmt = $mysqli->prepare("UPDATE notice
		SET home = ?
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("ii", $home, $id);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}
function updateNew($id, $new)
{
	global $mysqli;
	$stmt = $mysqli->prepare("UPDATE notice
		SET new = ?
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("ii", $new, $id);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}

//Fetch information of All Vacancy Application
function fetchAllVacancyApp()
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		name,
		father_name,
		qualification,
		pq,
		ctet,
		phone
		FROM vacancy ORDER BY id DESC ");
	$stmt->execute();
	$stmt->bind_result($id, $name, $father_name, $qualification, $pq, $ctet, $phone);
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'name' => $name, 'father_name' => $father_name, 'qualification' => $qualification, 'pq' => $pq, 'ctet' => $ctet, 'phone' => $phone);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Fetch information for a single vacancy application
function fetchSingleVacancyApp($id)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		name,
		father_name,
		mother_name,
		dob_month,
		dob_date,
		dob_year,
		qualification,
		pq,
		ctet,
		percentage,
		at,
		post,
		dist,
		state,
		pin,
		cat,
		cpost,
		cdist,
		cstate,
		cpin,
		phone,
		email,
		resume
		FROM
		vacancy
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->bind_result($id, $name, $father_name, $mother_name, $dob_month, $dob_date, $dob_year, $qualification, $pq, $ctet, $percentage, $at, $post, $dist, $state, $pin, $cat, $cpost, $cdist, $cstate, $cpin, $phone, $email, $resume);
	while ($stmt->fetch()){
		$row = array('id' => $id, 'name' => $name, 'father_name' => $father_name, 'mother_name' => $mother_name,  'dob_month' => $dob_month, 'dob_date' => $dob_date, 'dob_year' => $dob_year, 'qualification' => $qualification, 'pq' => $pq, 'ctet' => $ctet, 'percentage' => $percentage, 'at' => $at, 'post' => $post, 'dist' => $dist, 'state' => $state, 'pin' => $pin, 'cat' =>$cat, 'cpost' => $cpost, 'cdist' => $cdist, 'cstate' => $cstate, 'cpin' => $cpin, 'phone' => $phone, 'email' => $email, 'resume' => $resume);
		
	}
	$stmt->close();
	return ($row);
}


// Add Event on Database
function addEvent($type, $event_name, $start_date, $end_date) {
	global $mysqli; 
	$stmt = $mysqli->prepare("INSERT INTO event_details (
					type,
					event_name,
					start_date,
					end_date
					)
					VALUES (
					?,
					?,
					?,
					?
					)");
	
	$stmt->bind_param( 'ssss', $type, $event_name, $start_date, $end_date);
	$result = $stmt->execute();
	$stmt->close();	
	
}
//Fetch information of All Event
function fetchAllEvent()
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		type,
		event_name,
		start_date,
		end_date
		FROM event_details ORDER BY id ASC ");
	$stmt->execute();
	$stmt->bind_result($id, $type, $event_name, $start_date, $end_date);
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'type' => $type, 'event_name' => $event_name, 'start_date' => $start_date, 'end_date' => $end_date);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Fetch information of All Branch
function fetchAllSMS()
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		message,
		sent_to,
		sender,
		date
		FROM sent_message ORDER BY id DESC ");
	$stmt->execute();
	$stmt->bind_result($id, $message, $sent_to, $sender, $date);
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'message' => $message, 'sent_to' => $sent_to, 'sender' => $sender, 'date' => $date);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}


// Add Message on Database
function addMessageDetails($message, $sent_to, $sender, $date) {
	global $mysqli; 
	$stmt = $mysqli->prepare("INSERT INTO sent_message (
					message,
					sent_to,
					sender,
					date
					)
					VALUES (
					?,
					?,
					?,
					?
					)");
	
	$stmt->bind_param('ssss', $message, $sent_to, $sender, $date);
	$result = $stmt->execute();
	$stmt->close();	
	
}

////////////////// UPDATE STAFF DETAILS ////////////////////////

//Fetch information for a singal plan
function fetchSingleStaff($id)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		name,
		type,
		mobile_1,
		mobile_2,
		email_1,
		email_2
		FROM staff_details
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->bind_result($id, $name, $type, $mobile_1, $mobile_2, $email_1, $email_2);
	while ($stmt->fetch()){
		$row = array('id' => $id, 'name' => $name, 'type' => $type, 'mobile_1' => $mobile_1, 'mobile_2' => $mobile_2, 'email_1' => $email_1, 'email_2' => $email_2);
		
	}
	$stmt->close();
	return ($row);
}

function updateStaffName($id, $name)
{
	global $mysqli;
	$stmt = $mysqli->prepare("UPDATE staff_details
		SET name = ?
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("si", $name, $id);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}

function updateStaffType($id, $type)
{
	global $mysqli;
	$stmt = $mysqli->prepare("UPDATE staff_details
		SET type = ?
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("si", $type, $id);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}
function updateStaffMobile1($id, $mobile_1)
{
	global $mysqli;
	$stmt = $mysqli->prepare("UPDATE staff_details
		SET mobile_1 = ?
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("ii", $mobile_1, $id);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}
function updateStaffMobile2($id, $mobile_2)
{
	global $mysqli;
	$stmt = $mysqli->prepare("UPDATE staff_details
		SET mobile_2 = ?
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("si", $mobile_2, $id);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}
function updateStaffEmail1($id, $email_1)
{
	global $mysqli;
	$stmt = $mysqli->prepare("UPDATE staff_details
		SET email_1 = ?
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("si", $email_1, $id);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}
function updateStaffEmail2($id, $email_2)
{
	global $mysqli;
	$stmt = $mysqli->prepare("UPDATE staff_details
		SET email_2 = ?
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("si", $email_2, $id);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}

//Update Permission Level
function changePermission($permission_id, $user_id)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE uc_user_permission_matches
		SET permission_id = ?
		WHERE
		user_id = ?
		LIMIT 1
		");
	$stmt->bind_param("ii", $permission_id, $user_id);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}
function updateUserProfile($id, $profile_pic)
{
	global $mysqli;
	$stmt = $mysqli->prepare("UPDATE uc_users
		SET profile_pic = ?
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("si", $profile_pic, $id);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}

// Add Message on Database
function addUserRecord($user, $ip, $browser, $view_page, $user_activity, $date) {
	global $mysqli; 
	$stmt = $mysqli->prepare("INSERT INTO login_details (
					user_name,
					ip,
					browser,
					page,
					activity,
					date
					)
					VALUES (
					?,
					?,
					?,
					?,
					?,
					?
					)");
	
	$stmt->bind_param('ssssss', $user, $ip, $browser, $view_page, $user_activity, $date);
	$result = $stmt->execute();
	$stmt->close();	
	
}

//Fetch information of All Visitors
function fetchUserRecord()
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT
		id,
		user_name,
		ip,
		browser,
		page,
		activity,
		date
		FROM login_details ORDER BY id DESC ");
	$stmt->execute();
	$stmt->bind_result($id, $user_name, $ip, $browser, $page, $activity, $date);
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'user_name' => $user_name, 'ip' => $ip, 'browser' => $browser, 'page' => $page, 'activity' => $activity, 'date' => $date);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Fetch information of All Transaction
function fetchFeeCollection()
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT
		fid, sid,
		reg_no,
		branch,
		semester,
		roll,
		tid, amount
		date
		FROM fee_collection ");
	$stmt->execute();
	$stmt->bind_result($fid, $sid,$reg_no, $branch, $semester, $roll, $tid, $amount, $date);
	while ($stmt->fetch()){
		$row[] = array('fid' => $fid, 'sid' => $sid, 'reg_no' => $reg_no, 'branch' => $branch, 'semester' => $semester, 'roll' => $roll, 'tid' => $tid, 'amount' => $amount, 'date' => $date);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Checks if a student already registered
function studentExists($mobile)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT *
		FROM students
		WHERE
		mobile = ?
		LIMIT 1");
	$stmt->bind_param("i", $mobile);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Checks if a student already registered
function studentEmailExists($email)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT *
		FROM students
		WHERE
		email = ?
		LIMIT 1");
	$stmt->bind_param("s", $email);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}
// Add Student Details on Database
function addStudent($cid,$name,$father_name,$mother_name,$dob,$gender,$branch,$roll,$broll,$sem,$category,$adm_type,$tfw,$at,$post,$city,$dist,$state,$pin,$cat,$cpost,$ccity,$cdist,$cstate,$cpin,$mobile,$email,$adm_date,$date) {
	global $mysqli; 
	$stmt = $mysqli->prepare("INSERT INTO students (
					cid,name,father_name,mother_name,dob,gender,branch,roll,broll,sem,category,adm_type,tfw,at,post,city,dist,state,pin,cat,cpost,ccity,cdist,cstate,cpin,mobile,email,adm_date,date
					)
					VALUES (
					?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
					)");
	
	$stmt->bind_param( 'issssiiiiiiiisssssisssssiisss', $cid,$name,$father_name,$mother_name,$dob,$gender,$branch,$roll,$broll,$sem,$category,$adm_type,$tfw,$at,$post,$city,$dist,$state,$pin,$cat,$cpost,$ccity,$cdist,$cstate,$cpin,$mobile,$email,$adm_date,$date);
	$result = $stmt->execute();
	$stmt->close();	
	
}
// Add Student Details on Database
function addNewStudent($cid,$name,$father_name,$mother_name,$dob,$gender,$branch,$sem,$category,$adm_type,$tfw,$at,$post,$city,$dist,$state,$pin,$cat,$cpost,$ccity,$cdist,$cstate,$cpin,$mobile,$email,$date) {
	global $mysqli; 
	$stmt = $mysqli->prepare("INSERT INTO students (
					cid,name,father_name,mother_name,dob,gender,branch,sem,category,adm_type,tfw,at,post,city,dist,state,pin,cat,cpost,ccity,cdist,cstate,cpin,mobile,email,date
					)
					VALUES (
					?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
					)");
	
	$stmt->bind_param( 'issssiiiiiisssssisssssiiss', $cid,$name,$father_name,$mother_name,$dob,$gender,$branch,$sem,$category,$adm_type,$tfw,$at,$post,$city,$dist,$state,$pin,$cat,$cpost,$ccity,$cdist,$cstate,$cpin,$mobile,$email,$date);
	$result = $stmt->execute();
	$stmt->close();	
	
}
function checkNoOfStudent()
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT COUNT(*) AS no 
		FROM students");
	$stmt->execute();
	$stmt->bind_result($no);
	while ($stmt->fetch()){
		$row = array('no' => $no);
		
	}
	$stmt->close();
	return ($row);
	
}
/////// Student Details
function fetchSingleStudent($mobile)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		sid,cid,name,father_name,mother_name,dob,gender,branch,roll,broll,sem,category,adm_type,tfw,at,post,city,dist,state,pin,cat,cpost,ccity,cdist,cstate,cpin,mobile,email,adm_date,date,status,photo,sign,thumb
		FROM students
		WHERE
		mobile = ?
		LIMIT 1");
	$stmt->bind_param("i", $mobile);
	$stmt->execute();
	$stmt->bind_result($sid,$cid,$name,$father_name,$mother_name,$dob,$gender,$branch,$roll,$broll,$sem,$category,$adm_type,$tfw,$at,
$post,$city,$dist,$state,$pin,$cat,$cpost,$ccity,$cdist,$cstate,$cpin,$mobile,$email,$adm_date,$date,$status,$photo,$sign,$thumb);
	while ($stmt->fetch()){
		$row = array('sid' => $sid, 'cid' => $cid, 'name' => $name,'father_name' => $father_name, 'mother_name' => $mother_name,'dob' => $dob,'gender' => $gender,'branch' => $branch,'roll' => $roll,'broll' => $broll,'sem' => $sem,'category' => $category,'adm_type' => $adm_type,'tfw' => $tfw,'at' => $at,'post' => $post,'city' => $city, 'dist' => $dist,'state' => $state,'pin' => $pin,'cat' => $cat,'cpost' => $cpost,'ccity' => $ccity, 'cdist' => $cdist,'cstate' => $cstate,'cpin' => $cpin,'mobile' => $mobile, 'email' => $email, 'adm_date' => $adm_date, 'date' => $date,'status' => $status, 'photo' => $photo, 'sign' => $sign, 'thumb' => $thumb);
		
	}
	$stmt->close();
	return ($row);
	

}

function fetchSingleStudentCid($sid)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		sid,cid,name,father_name,mother_name,dob,gender,branch,roll,broll,sem,category,adm_type,tfw,at,post,city,dist,state,pin,cat,cpost,ccity,cdist,cstate,cpin,mobile,email,adm_date,date,status,photo,sign,thumb
		FROM students
		WHERE
		sid = ?
		LIMIT 1");
	$stmt->bind_param("i", $sid);
	$stmt->execute();
	$stmt->bind_result($sid,$cid,$name,$father_name,$mother_name,$dob,$gender,$branch,$roll,$broll,$sem,$category,$adm_type,$tfw,$at,
$post,$city,$dist,$state,$pin,$cat,$cpost,$ccity,$cdist,$cstate,$cpin,$mobile,$email,$adm_date,$date,$status,$photo,$sign,$thumb);
	while ($stmt->fetch()){
		$row = array('sid' => $sid, 'cid' => $cid, 'name' => $name,'father_name' => $father_name, 'mother_name' => $mother_name,'dob' => $dob,'gender' => $gender,'branch' => $branch,'roll' => $roll,'broll' => $broll,'sem' => $sem,'category' => $category,'adm_type' => $adm_type,'tfw' => $tfw,'at' => $at,'post' => $post,'city' => $city, 'dist' => $dist,'state' => $state,'pin' => $pin,'cat' => $cat,'cpost' => $cpost,'ccity' => $ccity, 'cdist' => $cdist,'cstate' => $cstate,'cpin' => $cpin,'mobile' => $mobile, 'email' => $email, 'adm_date' => $adm_date, 'date' => $date,'status' => $status, 'photo' => $photo, 'sign' => $sign, 'thumb' => $thumb);
		
	}
	$stmt->close();
	return ($row);
	

}
///////// Grievance
//Count Grivence Particular Student
function checkNoOfGrievance($mobile)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT COUNT(*) AS no 
		FROM grievances
		WHERE
		mobile =?");
	$stmt->bind_param("i", $mobile);
	$stmt->execute();
	$stmt->bind_result($no);
	while ($stmt->fetch()){
		$row = array('no' => $no);
		
	}
	$stmt->close();
	return ($row);
}
//Count Grivence Particular Student - unsolved 
function checkNoUnsolveg($mobile)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT COUNT(*) AS no 
		FROM grievances
		WHERE
		mobile =? AND status=1");
	$stmt->bind_param("i", $mobile);
	$stmt->execute();
	$stmt->bind_result($no);
	while ($stmt->fetch()){
		$row = array('no' => $no);
		
	}
	$stmt->close();
	return ($row);
	
}
// Add Grievance on Database
function addg($mobile, $gtitle, $g,$date) {
	global $mysqli; 
	$stmt = $mysqli->prepare("INSERT INTO grievances (
					mobile,gtitle,
					g,
					date
					)
					VALUES (
					?,
					?,
					?,
					?
					)");
	
	$stmt->bind_param( 'isss', $mobile, $gtitle, $g,$date);
	$result = $stmt->execute();
	$stmt->close();	
	
}
//Fetch information of All Grievance - Admin
function fetchAllg()
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		gid, mobile,
		gtitle,g,
		status,date
		FROM grievances ORDER BY date DESC ");
	$stmt->execute();
	$stmt->bind_result($gid, $mobile,$gtitle, $g, $status, $date);
	while ($stmt->fetch()){
		$row[] = array('gid' => $gid, 'mobile' => $mobile,'gtitle' => $gtitle, 'g' => $g, 'status' => $status, 'date' => $date);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}
//Fetch information of All Grievance - Student
function fetchAllgStudent($mobile)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		gid, mobile,
		gtitle,g,
		status,date
		FROM grievances WHERE mobile= ? ORDER BY date DESC ");
	$stmt->bind_param("i", $mobile);
	$stmt->execute();
	$stmt->bind_result($gid, $mobile,$gtitle, $g, $status, $date);
	while ($stmt->fetch()){
		$row[] = array('gid' => $gid, 'mobile' => $mobile,'gtitle' => $gtitle, 'g' => $g, 'status' => $status, 'date' => $date);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}
//Fetch information for a single GID
function fetchSingleg($gid)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		gid, mobile,
		gtitle,g,
		status,extra,date
		FROM grievances
		WHERE gid = ?
		LIMIT 1");
	$stmt->bind_param("i", $gid);
	$stmt->execute();
	$stmt->bind_result($gid, $mobile,$gtitle, $g, $status, $extra,$date);
	while ($stmt->fetch()){
		$row = array('gid' => $gid, 'mobile' => $mobile,'gtitle' => $gtitle, 'g' => $g, 'status' => $status,'extra' => $extra, 'date' => $date);
		
	}
	$stmt->close();
	return ($row);
}
//Fetch All Grievance - One User
function fetchSingleUserg($mobile)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		gid, mobile,
		gtitle,g,
		status,date
		FROM grievances
		mobile = ?
		LIMIT 1");
	$stmt->bind_param("i", $mobile);
	$stmt->execute();
	$stmt->bind_result($gid, $mobile,$gtitle, $g, $status, $date);
	while ($stmt->fetch()){
		$row = array('gid' => $gid, 'mobile' => $mobile,'gtitle' => $gtitle, 'g' => $g, 'status' => $status, 'date' => $date);
		
	}
	$stmt->close();
	return ($row);
}

/////////// Grievance Solution
//Count Grivence Solution
function checkNoOfGsolution($gid)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT COUNT(*) AS no 
		FROM solution
		WHERE
		gid =?");
	$stmt->bind_param("i", $gid);
	$stmt->execute();
	$stmt->bind_result($no);
	while ($stmt->fetch()){
		$row = array('no' => $no);
		
	}
	$stmt->close();
	return ($row);
	
}
function fetchAllgSolution($gid)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		soid,gid,ans,date
		FROM solution
		WHERE
		gid =? ORDER BY soid ASC ");
	$stmt->bind_param("i", $gid);
	$stmt->execute();
	$stmt->bind_result($soid, $gid,$ans, $date);
	while ($stmt->fetch()){
		$row[] = array('soid' => $soid, 'gid' => $gid,'ans' => $ans, 'date' => $date);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}
function updatePhoto($mobile, $photo)
{
	global $mysqli;
	$stmt = $mysqli->prepare("UPDATE students
		SET photo = ?
		WHERE
		mobile = ?
		LIMIT 1");
	$stmt->bind_param("si", $photo, $mobile);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}
function updateSign($mobile, $sign)
{
	global $mysqli;
	$stmt = $mysqli->prepare("UPDATE students
		SET sign = ?
		WHERE
		mobile = ?
		LIMIT 1");
	$stmt->bind_param("si", $sign, $mobile);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}
function updateThumb($mobile, $thumb)
{
	global $mysqli;
	$stmt = $mysqli->prepare("UPDATE students
		SET thumb = ?
		WHERE
		mobile = ?
		LIMIT 1");
	$stmt->bind_param("si", $thumb, $mobile);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}
///////////// Bonafide
function checkNoOfBoYear($year)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT COUNT(*) AS no 
		FROM bonafide
		WHERE
		year =?");
	$stmt->bind_param("i", $year);
	$stmt->execute();
	$stmt->bind_result($no);
	while ($stmt->fetch()){
		$row = array('no' => $no);
		
	}
	$stmt->close();
	return ($row);
	
}
///////
// Add Bonafide Request on Database
function addboRequest($bono,$mobile, $date,$year) {
	global $mysqli; 
	$stmt = $mysqli->prepare("INSERT INTO bonafide (
					bono,mobile, date,year)
					VALUES (
					?,
					?,
					?,
					?
					)");
	
	$stmt->bind_param( 'iisi', $bono,$mobile, $date,$year);
	$result = $stmt->execute();
	$stmt->close();	
	
}
//// Check Active Bonafide Request
function checkActiveBo($mobile)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT COUNT(*) AS no 
		FROM bonafide
		WHERE
		mobile =? AND status!=0");
	$stmt->bind_param("i", $mobile);
	$stmt->execute();
	$stmt->bind_result($no);
	while ($stmt->fetch()){
		$row = array('no' => $no);
		
	}
	$stmt->close();
	return ($row);
	
}
function fetchActiveBoRequest($mobile)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		boid,bono,mobile, date,year,status,issue_date
		FROM bonafide
		WHERE
		mobile =? AND status!=0");
	$stmt->bind_param("i", $mobile);
	$stmt->execute();
	$stmt->bind_result($boid,$bono,$mobile, $date,$year,$status,$issue_date);
	while ($stmt->fetch()){
		$row = array('boid' => $boid, 'bono' => $bono,'mobile' => $mobile,'date' => $date, 'year' => $year, 'status' => $status, 'issue_date'=>$issue_date );
		
	}
	$stmt->close();
	return ($row);
}
//// Check last Bonafide Request
function checkLastBo($mobile)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT MAX( boid ) AS max FROM bonafide
WHERE mobile =?");
	$stmt->bind_param("i", $mobile);
	$stmt->execute();
	$stmt->bind_result($max);
	while ($stmt->fetch()){
		$row = array('max' => $max);
		
	}
	$stmt->close();
	return ($row);
	
}
function fetchLastBoRequest($boid)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		boid,bono,mobile, date,year,status,issue_date
		FROM bonafide
		WHERE
		boid =?");
	$stmt->bind_param("i", $boid);
	$stmt->execute();
	$stmt->bind_result($boid,$bono,$mobile, $date,$year,$status,$issue_date);
	while ($stmt->fetch()){
		$row = array('boid' => $boid, 'bono' => $bono,'mobile' => $mobile,'date' => $date, 'year' => $year, 'status' => $status, 'issue_date'=>$issue_date );
		
	}
	$stmt->close();
	return ($row);
}
////////// UPDATE LAST BONAFIDE STATUS to 0 - Close
function updateLastBoStatus($boid, $status)
{
	global $mysqli;
	$stmt = $mysqli->prepare("UPDATE bonafide
		SET status = ?
		WHERE
		boid = ?
		LIMIT 1");
	$stmt->bind_param("ii", $status, $boid);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}
function checkNoOfBoRequest($mobile)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT COUNT(*) AS no 
		FROM bonafide
		WHERE
		mobile =?");
	$stmt->bind_param("i", $mobile);
	$stmt->execute();
	$stmt->bind_result($no);
	while ($stmt->fetch()){
		$row = array('no' => $no);
		
	}
	$stmt->close();
	return ($row);
	
}
//Grievance Solution
function addGrSol($gid,$ans, $date) {
	global $mysqli; 
	$stmt = $mysqli->prepare("INSERT INTO solution (
					gid,ans, date)
					VALUES (
					?,
					?,
					?
					)");
	
	$stmt->bind_param( 'iss', $gid,$ans, $date);
	$result = $stmt->execute();
	$stmt->close();	
	
}
////////// UPDATE Grievance STATUS to 0 - Close
function updateGrStatus($gid, $status)
{
	global $mysqli;
	$stmt = $mysqli->prepare("UPDATE grievances
		SET status = ?
		WHERE
		gid = ?
		LIMIT 1");
	$stmt->bind_param("ii", $status, $gid);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}
////////////////// Library //////////
/////Books
function checkNoOfBookList()
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT COUNT(*) AS no 
		FROM book_list");
	$stmt->execute();
	$stmt->bind_result($no);
	while ($stmt->fetch()){
		$row = array('no' => $no);
		
	}
	$stmt->close();
	return ($row);
	
}
function fetchBookList()
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		bid,isbn,bname,author,publisher,edition,bcat,price,year,nop,pid,date
		FROM book_list ");
	$stmt->execute();
	$stmt->bind_result($bid,$isbn,$bname,$author,$publisher,$edition,$bcat,$price,$year,$nop,$pid,$date);
	while ($stmt->fetch()){
		$row[] = array('bid' => $bid, 'isbn' => $isbn,'bname' => $bname, 'author' => $author, 'publisher' => $publisher,'edition' => $edition, 'bcat' => $bcat,'price' => $price, 'year' => $year,'nop' => $nop, 'pid' => $pid, 'date' => $date);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}
// Add Book on Book List Database
function addBookList($isbn,$bname,$author,$publisher,$edition,$bcat,$price,$year,$nop,$pid,$date) {
	global $mysqli; 
	$stmt = $mysqli->prepare("INSERT INTO book_list (
					isbn,bname,author,publisher,edition,bcat,price,year,nop,pid,date
					)
					VALUES (
					?,
					?,
					?,
					?,?,?,?,?,?,?,?
					)");
	
	$stmt->bind_param('isssiiisiis', $isbn,$bname,$author,$publisher,$edition,$bcat,$price,$year,$nop,$pid,$date);
	$result = $stmt->execute();
	$stmt->close();	
	
}
// Add Books on Library Database
function addBookLibrary($bid,$date) {
	global $mysqli; 
	$stmt = $mysqli->prepare("INSERT INTO lib (
					bid,date
					)
					VALUES (
					?,?
					)");
	
	$stmt->bind_param('is', $bid,$date);
	$result = $stmt->execute();
	$stmt->close();	
	
}

function fetchBookLibrary()
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		DISTINCT bid
		FROM lib ");
	$stmt->execute();
	$stmt->bind_result($bid);
	while ($stmt->fetch()){
		$row[] = array('bid' => $bid);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}
function checkNoOfBookLib()
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT COUNT(*) AS no 
		FROM lib");
	$stmt->execute();
	$stmt->bind_result($no);
	while ($stmt->fetch()){
		$row = array('no' => $no);
		
	}
	$stmt->close();
	return ($row);
	
}
//Count Books on Library
function checkNoOfBook($bid)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT COUNT(*) AS no 
		FROM lib
		WHERE
		bid =?");
	$stmt->bind_param("i", $bid);
	$stmt->execute();
	$stmt->bind_result($no);
	while ($stmt->fetch()){
		$row = array('no' => $no);
		
	}
	$stmt->close();
	return ($row);
	
}
//Fetch information for a single Book
function fetchSingleBook($bid)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		bid,isbn,bname,author,publisher,edition,bcat,price,year,nop,pid,date
		FROM book_list
		WHERE
		bid = ?
		LIMIT 1");
	$stmt->bind_param("i", $bid);
	$stmt->execute();
	$stmt->bind_result($bid,$isbn,$bname,$author,$publisher,$edition,$bcat,$price,$year,$nop,$pid,$date);
	while ($stmt->fetch()){
		$row = array('bid' => $bid, 'isbn' => $isbn,'bname' => $bname, 'author' => $author, 'publisher' => $publisher,'edition' => $edition, 'bcat' => $bcat,'price' => $price, 'year' => $year,'nop' => $nop, 'pid' => $pid, 'date' => $date);
		
	}
	$stmt->close();
	return ($row);
}
////////// Book Issue

function issueBook($cid,$libid,$issue_date) {
	global $mysqli; 
	$stmt = $mysqli->prepare("INSERT INTO book_issue_details (
					cid,libid,issue_date
					)
					VALUES (
					?,?,?
					)");
	
	$stmt->bind_param('iis', $cid,$libid,$issue_date);
	$result = $stmt->execute();
	$stmt->close();	
	
}


////// ISSUE BOOK
function fetchIssueBook()
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 	boisid,
		cid,libid,issue_date,deposit_date, status
		FROM book_issue_details WHERE status=1");
	$stmt->execute();
	$stmt->bind_result($boisid,$cid,$libid,$issue_date,$deposit_date,$status);
	while ($stmt->fetch()){
		$row[] = array('boisid' => $boisid,'cid' => $cid,'libid' => $libid,'issue_date' => $issue_date,'deposit_date' => $deposit_date,'status' => $status);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

////// RETURN BOOK
function fetchReturnBooks()
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT boisid,
		cid,libid,issue_date,deposit_date, status
		FROM book_issue_details WHERE status=2");
	$stmt->execute();
	$stmt->bind_result($boisid,$cid,$libid,$issue_date,$deposit_date,$status);
	while ($stmt->fetch()){
		$row[] = array('boisid' => $boisid,'cid' => $cid,'libid' => $libid,'issue_date' => $issue_date,'deposit_date' => $deposit_date,'status' => $status);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}
///// ISSUE BOOK DETAILS - Input libid
function countSingleIssueBook($libid)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT COUNT( * ) 
FROM book_issue_details
WHERE STATUS =1
AND libid =?");
	$stmt->bind_param("i", $libid);
	$stmt->execute();
	$stmt->bind_result($no);
	while ($stmt->fetch()){
		$row = array('no' => $no);
		
	}
	$stmt->close();
	return ($row);
	
	
}
/////////////////
function fetchAllBookList($bid)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		libid,bid,date
		FROM lib WHERE bid=?");
	$stmt->bind_param('i', $bid);
	$stmt->execute();
	$stmt->bind_result($libid,$bid,$date);
	while ($stmt->fetch()){
		$row[] = array('libid' =>$libid, 'bid' => $bid, 'date' => $date);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Check if a student is valid
function checkValidStudent($cid)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT sid
		FROM students
		WHERE
		cid = ? AND status=1
		LIMIT 1");
	$stmt->bind_param("i", $cid);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}
//Check if a Book - Available
function checkonBookStatus($libid)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT boisid
		FROM book_issue_details
		WHERE
		libid = ?
		LIMIT 1");
	$stmt->bind_param("i", $libid);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}
//Check if a Book - Available for Next Issue
function checkBookStatus($libid)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT boisid
		FROM book_issue_details
		WHERE
		libid = ? AND status!=1
		LIMIT 1");
	$stmt->bind_param("i", $libid);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}
//Check if a Book ID is available on Library
function checkBookLibraryAvailable($libid)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT libid
		FROM lib
		WHERE
		libid = ?
		LIMIT 1");
	$stmt->bind_param("i", $libid);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}
///// No. of ISSUE BOOK
function countIssueBook()
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT COUNT( * ) AS no
FROM book_issue_details
WHERE STATUS =1");
	
	$stmt->execute();
	$stmt->bind_result($no);
	while ($stmt->fetch()){
		$row = array('no' => $no);
		
	}
	$stmt->close();
	return ($row);
	
	
}
///// No. of Return BOOK
function countReturnBook()
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT COUNT( * ) AS no
FROM book_issue_details
WHERE STATUS =2");
	
	$stmt->execute();
	$stmt->bind_result($no);
	while ($stmt->fetch()){
		$row = array('no' => $no);
		
	}
	$stmt->close();
	return ($row);
	
	
}

////////// Book Return

function returnBook($boisid,$deposit_date) {
	global $mysqli; 
	$stmt = $mysqli->prepare("
		UPDATE book_issue_details 
		SET deposit_date = ?, status=2
		WHERE boisid=?
		LIMIT 1");
	
	$stmt->bind_param('si', $deposit_date,$boisid);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}
///// ISSUE BOOK DETAILS - Input libid
function fetchIssueBookId($libid)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT boisid 
FROM book_issue_details
WHERE STATUS =1
AND libid =?");
	$stmt->bind_param("i", $libid);
	$stmt->execute();
	$stmt->bind_result($boisid);
	while ($stmt->fetch()){
		$row = array('boisid' => $boisid);
		
	}
	$stmt->close();
	return ($row);	
}
//Check 
function checkIssueBookStatus($libid)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT boisid 
FROM book_issue_details
WHERE STATUS =1
AND libid =?
		LIMIT 1");
	$stmt->bind_param("i", $libid);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}
//Count issued Book - Student

function checkNoOfIssueBook($cid)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT COUNT(*) AS no 
		FROM book_issue_details
		WHERE
		cid =? AND status=1");
	$stmt->bind_param("i", $cid);
	$stmt->execute();
	$stmt->bind_result($no);
	while ($stmt->fetch()){
		$row = array('no' => $no);
		
	}
	$stmt->close();
	return ($row);
}
/////// Fetch All Book Category
function fetchAllBookCategory()
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT bcid,bcname FROM bcat");
	$stmt->execute();
	$stmt->bind_result($bcid,$bcname);
	while ($stmt->fetch()){
		$row[] = array('bcid' => $bcid,'bcname' => $bcname);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}
/////// Fetch All Branch
function fetchAllBranch()
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT bid,bname FROM branch");
	$stmt->execute();
	$stmt->bind_result($bid,$bname);
	while ($stmt->fetch()){
		$row[] = array('bid' => $bid,'bname' => $bname);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}
//Check Book Place
function checkBookPlace($bcid)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT pid 
FROM place
WHERE  bcid =?
		LIMIT 1");
	$stmt->bind_param("i", $bcid);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}
/////////////////
// All Place from One Category
function fetchAllPlace($bcid)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		pid,pcode,bcid
		FROM place WHERE bcid=?");
	$stmt->bind_param('i', $bcid);
	$stmt->execute();
	$stmt->bind_result($pid,$pcode,$bcid);
	while ($stmt->fetch()){
		$row[] = array('pid' =>$pid, 'pcode' => $pcode, 'bcid' => $bcid);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}
//Fetch Single Place Details
function fetchSinglePlace($pid)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		pid, pcode,bcid
		FROM place WHERE
		pid = ?
		LIMIT 1");
	$stmt->bind_param("i", $pid);
	$stmt->execute();
	$stmt->bind_result($pid, $pcode,$bcid);
	while ($stmt->fetch()){
		$row = array('pid' => $pid, 'pcode' => $pcode,'bcid' => $bcid);
		
	}
	$stmt->close();
	return ($row);
}
/////////////
//Checks if a student withdraw book(s)
function studentBooksExists($cid)
{
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT *
		FROM book_issue_details
		WHERE
		cid = ?
		LIMIT 1");
	$stmt->bind_param("i", $cid);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}
// All Place from One Category
function fetchAllIssueBook($cid)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		libid,cid,issue_date,deposit_date
		FROM book_issue_details WHERE cid=?");
	$stmt->bind_param('i', $cid);
	$stmt->execute();
	$stmt->bind_result($libid,$cid,$issue_date,$deposit_date);
	while ($stmt->fetch()){
		$row[] = array('libid' =>$libid, 'cid' => $cid, 'issue_date' => $issue_date, 'deposit_date' => $deposit_date);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}
// Add Branch - Database
function addBranch($bname) {
	global $mysqli; 
	$stmt = $mysqli->prepare("INSERT INTO branch (bname)
					VALUES (?)");
	
	$stmt->bind_param('s', $bname);
	$result = $stmt->execute();
	$stmt->close();	
	
}
// Add Book Category - Database
function addBookCategory($bcname) {
	global $mysqli; 
	$stmt = $mysqli->prepare("INSERT INTO bcat (bcname)
					VALUES (?)");
	
	$stmt->bind_param('s', $bcname);
	$result = $stmt->execute();
	$stmt->close();	
	
}
function fetchAllBookPlace()
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT place.pid, place.pcode, place.bcid, bcat.bcname
FROM place
JOIN bcat ON place.bcid = bcat.bcid");
	$stmt->execute();
	$stmt->bind_result($pid,$pcode,$bcid,$bcname);
	while ($stmt->fetch()){
		$row[] = array('pid' => $pid,'pcode' => $pcode,'bcid' => $bcid,'bcname' => $bcname);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}
///////////// DELETE NOTICE
//Fetch information for a single Notice
function deleteNotice($id)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("DELETE
		FROM
		notice
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->close();
}
// Add Fee Details on Database
function addPay($sid,$cid,$pcode,$trno,$brno,$amount,$authstatus,$txndate,$date) {
	global $mysqli; 
	$stmt = $mysqli->prepare("INSERT INTO fee_collection (sid,cid,pcode,trno,brno,amount,authstatus,txndate,date
					)
					VALUES (?,?,?,?,?,?,?,?,?)");
	
	$stmt->bind_param( 'iiissiiss', $sid,$cid,$pcode,$trno,$brno,$amount,$authstatus,$txndate,$date);
	$result = $stmt->execute();
	$stmt->close();	
	
}
// All 
function fetchPayDetails($fid)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT * FROM fee_collection WHERE fid=?");
	$stmt->bind_param('i', $fid);
	$stmt->execute();
	$stmt->bind_result($fid,$sid,$cid,$pcode,$trno,$brno,$amount,$authstatus,$txndate,$date);
	while ($stmt->fetch()){
		$row = array('fid' => $fid,'sid' => $sid,'cid' => $cid, 'pcode' => $pcode,'trno' => $trno, 'brno' => $brno, 'amount' => $amount, 'authstatus' => $authstatus, 'txndate' => $txndate, 'date' => $date);
		
	}
	$stmt->close();
	return ($row);
}
/// Fetch Single Student
function fetchSingleStudentPay($sid)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT * FROM fee_collection WHERE sid=?");
	$stmt->bind_param('i', $sid);
	$stmt->execute();
	$stmt->bind_result($fid,$sid,$cid,$pcode,$trno,$brno,$amount,$authstatus,$txndate,$date);
	while ($stmt->fetch()){
		$row[] = array('fid' => $fid,'sid' => $sid,'cid' => $cid, 'pcode' => $pcode,'trno' => $trno, 'brno' => $brno, 'amount' => $amount, 'authstatus' => $authstatus, 'txndate' => $txndate, 'date' => $date);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Fetch information of All Fee Collection
function fetchAllFee()
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT fid,fee_collection.sid,fee_collection.cid,pcode,trno,brno,amount,authstatus,txndate,fee_collection.date, name, mobile,email,broll,roll FROM fee_collection LEFT JOIN students ON fee_collection.sid = students.sid WHERE fee_collection.pcode=1 ORDER BY fid DESC");
	$stmt->execute();
	$stmt->bind_result($fid,$sid,$cid,$pcode,$trno,$brno,$amount,$authstatus,$txndate,$date,$name,$mobile,$email,$broll,$roll);
	while ($stmt->fetch()){
		$row[] = array('fid' => $fid,'sid' => $sid,'cid' => $cid, 'pcode' => $pcode,'trno' => $trno, 'brno' => $brno, 'amount' => $amount, 'authstatus' => $authstatus, 'txndate' => $txndate, 'date' => $date, 'name' => $name, 'mobile' => $mobile, 'email' => $email, 'broll' => $broll, 'roll' => $roll);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Fetch information of Second Fee Collection
function fetchSecondFee()
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT fid,fee_collection.sid,fee_collection.cid,pcode,trno,brno,amount,authstatus,txndate,fee_collection.date, name, mobile,email,broll,roll FROM fee_collection LEFT JOIN students ON fee_collection.sid = students.sid WHERE fee_collection.pcode=3  ORDER BY fid DESC");
	$stmt->execute();
	$stmt->bind_result($fid,$sid,$cid,$pcode,$trno,$brno,$amount,$authstatus,$txndate,$date,$name,$mobile,$email,$broll,$roll);
	while ($stmt->fetch()){
		$row[] = array('fid' => $fid,'sid' => $sid,'cid' => $cid, 'pcode' => $pcode,'trno' => $trno, 'brno' => $brno, 'amount' => $amount, 'authstatus' => $authstatus, 'txndate' => $txndate, 'date' => $date, 'name' => $name, 'mobile' => $mobile, 'email' => $email, 'broll' => $broll, 'roll' => $roll);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}
/////// Student Details
function fetchAllStudent()
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
		sid,cid,name,father_name,mother_name,dob,gender,branch,roll,broll,sem,category,adm_type,tfw,at,post,city,dist,state,pin,cat,cpost,ccity,cdist,cstate,cpin,mobile,email,adm_date,date,status,photo,sign,thumb
		FROM students");
	$stmt->execute();
	$stmt->bind_result($sid,$cid,$name,$father_name,$mother_name,$dob,$gender,$branch,$roll,$broll,$sem,$category,$adm_type,$tfw,$at,
$post,$city,$dist,$state,$pin,$cat,$cpost,$ccity,$cdist,$cstate,$cpin,$mobile,$email,$adm_date,$date,$status,$photo,$sign,$thumb);
	while ($stmt->fetch()){
		$row[] = array('sid' => $sid, 'cid' => $cid, 'name' => $name,'father_name' => $father_name, 'mother_name' => $mother_name,'dob' => $dob,'gender' => $gender,'branch' => $branch,'roll' => $roll,'broll' => $broll,'sem' => $sem,'category' => $category,'adm_type' => $adm_type,'tfw' => $tfw,'at' => $at,'post' => $post,'city' => $city, 'dist' => $dist,'state' => $state,'pin' => $pin,'cat' => $cat,'cpost' => $cpost,'ccity' => $ccity, 'cdist' => $cdist,'cstate' => $cstate,'cpin' => $cpin,'mobile' => $mobile, 'email' => $email, 'adm_date' => $adm_date, 'date' => $date,'status' => $status, 'photo' => $photo, 'sign' => $sign, 'thumb' => $thumb);
		
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}

}

function gender($i)
	{
		switch ($i)
		{
			case 1: $sex="Male";
			break;
			case 2 : $sex="Female";
			break;
			default : $sex="Other";
			break;
		
		}
		return $sex;
	}
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
				$session = date( "Y-m-d", strtotime($student['adm_date']));//existing date
				$sessionEnd =  date('Y-m-d', strtotime($session .'+2 years')); //added +3 years along with the $date
			break;
		
		}
		
		return array($adm_type,$session,$sessionEnd);
	}
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
	
	function fetchAllStudentFee($adm_date)
{
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT students.sid,students.cid,students.name,students.father_name,students.branch,students.roll,students.broll,students.sem,students.category,students.adm_type,students.tfw,students.mobile,students.email,students.adm_date,students.date, fee_collection.txndate FROM students LEFT JOIN fee_collection ON students.sid=fee_collection.sid WHERE fee_collection.txndate=CAST(? AS DATE)");
	
	$stmt->bind_param("s", $adm_date);
	$stmt->execute();
	$stmt->bind_result($sid,$cid,$name,$father_name,$branch,$roll,$broll,$sem,$category,$adm_type,$tfw,$mobile,$email,$adm_date,$date,$txndate);
	while ($stmt->fetch()){
		$row[] = array('sid' => $sid, 'cid' => $cid, 'name' => $name,'father_name' => $father_name, 'branch' => $branch,'roll' => $roll,'broll' => $broll,'sem' => $sem,'category' => $category,'adm_type' => $adm_type,'tfw' => $tfw,'mobile' => $mobile, 'email' => $email, 'adm_date' => $adm_date, 'date' => $date, 'txndate'=>$txndate);
		
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}

}
?>