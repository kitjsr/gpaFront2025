<?php

/*
%m1% - Dymamic markers which are replaced at run time by the relevant index.
*/

$lang = array();

//Account
$lang = array_merge($lang,array(
	"ACCOUNT_SPECIFY_USERNAME" 		=> "Please enter your username",
	"ACCOUNT_SPECIFY_USERNAME_ST" 		=> "Please Enter Mobile No.",
	"ACCOUNT_SPECIFY_MOBILE" 		=> "Please enter your mobile no.",
	"ACCOUNT_SPECIFY_PASSWORD" 		=> "Please Enter Password",
	"ACCOUNT_SPECIFY_EMAIL"			=> "Please enter your email address",
	"ACCOUNT_INVALID_EMAIL"			=> "Invalid E-Mail Address",
	"ACCOUNT_USER_OR_EMAIL_INVALID"		=> "Username or email address is invalid",
	"ACCOUNT_USER_OR_PASS_INVALID"		=> "Username or password is invalid",
	"ACCOUNT_USER_OR_PASS_INVALID"		=> "Username or password is invalid",
	"ACCOUNT_EMAIL_OR_MOBILE_INVALID"		=> "E-Mail Id or Mobile No. is invalid",
	"ACCOUNT_MOBILE_OR_PASS_INVALID"	=>	"Mobile No. or Password is invalid.",
	"ACCOUNT_ALREADY_ACTIVE"		=> "Your account is already activated",
	"ACCOUNT_INACTIVE"			=> "Your account is in-active. Check your emails / spam folder for account activation instructions",
	"ACCOUNT_USER_CHAR_LIMIT"		=> "Your username must be between %m1% and %m2% characters in length",
	"ACCOUNT_DISPLAY_CHAR_LIMIT"		=> "Your display name must be between %m1% and %m2% characters in length",
	"FATHER_NAME_CHAR_LIMIT"		=> "Your Father's name must be between %m1% and %m2% characters in length",
	"ACCOUNT_PASS_CHAR_LIMIT"		=> "Your password must be between %m1% and %m2% characters in length",
	"MOBILE_CHAR_LIMIT"		=> "Your mobile no. must be  %m1% digits",
	"ACCOUNT_TITLE_CHAR_LIMIT"		=> "Titles must be between %m1% and %m2% characters in length",
	"ACCOUNT_PASS_MISMATCH"			=> "Your password and confirmation password must match",
	"ACCOUNT_DISPLAY_INVALID_CHARACTERS"	=> "Display name can only include alpha-numeric characters",
	"ACCOUNT_USERNAME_IN_USE"		=> "Username %m1% is already in use",
	"ACCOUNT_DISPLAYNAME_IN_USE"		=> "Display name %m1% is already in use",
	"ACCOUNT_EMAIL_IN_USE"			=> "Email %m1% is already in use",
	"ACCOUNT_LINK_ALREADY_SENT"		=> "An activation email has already been sent to this email address in the last %m1% hour(s)",
	"ACCOUNT_NEW_ACTIVATION_SENT"		=> "We have emailed you a new activation link, please check your email",
	"ACCOUNT_SPECIFY_NEW_PASSWORD"		=> "Please enter your new password",	
	"ACCOUNT_SPECIFY_CONFIRM_PASSWORD"	=> "Please confirm your new password",
	"ACCOUNT_NEW_PASSWORD_LENGTH"		=> "New password must be between %m1% and %m2% characters in length",	
	"ACCOUNT_PASSWORD_INVALID"		=> "Current password doesn't match the one we have on record",	
	"ACCOUNT_DETAILS_UPDATED"		=> "Account details updated",
	"ACCOUNT_ACTIVATION_MESSAGE"		=> "You will need to activate your account before you can login. Please follow the link below to activate your account. \n\n
	%m1%activate-account.php?token=%m2%",							
	"ACCOUNT_ACTIVATION_COMPLETE"		=> "You have successfully activated your account. You can now login <a href=\"login.php\">here</a>.",
	
	"ACCOUNT_REGISTRATION_COMPLETE_TYPE1"	=> "You have successfully registered. You can now login <a href=\"student_login.php\">here</a>.",
	"ACCOUNT_REGISTRATION_COMPLETE_TYPE3"	=> "New user successfully registered. You can login <a href=\"adm_login.php\">here</a>.",
	"ACCOUNT_REGISTRATION_COMPLETE_TYPE2"	=> "You have successfully registered. You will soon receive an activation email. 
	You must activate your account before logging in.",
	"ACCOUNT_PASSWORD_NOTHING_TO_UPDATE"	=> "You cannot update with the same password",
	"ACCOUNT_PASSWORD_UPDATED"		=> "Account password updated",
	"ACCOUNT_EMAIL_UPDATED"			=> "Account email updated",
	"ACCOUNT_TOKEN_NOT_FOUND"		=> "Token does not exist / Account is already activated",
	"ACCOUNT_USER_INVALID_CHARACTERS"	=> "Username can only include alpha-numeric characters",
	"ACCOUNT_DELETIONS_SUCCESSFUL"		=> "You have successfully deleted %m1% users",
	"ACCOUNT_MANUALLY_ACTIVATED"		=> "%m1%'s account has been manually activated",
	"ACCOUNT_DISPLAYNAME_UPDATED"		=> "Displayname changed to %m1%",
	"ACCOUNT_TITLE_UPDATED"			=> "%m1%'s title changed to %m2%",
	"ACCOUNT_PERMISSION_ADDED"		=> "Added access to %m1% permission levels",
	"ACCOUNT_PERMISSION_REMOVED"		=> "Removed access from %m1% permission levels",
	"ACCOUNT_PERMISSION_CHANGED"		=> "Account permission changed.",
	"ACCOUNT_INVALID_USERNAME"		=> "Invalid username",
	));

//Configuration
$lang = array_merge($lang,array(
	"CONFIG_NAME_CHAR_LIMIT"		=> "Site name must be between %m1% and %m2% characters in length",
	"CONFIG_URL_CHAR_LIMIT"			=> "Site name must be between %m1% and %m2% characters in length",
	"CONFIG_EMAIL_CHAR_LIMIT"		=> "Site name must be between %m1% and %m2% characters in length",
	"CONFIG_ACTIVATION_TRUE_FALSE"		=> "Email activation must be either `true` or `false`",
	"CONFIG_ACTIVATION_RESEND_RANGE"	=> "Activation Threshold must be between %m1% and %m2% hours",
	"CONFIG_LANGUAGE_CHAR_LIMIT"		=> "Language path must be between %m1% and %m2% characters in length",
	"CONFIG_LANGUAGE_INVALID"		=> "There is no file for the language key `%m1%`",
	"CONFIG_TEMPLATE_CHAR_LIMIT"		=> "Template path must be between %m1% and %m2% characters in length",
	"CONFIG_TEMPLATE_INVALID"		=> "There is no file for the template key `%m1%`",
	"CONFIG_EMAIL_INVALID"			=> "The email you have entered is not valid",
	"CONFIG_INVALID_URL_END"		=> "Please include the ending / in your site's URL",
	"CONFIG_UPDATE_SUCCESSFUL"		=> "Your site's configuration has been updated. You may need to load a new page for all the settings to take effect",
	));

//Forgot Password
$lang = array_merge($lang,array(
	"FORGOTPASS_INVALID_TOKEN"		=> "Your activation token is not valid",
	"FORGOTPASS_NEW_PASS_EMAIL"		=> "We have emailed you a new password",
	"FORGOTPASS_REQUEST_CANNED"		=> "Lost password request cancelled",
	"FORGOTPASS_REQUEST_EXISTS"		=> "There is already a outstanding lost password request on this account",
	"FORGOTPASS_REQUEST_SUCCESS"		=> "We have emailed you instructions on how to regain access to your account",
	));

//Mail
$lang = array_merge($lang,array(
	"MAIL_ERROR"				=> "Fatal error attempting mail, contact your server administrator",
	"MAIL_TEMPLATE_BUILD_ERROR"		=> "Error building email template",
	"MAIL_TEMPLATE_DIRECTORY_ERROR"		=> "Unable to open mail-templates directory. Perhaps try setting the mail directory to %m1%",
	"MAIL_TEMPLATE_FILE_EMPTY"		=> "Template file is empty... nothing to send",
	));

//Miscellaneous
$lang = array_merge($lang,array(
	"CAPTCHA_FAIL"				=> "Failed Security Question",
	"CONFIRM"				=> "Confirm",
	"DENY"					=> "Deny",
	"SUCCESS"				=> "Success",
	"ERROR"					=> "Error",
	"NOTHING_TO_UPDATE"			=> "Nothing to update",
	"SQL_ERROR"				=> "Fatal SQL error",
	"FEATURE_DISABLED"			=> "This feature is currently disabled",
	"PAGE_PRIVATE_TOGGLED"			=> "This page is now %m1%",
	"PAGE_ACCESS_REMOVED"			=> "Page access removed for %m1% permission level(s)",
	"PAGE_ACCESS_ADDED"			=> "Page access added for %m1% permission level(s)",
	));

//Permissions
$lang = array_merge($lang,array(
	"PERMISSION_CHAR_LIMIT"			=> "Permission names must be between %m1% and %m2% characters in length",
	"PERMISSION_NAME_IN_USE"		=> "Permission name %m1% is already in use",
	"PERMISSION_DELETIONS_SUCCESSFUL"	=> "Successfully deleted %m1% permission level(s)",
	"PERMISSION_CREATION_SUCCESSFUL"	=> "Successfully created the permission level `%m1%`",
	"PERMISSION_NAME_UPDATE"		=> "Permission level name changed to `%m1%`",
	"PERMISSION_REMOVE_PAGES"		=> "Successfully removed access to %m1% page(s)",
	"PERMISSION_ADD_PAGES"			=> "Successfully added access to %m1% page(s)",
	"PERMISSION_REMOVE_USERS"		=> "Successfully removed %m1% user(s)",
	"PERMISSION_ADD_USERS"			=> "Successfully added %m1% user(s)",
	"CANNOT_DELETE_NEWUSERS"		=> "You cannot delete the default 'new user' group",
	"CANNOT_DELETE_ADMIN"			=> "You cannot delete the default 'admin' group",
	));
	
//Permissions
$lang = array_merge($lang,array(
	"FRIEND_NAME_CHAR_LIMIT"		=> "Your Friend's Name must be between %m1% and %m2% characters in length",
	"MOBILE_NO_CHAR_LIMIT"		=> "Enter a valid mobile no.",	
	"SUCCESSFULLY_REFER"		=> "You successfully send a referal message about ISDP",	
	
	));
//Event
$lang = array_merge($lang,array(
	"EVENT_NAME"		=> "Please enter event's name",
	"EVENT_TYPE"		=> "Please select type of event",	
	"DATE_RANGE"		=> "Please select date range.",
	"DATE_1"		=> "Please enter start date.",
	"DATE_2"		=> "Please enter end date.",
	"SUCCESSFULLY_ADD_EVENT"		=> "Successfully add event details",	
	
	));
	
//View Contacts
$lang = array_merge($lang,array(
	"CHOOSE_CLASS"		=> "Please choose class from list.",
	"CHOOSE_SECTION"		=> "Please choose section from list",	
	
	));
	
//Notice
$lang = array_merge($lang,array(
	
	"ADD_TITLE"		=> "Please enter notice title",
	"NOTICE_ADD_SUCCESSFUL"		=> "Notice successfully add.",
	"NOTICE_CHAR_LIMIT"			=> "Notice title must be between %m1% and %m2% characters in length",
	"TITLE_UPDATED"		=> "Title changed to `%m1%`",
	"NOTICE_UPDATED"		=> "Notice changed successfully.",
	"DISPLAY_ON_HOME_UPDATED"		=> "Display on Home setting changed successfully.",
	"NEW_ICON_SETTING_UPDATED"		=> "New icon changed successfully.",
	
	));
	
//$lang = array();

//CREATE CONTACT
$lang = array_merge($lang,array(
	"PLEASE_ENTER_ADM_NO" 		=> "Please enter Student's Admission No.",
	"PLEASE_ENTER_NAME" 		=> "Please Enter Your Name",
	"PLEASE_ENTER_FATHER_NAME" 		=> "Please Enter Father's Name",
	"PLEASE_ENTER_CLASS" 		=> "Please enter Class",
	"PLEASE_ENTER_SECTION" 		=> "Please enter Section",
	"PLEASE_ENTER_ROLL_NO" 		=> "Please enter Roll No.",
	"PLEASE_ENTER_MOBILE" 		=> "Please Enter Mobile No.",
	"ADM_NO_ALREADY_AVAILABLE" 		=> "Admission No. Already Available.",
	"ROLL_NO_EXISTS"		=> "This Roll No. Already Registered on This Class AND Section",
	"MOBILE_CHAR_LIMIT"			=> "Mobile No. `%m1%` characters in length",
	"CONTACT_ADD_SUCCESSFUL"		=> "Student Details Stored in Database.",
	"STAFF_CONTACT_ADD_SUCCESSFUL"		=> "Staff Details Stored in Database.",
	"CAMPUS_UPDATED"			=> "Campus changed to `%m1%`",
	"NAME_UPDATED"			=> "Name changed to `%m1%`",
	"FATHER_NAME_UPDATED"			=> "Father's Name changed to `%m1%`",
	"DOB_UPDATED"			=> "Date of Birth changed to `%m1%`",
	"CLASS_UPDATED"			=> "Class changed to Class `%m1%`",
	"SECTION_UPDATED"			=> "Section changed to `%m1%`",
	"TYPE_UPDATED"			=> "Student Type changed to `%m1%`",
	"ROLLNO_UPDATED"			=> "Roll No. changed to `%m1%`",
	"MOBILE_P_UPDATED"			=> "Primary Mobile changed to `%m1%`",
	"MOBILE_S_UPDATED"			=> "Secondary Mobile changed to `%m1%`",
	"EMAIL_P_UPDATED"			=> "Primary E-Mail changed to `%m1%`",
	"EMAIL_S_UPDATED"			=> "Secondary E-Mail changed to `%m1%`",
	"SEND_SMS_TO_CLASS_SECTION_TYPE"		=> "Send Message to %m1% ",
	));
	
// Event
$lang = array_merge($lang,array(
	
	"EVENT_NAME_UPDATED"		=> "Event name successfully update.",
	"EVENT_TYPE_UPDATED"		=> "Event type successfully update.",
	"EVENT_DATE_UPDATED"			=> "Event date range update - %m1% to %m2%.",
	));
	
// Admission
$lang = array_merge($lang,array(
	
	"PLEASE_ENTER_MOTHER_NAME"		=> "Please Enter Mother's Name.",
	"PLEASE_ENTER_DOB"		=> "Please Enter Date of Birth.",
	"PLEASE_ENTER_AT"		=>	"Please Enter Permanent Address - At/Vill.",
	"PLEASE_ENTER_POST"		=>	"Please Enter Permanent Address - Post.",
	"PLEASE_ENTER_CITY"		=>	"Please Enter Permanent Address - City.",
	"PLEASE_ENTER_DIST"		=>	"Please Enter Permanent Address - Dist.",
	"PLEASE_ENTER_STATE"		=>	"Please Enter Permanent Address - State.",
	"PLEASE_ENTER_PIN"		=>	"Please Enter Permanent Address - Pin.",
	"PLEASE_ENTER_CAT"		=>	"Please Enter Present Address - At/vill.",
	"PLEASE_ENTER_CPOST"		=>	"Please Enter Present Address - Post.",
	"PLEASE_ENTER_CCITY"		=>	"Please Enter Present Address - City.",
	"PLEASE_ENTER_CDIST"		=>	"Please Enter Present Address - Dist.",
	"PLEASE_ENTER_CSTATE"		=>	"Please Enter Present Address - State.",
	"PLEASE_ENTER_CPIN"		=>	"Please Enter Present Address - Pin.",
	"PERSONAL_DETAILS_SAVE_SUCCESSFUL"			=> "Personal details save successfully.",
	"PLEASE_CHOOSE_CLASS"		=> "Please choose class.",
	"PLEASE_CHOOSE_HOSTEL"		=> "Do you require hostel facility for your child?.",
	"PLEASE_CHOOSE_TRANSPORT"		=> "Do you require transport facility for your child?.",
	"PLEASE_CHOOSE_TRANSPORT_AREA"		=> "Please choose transport area.",
	"PLEASE_ENTER_LAST_SCHOOL"		=> "Please enter name of the school.",
	"PLEASE_CHOOSE_RESULT"		=> "Please choose result.",
	"PLEASE_ENTER_PERCENTAGE"		=> "Please enter percentage.",
	"EMPTY_FILE"		=> "Empty File.",
	"UNSUPPORTED_FILE"		=> "Unsupported File Format. Only JPG/JPEG/PNG file accept.",
	"FINALLY_SUBMIT_SUCCESSFUL"		=> "Trainee application finally submit. Please wait for approval.",
	"PLEASE_CHOOSE_GENDER"	=>	"Please Choose Gender",
	"PLEASE_CHOOSE_CATEGORY"	=>	"Please Choose Category",
	));
	
	// NGO""
$lang = array_merge($lang,array(
	
	"PLEASE_ENTER_NAME_OF_DIRECTOR"		=> "Please Enter Director's Name.",
	"PLEASE_ENTER_NAME_OF_BRANCH"		=> "Please Enter Branch Name.",
	"PLEASE_ENTER_BRANCH_CODE"		=> "Please Enter Branch Code.",
	"PLEASE_ENTER_PROG_NAME"		=> "Please Enter Program Name.",
	"PLEASE_ENTER_ID_NO"		=> "Please Enter ID No.",
	"PLEASE_CHOOSE_ID_TYPE"		=> "Please Choose ID Type.",
	"PLEASE_CHOOSE_TYPE"		=> "Please Choose Program Type.",
	"PLEASE_CHOOSE_DURATION"		=> "Please Choose Program Duration.",
	"PLEASE_SELECT_BRANCH"		=> "Please Choose Branch.",
	"PLEASE_SELECT_BATCH"		=> "Please Choose Batch.",
	"PLEASE_SELECT_PROGRAM"		=> "Please Choose Program.",
	"PLEASE_SELECT_TRAINER"		=> "Please Choose Trainer.",
	"PLEASE_SELECT_QUALIFICATION"		=> "Please Choose Qualification.",
	"PLEASE_SELECT_OCCUPTION"		=> "Please Choose Occuption.",
	"PLEASE_ENTER_NAME_OF_TRAINER"		=> "Please Enter Trainer's Name.",
	"INVALID_EMAIL"		=> "Invalid E-Mail Address.",
	"PLEASE_SELECT_DAYS"		=> "Please Choose Min. 1 Day.",
	"SUCCESSFULLY_APPROVED"		=> "Successfully Approved.",
	"BATCH_CLOSE_SUCCESSFUL"		=> "Successfully Close Batch.",
	"BRANCH_ADD_SUCCESSFUL"		=> "Successfully Add Branch Details.",
	"PROG_ADD_SUCCESSFUL"		=> "Successfully Add Program Details.",
	"BATCH_ADD_SUCCESSFUL"		=> "Successfully Add Batch Details.",
	"TRAINER_ADD_SUCCESSFUL"		=> "Successfully Add Trainer Details.",
	"MESSAGE_NOT_BLANK"			=> "Blank Message not sent.",
	"MESSAGE_SENT_SUCCESSFUL"		=>	"Message Successfully Sent.",
	"PLEASE_SELECT_MIN_ONE_PROGRAM"	=>	"Please Select Min. 1 Program",
	"PLEASE_ENTER_CHAPTER_NO"		=>	"Please Enter Chapter No.",
	"PLEASE_ENTER_CHAPTER_NAME"		=>	"Please Enter Chapter Name",
	"NOTES_UPLOAD_SUCCESSFUL"		=>		"Notes Successfully Uploaded.",
	"NOTES_ALREADY_AVAILABLE"		=>		"This Notes already uploaded. You can check <a href=\"notes.php\">here</a>.",
	"UNSUPPORTED_DOC_FILE"		=> "Unsupported Document File Format. Only doc/docx/pdf file accept.",
	"MOBILE_ALREADY_EXISTS"		=>	"This Mobile No. Already Registered.",
	"PLEASE_CHOOSE_ONE_STUDENT"	=>	"Please Choose Min. 1 Student then Click - Send Alert!",
	"PLEASE_ENTER_MOBILE"		=>	"Please Enter Mobile No..",
	"PLEASE_ENTER_DOB"	=>	"Please Enter Date of Birth.",
	"ACCOUNT_MOBILE_OR_DOB_INVALID"	=>	"Please Enter Valid Mobile No./Date of Birth!",
	"INVALID_MOBILE"	=>	"Invalid Mobile No. ",
	"CHHOSE_ADM_TYPE"	=>	"Please Choose Admission Type.",
	"CHOOSE_BRANCH"	=>	"Please Choose Branch.",
	"CHOOSE_SEM"	=>	"Please Choose Semester.",
	"ENTER_BROLL"	=>	"Please Enter Board Roll No.",
	"ENTER_ROLL"	=>	"Please Enter Class Roll.",
	"ENTER_ADM_DATE"	=>	"Please Enter Admission Date.",
	"ADD_G_DETAILS"	=>	"Enter Grievance Details.",
	"ADD_G_TITLE"	=>	"Enter Grievance Title.",
	"G_ADD_SUCCESSFUL"	=>	"Grievance Successfully Submit.",
	"BONAFIDE_REQUEST"	=>	"Bonafide Request Successfully Sent.",
	"BO_REQUEST_DIFF"	=>	"You can apply Bonafide Certificate after 2 Months.",
	"CHOOSE_NOTICE"		=>	"Choose Notice File",
	"FILE_FORMAT_NOT_SUPPORTED"		=>	"File Format - pdf/doc/docx only.",
	"FILE_SIZE_ISSUE"		=>	"File Size Exceed 5MB.",
	"ENTER_ISBN"		=>	"Enter Book ISBN.",
	"ENTER_BNAME"		=>	"Enter Book Name.",
	"ENTER_BRANCH_NAME"		=>	"Enter Branch Name.",
	"ENTER_AUTHOR"		=>	"Enter Book Author.",
	"ENTER_PUBLISHER"		=>	"Enter Book Publisher.",
	"ENTER_EDITION"		=>	"Enter Book Edition.",
	"CHOOSE_CATEGORY"		=>	"Choose Book Category.",
	"ENTER_PRICE"		=>	"Enter Book Price.",
	"ENTER_YEAR"		=>	"Enter Book Published Year.",
	"ENTER_PRICE"		=>	"Enter Book Price.",
	"BOOK_ADD_SUCCESSFUL"		=>	"Book Details Sucessfully Submit.",
	"BRANCH_ADD_SUCCESSFUL"		=>	"Branch Sucessfully Submit.",
	"BCAT_ADD_SUCCESSFUL"		=>	"Book Category Sucessfully Submit.",
	"ENTER_QUANTITY"		=>	"Enter Book Quantity.",
	"CHOOSE_BOOK"		=>	"Choose Any Book.",
	"Choose Rack"		=>	"Choose Book Rack.",
	"ENTER_COLLEGE_ID"		=>	"Enter College Id.",
	"ENTER_BOOK_ID"		=>	"Enter Library Book Id.",
	"ENTER_BC_NAME"		=>	"Enter Book Name.",
	"BOOK_ISSUE_SUCCESSFUL"		=>	"Book Issue Successfully.",
	"BOOK_RETURN_SUCCESSFUL"		=>	"Book Return Successfully.",
	"INVALID_STUDENT"		=>	"Invalid Student.",
	"BOOK_NOT_AVAILABLE"		=>	"Book Not Available.",
	"CHOOSE_PLACE"		=>	"Choose Book Place.",
	"ENTER_NO_OF_PAGE"		=>	"Enter No. of Book Pages.",
	"INVALID_BOOK_ID"		=>	"Enter Valid Book Id.",
	"INVALID_BOOK"		=>	"Invalid Book.",
	));

// QUIZ
$lang = array_merge($lang,array(
	
	"ADD_QUESTION"		=> "Please Enter Question.",
	"ADD_OPTION1"		=> "Please Enter Option I.",
	"ADD_OPTION2"		=> "Please Enter Option II.",
	"ADD_OPTION3"		=> "Please Enter Option III.",
	"ADD_OPTION4"		=> "Please Enter Option IV.",
	"ADD_ANS"			=> "Please Choose Answer.",
	"QUESTION_ADD_SUCCESSFUL"		=> "Question Successfully Add.",
	));

?>