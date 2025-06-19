<?php
include("include/setting.php");
if(!empty($_POST))
{
		$mobile		= $_POST['mobile'];
		$email		= $_POST['email'];
		$name		= $_POST['name'];
		$dob		= $_POST['dob'];
		$branch		= $_POST['branch'];
		$sem		= $_POST['sem'];
		$broll		= $_POST['broll'];
		$g			= $_POST['g'];
		$gtitle			= $_POST['gtitle'];
		$extra="".$email.",".$name.",".$dob.",".$branch.",".$sem.",".$broll."";
	date_default_timezone_set('Asia/Calcutta');
			$date=date("Y-m-d  h:i:s A");
		$error="";
        if(empty($mobile)){    
            $error.="<li>Please Enter Mobile.</li>";
        }
		if(empty($name)){
			$error.="<li>Please Enter Name.</li>";
		}
		if(empty($email)){
			$error.="<li>Please Enter E-Mail.</li>";
		}
		if(empty($dob)){
			$error.="<li>Please Enter Date of Birth.</li>";
		}
		if(empty($branch)){
			$error.="<li>Please Choose Branch.</li>";
		}
		if(empty($sem)){
			$error.="<li>Please Choose Semester.</li>";
		}
		if(empty($broll)){
			$error.="<li>Please Enter Board Roll No.</li>";
		}
		if(empty($g)){
			$error.="<li>Please Write Grievance.</li>";
		}
		if(empty($gtitle)){
			$error.="<li>Please Enter Grievance Title.</li>";
		}
	
		if($error!=null)
		{
			echo"<div class='col-md-12'>
					<div class='alert alert-danger'>
                      <b>Alert!</b> <br>
					  <ul>
					  	".$error."
					</ul>
                 </div>
				 </div>";
		}
		
		else{
				//////////////////////
				$messageAdmin="Respected Sir! A Grievance receieved from Online Grievance System. Name :".$name.", Mobile :".$mobile.",E-Mail :".$email.",Grievance :".$g."";
				$messageStudent="Hi ".$name."! Your Grievance received by Grievance Cell, Govt. Polytechnic, Adityapur. Your Grievance will solve shortly.";
				////////////////////////// MAIL - ADMIN ///////////////////////////////
				$subject = "Grievance Application";
				$mail_toAdmin="kunalkumar1987@gmail.com";
				$from="contact@gpadp.org.in";

				$mail_statusAdmin = mail($mail_toAdmin, $subject, $messageAdmin,"From:".$from);
				////////////////////////// MAIL - STUDENT ///////////////////////////////	
		
				$mail_statusStudent = mail($email, $subject, $messageStudent,"From:".$from);
				///////////////// USER'S ACTIVITY RECORD /////////////
				mysql_query("INSERT INTO grievances(mobile,gtitle,g,extra, date) VALUES ('".$mobile."','".$gtitle."','".$g."','".$extra."','".$date."')", $db_conn);
				echo"<div class='col-md-12'>
					<div class='alert alert-success'>
                      <b>Alert!</b> <br>Successfully Grievance Submit.
                 </div>
				 </div>";
			
			///////////////
			
			// Multiple recipients
$to = 'kunalkumar1987@gmail.com, kunalkr4u@gmail.com'; // note the comma

// Subject
$subject = 'Birthday Reminders for August';

// Message
$message = '
<html>
<head>
  <title>Birthday Reminders for August</title>
</head>
<body>
  <p>Here are the birthdays upcoming in August!</p>
  <table>
    <tr>
      <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
    </tr>
    <tr>
      <td>Johny</td><td>10th</td><td>August</td><td>1970</td>
    </tr>
    <tr>
      <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
    </tr>
  </table>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
//$headers[] = 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
$headers[] = 'From: Birthday Reminder <info@gpadp.org.in>';
//$headers[] = 'Cc: birthdayarchive@example.com';
//$headers[] = 'Bcc: birthdaycheck@example.com';

// Mail it
mail($to, $subject, $message, implode("\r\n", $headers));

$to = 'kunalkumar1987@gmail.com';
$subject = 'Marriage Proposal';
$from = 'info@gpadp.org.in';
 
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
 
// Compose a simple HTML email message
$message = '<html><body>';
$message .= '<h1 style="color:#f40;">Hi Jane!</h1>';
$message .= '<p style="color:#080;font-size:18px;">Will you marry me?</p>';
$message .= '</body></html>';
 
// Sending email
if(mail($to, $subject, $message, $headers)){
    echo 'Your mail has been sent successfully.';
} else{
    echo 'Unable to send email. Please try again.';
}
			////////////////////
			
            
		}
}
        



?>