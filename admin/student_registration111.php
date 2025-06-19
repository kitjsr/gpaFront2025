<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
//if(isUserLoggedIn()) { header("Location: account.php"); die(); }

//Forms posted
if(!empty($_POST))
{
	$errors = array();
	$email = trim($_POST["email"]);
	
	$captcha = md5($_POST["captcha"]);
	///////////////
				$mobile=$_POST['mobile'];
				$email=$_POST['email'];
				$name=$_POST['name'];
				$father_name=$_POST['father_name'];
				$mother_name=$_POST['mother_name'];
				$gender=$_POST['gender'];
				$category=$_POST['category'];
				$dob=$_POST['dob'];
				
				
				$adm_type=$_POST['adm_type'];
				$branch=$_POST['branch'];
				$sem=$_POST['sem'];
				$roll=$_POST['roll'];
				$broll=$_POST['broll'];
				
	
				$tfw=$_POST['tfw'];
				$at=$_POST['at'];
				$post=$_POST['post'];
				$city=$_POST['city'];
				$dist=$_POST['dist'];
				$state=$_POST['state'];
				$pin=$_POST['pin'];
				$cat=$_POST['cat'];
				$cpost=$_POST['cpost'];
				$ccity=$_POST['ccity'];
				$cdist=$_POST['cdist'];
				$cstate=$_POST['cstate'];
				$cpin=$_POST['cpin'];
				///////////////////////
				date_default_timezone_set("Asia/Kolkata");
				$date=date("Y-m-d H:i:s");
				
				$adm_date=date("Y-m-d");
	////////////////
	//$username = $mobile;
	//$displayname = $name;
	//$password = $mobile;
	////////////////
	
	if ($captcha != $_SESSION['captcha'])
	{
		$errors[] = lang("CAPTCHA_FAIL");
	}
			if($mobile == "")
			{
				$errors[] = lang("PLEASE_ENTER_MOBILE");
			}
			if($name == "")
			{
				$errors[] = lang("PLEASE_ENTER_NAME");
			}
			if($father_name == "")
			{
				$errors[] = lang("PLEASE_ENTER_FATHER_NAME");
			}
			if($mother_name == "")
			{
				$errors[] = lang("PLEASE_ENTER_MOTHER_NAME");
			}
			if($gender == "")
			{
				$errors[] = lang("PLEASE_CHOOSE_GENDER");
			}
			if($category == "")
			{
				$errors[] = lang("PLEASE_CHOOSE_CATEGORY");
			}
			if($dob != "")
			{
				$data=explode("/",$dob);
				$newdate="".$data[2]."-".$data[1]."-".$data[0]."";
			}
			else if($dob == "")
			{
				$errors[] = lang("PLEASE_ENTER_DOB");
			}
			if($adm_type == "")
			{
				$errors[] = lang("CHHOSE_ADM_TYPE");
			}
			if($branch == "")
			{
				$errors[] = lang("CHOOSE_BRANCH");
			}
			if($sem == "")
			{
				$errors[] = lang("CHOOSE_SEM");
			}
			
	$st_no=checkNoOfStudent();
	$new_cid=$st_no['no']+1;
	$cid="".date("Y")."".$branch."".str_pad($new_cid, 5, '0', STR_PAD_LEFT)."";
	if(!isValidEmail($email))
	{
		$errors[] = lang("ACCOUNT_INVALID_EMAIL");
	}
	//End data validation
	if(count($errors) == 0)
	{	
		//Construct a user object
		$user = new User($mobile,$name,$mobile,$email,$permission=4);
		
		addStudent($cid,$name,$father_name,$mother_name,$newdate,$gender,$branch,$roll,$broll,$sem,$category,$adm_type,$tfw,$at,$post,$city,$dist,$state,$pin,$cat,$cpost,$ccity,$cdist,$cstate,$cpin,$mobile,$email,$adm_date,$date);
		////////////////////////////////
		
		$subject = 'Message from Admission Cell, Govt. Polytechnic, Adityapur';
		$body_message= "Hi ".$name."! Welcome to Government Polytechnic, Adityapur Student Zone. Your password is your mobile no. Kindly update your password.";

		$from="contact@gpadp.org.in";

		$mail_status = mail($email, $subject, $body_message,"From:".$from);
		
		/////////////////////
		//Checking this flag tells us whether there were any errors such as possible data duplication occured
		//if(!$user->status)
		//{
			//if($user->username_taken) $errors[] = lang("ACCOUNT_USERNAME_IN_USE",array($username));
			//if($user->displayname_taken) $errors[] = lang("ACCOUNT_DISPLAYNAME_IN_USE",array($displayname));
			//if($user->email_taken) 	  $errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));		
		//}
		if($user->status)
		{
			//Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
			if(!$user->userCakeAddUser())
			{
				if($user->mail_failure) $errors[] = lang("MAIL_ERROR");
				if($user->sql_failure)  $errors[] = lang("SQL_ERROR");
			}
		}
	}
	if(count($errors) == 0) {
		$successes[] = $user->success;
	}
}

require_once("models/header.php");

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
	
    <script src='js/bootstrap-checkbox.min.js' type='text/javascript'></script>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css' rel='stylesheet' />
<script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js'></script>

	";
?>

 <body>

<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	
<div class="container">
    <h2 class="well">Student Registration Form</h2>
    <h4>Fill all details carefully!</h4>
	<div class="col-lg-12 well">
	<div class="row">
	<?php
						echo resultBlock($errors,$successes);
						echo"
							
				<form name='newUser' action='".$_SERVER['PHP_SELF']."' method='post' id='formID'>
					<input type='hidden' name='gender' value='0'>
					<input type='hidden' name='category' value='0'>
					<input type='hidden' name='tfw' value='0'>
					<div class='col-sm-12'>
						<div class='row'>
							<div class='col-sm-6 form-group'>
								<label>Mobile</label>
								<input class='form-control validate[required, custom[phone],ajax[validateUserName], minSize[10], maxSize[10]]' placeholder='Enter Mobile Number' name='mobile' data-prompt-position='bottomLeft' autocomplete='off' data-inputmask='\"mask\": \"9999999999\"' data-mask/>
							</div>
							<div class='col-sm-6 form-group'>
								<label>E-Mail</label>
								<input class='form-control validate[required, custom[email],ajax[validateUserEmail]]' data-prompt-position='bottomLeft' placeholder='Enter E-Mail' name='email'autocomplete='off'>
							</div>
						</div>	
						<div class='row'>
							<div class='col-sm-6 form-group'>
								<label>Name</label>
								<input type='text' placeholder='Enter Your Name' class='form-control validate[required, custom[onlyLetterSp]]' name='name' autocomplete='off' data-prompt-position='bottomLeft'>
							</div>		
							<div class='col-sm-6 form-group'>
								<label>Father Name</label>
								<input type='text' placeholder='Enter Your Father Name' class='form-control validate[required, custom[onlyLetterSp]]' name='father_name' autocomplete='off' data-prompt-position='bottomLeft'>
							</div>	
						</div>
						<div class='row'>
							<div class='col-sm-6 form-group'>
								<label>Mother Name</label>
								<input type='text' placeholder='Enter Your Mother Name' class='form-control validate[required, custom[onlyLetterSp]]' name='mother_name' autocomplete='off' data-prompt-position='bottomLeft'>
							</div>		
							<div class='col-sm-6 form-group'>
								<label>Date of Birth</label>
								<input type='text' id='datepicker' class='form-control validate[required]' placeholder='Enter Your Date of Birth' name='dob' autocomplete='off' data-prompt-position='topRight' data-inputmask=\"'alias': 'dd/mm/yyyy'\" data-mask>
							</div>	
						</div>
						<div class='row'>
							<div class='col-sm-6 form-group'>
                    			<label class='control-label col-sm-3'>Gender</label>
                    				<div class='col-sm-6'>
                        				<div class='row'>
                            				<div class='col-sm-4'>
                                				<label class='radio-inline'>
                                    				<input type='radio' name='gender' class='validate[required] myradio' value='1'>Male
                                				</label>
                            				</div>
											<div class='col-sm-4'>
                                					<label class='radio-inline'>
                                    					<input type='radio' name='gender' class='validate[required] myradio' value='2'>Female
                                					</label>
                            				</div>
											<div class='col-sm-4'>
                                					</label>
                            				</div>
                            				
                        				</div>
                    				</div>
                			</div> <!-- /.form-group -->
							<div class='col-sm-6 form-group'>
                    			<label class='control-label col-sm-3'>Category</label>
                    				<div class='col-sm-6'>
                        				<div class='row'>
                            				<div class='col-sm-4'>
                                				<label class='radio-inline'>
                                    				<input type='radio' class='validate[required]' name='category' value='1'>General
                                				</label>
                            				</div>
											<div class='col-sm-4'>
                                					<label class='radio-inline'>
                                    					<input type='radio' class='validate[required]' name='category' value='2'>SC
                                					</label>
                            				</div>
											<div class='col-sm-4'>
                                					<label class='radio-inline'>
                                    					<input type='radio' class='validate[required]' name='category' value='3'>ST
                                					</label>
                            				</div>
											<div class='col-sm-4'>
                                					<label class='radio-inline'>
                                    					<input type='radio' class='validate[required]' name='category' value='4'>BC I
                                					</label>
                            				</div>
											<div class='col-sm-4'>
                                					<label class='radio-inline'>
                                    					<input type='radio' class='validate[required]' name='category' value='5'>BC II
                                					</label>
                            				</div>
                            				
                        				</div>
                    				</div>
                			</div> <!-- /.form-group -->
						</div>
						
						<h3>Admission Details</h3>
						<div class='row'>
							<div class='col-sm-4 form-group'>
								<label>Admission Type</label>
								<select class='form-control validate[required]' name='adm_type' data-prompt-position='bottomLeft' id='adm_type' onchange='fun()'>
								<option value=''> --- Choose Admission Type --- </option>
									<option value='1'>Regular</option>
									<option value='2'>Lateral</option>
								</select>
							</div>	
							<div class='col-sm-4 form-group'>
								<label>Branch</label>
								<select class='form-control validate[required]' name='branch' data-prompt-position='bottomLeft'>
									<option value=''> --- Choose Branch --- </option>
									<option value='1'>Mechanical Engineering</option>
									<option value='2'>Electrical Engineering</option>
									<option value='3'>Metallurgical Engineering</option>
									<option value='4'>Computer Sc. &amp; Engineering</option>
								</select>
							</div>	
							<div class='col-sm-4 form-group'>
								<label>Semester</label>
								<select class='form-control validate[required]' name='sem' id='sem' data-prompt-position='bottomLeft'>
									<option value=''> --- Choose Semester --- </option>
								</select>
							</div>		
						</div>
						
						<div class='row'>
							<div class='col-sm-4 form-group'>
								<label>PCECE App. No.</label>
								<input type='text' name ='broll' placeholder='Enter PCECE Application No.' class='form-control validate[required]' autocomplete='off' data-prompt-position='bottomLeft' data-inputmask='\"mask\": \"999999\"' data-mask>
							</div>	
							<div class='col-sm-4 form-group'>
								<label>CML Rank</label>
								<input type='text' name='roll' placeholder='Enter CML Rank' class='form-control validate[required]' autocomplete='off' data-prompt-position='bottomLeft' >
							</div>	
							<!--
							<div class='col-sm-4 form-group'>
								<label>Admission Date</label>
								<input type='text' id='doa' class='form-control validate[required]' placeholder='Enter Your Date of Admission' name='adm_date' autocomplete='off' data-prompt-position='topRight' data-inputmask=\"'alias': 'dd/mm/yyyy'\" data-mask>
							</div>	
							-->
						</div>
						<div class='row'>
							<div class='col-sm-12 form-group'>
                    			<label class='control-label col-sm-12'>TFW(If Admission Quota is TFW then yes</label>
                    				<div class='col-sm-6'>
                        				<div class='row'>
                            				<div class='col-sm-4'>
                                				<label class='radio-inline'>
                                    				<input type='radio'  class='validate[required] myradio' name='tfw' value='1'>Yes
                                				</label>
                            				</div>
											<div class='col-sm-4'>
                                					<label class='radio-inline'>
                                    					<input type='radio'  class='validate[required] myradio' name='tfw' value='2' checked>No
                                					</label>
                            				</div>
											
                            				
                        				</div>
                    				</div>
                			</div> <!-- /.form-group -->
							
						</div>
						
						
							
					
					<div class='form-group'>
                                            <label for='userName'>Security Code</label>
                                            <img src='models/captcha.php'>
                                        </div>
										<div class='form-group'>
                                            <label for='userName'>Enter Security Code</label>
                                            <input type='text' name='captcha' class='form-control validate[required] text-input' autocomplete='off' data-prompt-position='bottomLeft'>
                                        </div>
                                        <div class='alert alert-danger'>If all details correct then click on submit button and wait few minutes!</div>
					<input type='submit' class='btn btn-lg btn-info' value='Submit'>
					<input type='reset' class='btn btn-lg btn-info' value='Reset'>
					</div>
				</form> 
							";
						
					?>
				</div>
	</div>
	</div>
       
                        
                          
                            
</body>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(function() {
        $( "#datepicker" ).datepicker({
			/*
            dateFormat : 'dd/mm/yy',
            changeMonth : true,
            changeYear : true,
            yearRange: '-30y:c-14',
            maxDate: '-1d'*/
			dateFormat : 'dd/mm/yy',
			yearRange: '-40y:-14y',
			changeMonth: true,
      		changeYear: true
        });
		$( "#doa" ).datepicker({
            dateFormat : 'dd/mm/yy',
            changeMonth : true,
            changeYear : true,
            yearRange: '-2y:c+nn'
        });
	
		$( ".myradio" ).checkboxradio();
	
	
    });
   
</script>
<!-- InputMask -->
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
<script>
    $(':checkbox').checkboxpicker();
</script>
<script>
//     $(document).ready(function() {

//     $("#adm_type").change(function() {
//         var val = $(this).val();
//         console.log('Hello');
//         if (val == 1) {
//             $("#sem").html("<option value='1' selected>First Semester</option>
// 									<option value='3'>Third Semester</option>
// 								");
//         } else {
//               $("#sem").html("<option value='1'>First Semester</option>
// 									<option value='3' selected>Third Semester</option>
// 								");

//         } 
//     });


// });

function fun(){
    // alert("Hello");
    $("#adm_type").change(function() {
        var val = $(this).val();
        console.log('Hello');
        
        if(val === 1){
            alert("Regular");
        }
        else{
            alert("Lateral");
        }
        // if (val == 1) {
        //     $("#sem").html("<option value='1' selected>First Semester</option>
								// 	<option value='3'>Third Semester</option>
								// ");
        // } else {
        //       $("#sem").html("<option value='1'>First Semester</option>
								// 	<option value='3' selected>Third Semester</option>
								// ");

        // } 
    });
}
</script>
</html>