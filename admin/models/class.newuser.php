<?php
class User 
{
	public $user_active = 0;
	private $clean_email;
	public $status = false;
	private $clean_password;
	private $username;
	private $displayname;
	public $sql_failure = false;
	public $mail_failure = false;
	public $email_taken = false;
	public $username_taken = false;
	public $displayname_taken = false;
	public $activation_token = 0;
	public $success = NULL;
	public $permission;
	
	function __construct($user,$display,$pass,$email,$permission)
	{
		//Used for display only
		$this->displayname = $display;
		
		$this->permission = $permission;
		//Sanitize
		$this->clean_email = sanitize($email);
		$this->clean_password = trim($pass);
		$this->username = sanitize($user);
		
		if(usernameExists($this->username))
		{
			$this->username_taken = true;
		}
		/*
		else if(displayNameExists($this->displayname))
		{
			$this->displayname_taken = true;
		}
		*/
		else if(emailExists($this->clean_email))
		{
			$this->email_taken = true;
		}
		else
		{
			//No problems have been found.
			$this->status = true;
		}
	}
	
	public function userCakeAddUser()
	{
		global $mysqli,$emailActivation,$websiteUrl,$db_table_prefix;
		
		//Prevent this function being called if there were construction errors
		if($this->status)
		{
			//Construct a secure hash for the plain text password
			$secure_pass = generateHash($this->clean_password);
			
			//Construct a unique activation token
			$this->activation_token = generateActivationToken();
			
			//Do we need to send out an activation email?
			if($emailActivation == "true")
			{
				//User must activate their account first
				$this->user_active = 0;
				
				$mail = new userCakeMail();
				
				//Build the activation message
				$activation_message = lang("ACCOUNT_ACTIVATION_MESSAGE",array($websiteUrl,$this->activation_token));
				
				//Define more if you want to build larger structures
				$hooks = array(
					"searchStrs" => array("#ACTIVATION-MESSAGE","#ACTIVATION-KEY","#USERNAME#"),
					"subjectStrs" => array($activation_message,$this->activation_token,$this->displayname)
					);
				
				/* Build the template - Optional, you can just use the sendMail function 
				Instead to pass a message. */
				
				if(!$mail->newTemplateMsg("new-registration.txt",$hooks))
				{
					$this->mail_failure = true;
				}
				else
				{
					//Send the mail. Specify users email here and subject. 
					//SendMail can have a third parementer for message if you do not wish to build a template.
					
					if(!$mail->sendMail($this->clean_email,"New User"))
					{
						$this->mail_failure = true;
					}
				}
				$this->success = lang("ACCOUNT_REGISTRATION_COMPLETE_TYPE2");
			}
			else
			{
				//Instant account activation
				$this->user_active = 1;
				$this->success = lang("ACCOUNT_REGISTRATION_COMPLETE_TYPE1");
			}	
			
			
			if(!$this->mail_failure)
			{
				//Insert the user into the database providing no errors have been found.
				$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."users (
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
					)
					VALUES (
					?,
					?,
					?,
					?,
					?,
					'".time()."',
					'0',
					?,
					'Mr/Miss',
					'".time()."',
					'0'
					)");
				
				$stmt->bind_param("sssssi", $this->username, $this->displayname, $secure_pass, $this->clean_email, $this->activation_token, $this->user_active);
				$stmt->execute();
				$inserted_id = $mysqli->insert_id;
				$stmt->close();
				
				//Insert default permission into matches table
				$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."user_permission_matches  (
					user_id,
					permission_id
					)
					VALUES (
					?,
					'".$this->permission."'
					)");
				$stmt->bind_param("s", $inserted_id);
				$stmt->execute();
				$stmt->close();
			}
		}
	}
}
class AdmUser 
{
	public $user_active = 0;
	private $clean_email;
	public $status = false;
	private $clean_password;
	private $username;
	private $displayname;
	public $sql_failure = false;
	public $mail_failure = false;
	public $email_taken = false;
	public $username_taken = false;
	public $displayname_taken = false;
	public $activation_token = 0;
	public $success = NULL;
	
	function __construct($user,$display,$pass,$email)
	{
		//Used for display only
		$this->displayname = $display;
		
		//Sanitize
		$this->clean_email = sanitize($email);
		$this->clean_password = trim($pass);
		$this->username = sanitize($user);
		
		if(usernameExists($this->username))
		{
			$this->username_taken = true;
		}
		/*
		else if(displayNameExists($this->displayname))
		{
			$this->displayname_taken = true;
		}
		*/
		else if(emailExists($this->clean_email))
		{
			$this->email_taken = true;
		}
		else
		{
			//No problems have been found.
			$this->status = true;
		}
	}
	
	
}
?>