<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");

/**
 * Simple PHP age Calculator
 * 
 * Calculate and returns age based on the date provided by the user.
 * @param   date of birth('Format:yyyy-mm-dd').
 * @return  age based on date of birth
 */
date_default_timezone_set('Asia/Calcutta');
function ageCalculator($dob){
	if(!empty($dob)){
		$birthdate = new DateTime($dob);
		$today   = new DateTime('2016-04-01');
		$age = $birthdate->diff($today)->y;
		return $age;
	}else{
		return 0;
	}
}
//$dob = '1992-03-18';
//echo ageCalculator($student['dob']);



	
echo "
<script language='Javascript1.2'>
  <!--
  function printpage() {
  window.print();
  }
  //-->
</script>";


?>

    
<body onload="printpage()">
            

                

        
    <?php
		$student=fetchSingleStudent($_GET['mobile']);
$session = date( "Y-m-d", strtotime($student['adm_date']));//existing date
$sessionEnd =  date('Y-m-d', strtotime($session .'+3 years')); //added +3 years along with the $date
	function gender($i)
	{
		switch ($i)
		{
			case 1: $sex="Male";
			break;
			case 2 : $sex="Female";
			break;
			case 3 : $sex="Other";
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
	function admType($k)
	{
		switch ($k)
		{
			case 1: $adm_type="Regular";
			break;
			case 2 : $adm_type="Lateral";
			break;
		
		}
		return $adm_type;
	}
	function category($l)
	{
		switch ($l)
		{
			case 1: $adm_type="General";
			break;
			case 2 : $adm_type="SC";
			break;
			case 3: $adm_type="ST";
			break;
			case 4 : $adm_type="OBC";
			break;
			case 5: $adm_type="Tribal";
			break;
		
		}
		return $adm_type;
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
	
                    	
						echo"
                              <div class='box-body table-responsive no-padding'> 
							  <h1 class='text-center'>Government Polytechnic, Adityapur</h1>
							  <h4 class='text-center'>Department of Higher, Technical Education & Skill Development, Govt. of Jharkhand</h4>
								<table class='table table-responsive no-padding'>

<tbody>
	
	<tr>
		<th colspan='2' class='title'>:: Personal Details</th>
		<td colspan='1' rowspan='7' style='text-align:center !important; vertical-align:middle !important;'>";
						if(!empty($student['photo'])){
											echo"<img width='200px' height='230px' src='uploads/".$student['photo']."' class='img-rounded img-responsive' style='margin:0 auto !important'>"; 
										 }
										else{
											echo"<img src='img/noimage.jpg' class='img-rounded img-responsive'>";
										}
						echo"</td>
		<th style='text-align:center;'>College ID</th>
	</tr>
	<tr>
		<td>Name</td>
		<td>".$student['name']."</td>
		<td rowspan='3' style='text-align:center; vertical-align:middle;'><img alt='' src='barcode.php?codetype=Code39&size=40&text=".str_pad($student['cid'], 10, '0', STR_PAD_LEFT)."' /></br>".str_pad($student['cid'], 10, '0', STR_PAD_LEFT)."</td>
		
	</tr>
	<tr>
		<td>Father's Name</td>
		<td>".$student['father_name']."</td>
		
	</tr>
	<tr>
		<td>Mother's Name</td>
		<td>".$student['mother_name']."</td>
	</tr>
	<tr>
		<td>Date of Birth</td>
		<td>".date( "j M, Y", strtotime($student['dob']))."</td>
	</tr>
	<tr>
		<td>Gender</td>
		<td>".gender($student['gender'])."</td>
		<td  style='text-align:center; vertical-align:middle;'>
		</td>
	</tr>
	<tr>
		<th colspan='4' class='title'>:: Admission Details</th>
	</tr>
	<tr>
		<td>Session</td>
		<td>".date( "Y", strtotime($session))."-".date( "Y", strtotime($sessionEnd))."</td>
		<td>Branch</td>
		<td>".branch($student['branch'])."</td>
	</tr>
	<tr>
		<td>Board Roll No.</td>
		<td>".$student['broll']."</td>
		<td>Class Roll No.</td>
		<td>".$student['roll']."</td>
	</tr>
	<tr>
		<td>Semester</td>
		<td>".$student['sem']."</td>
		<td>Category</td>
		<td>".category($student['category'])."</td>
	</tr>
	<tr>
		<td>Admission Type</td>
		<td>".admType($student['adm_type'])."</td>
		<td>TFW</td>
		<td>".tfw($student['tfw'])."</td>
	</tr>
	<tr>
		<th colspan='4' class='title'>:: Permanent Address</th>
	</tr>
	<tr>
		<td>At/Vill.</td>
		<td>".$student['at']."</td>
		<td>Post</td>
		<td>".$student['post']."</td>
	</tr>
	<tr>
		<td>City</td>
		<td>".$student['city']."</td>
		<td>Dist.</td>
		<td>".$student['dist']."</td>
		
	</tr>
	<tr>
		<td>State</td>
		<td>".$student['state']."</td>
		<td>PIN</td>
		<td>".$student['pin']."</td>
	</tr>
	<tr>
		<th colspan='4' class='title'>:: Correspondence Address</th>
	</tr>
	<tr>
		<td>At/Vill.</td>
		<td>".$student['cat']."</td>
		<td>Post</td>
		<td>".$student['cpost']."</td>
	</tr>
	<tr>
		
		<td>City</td>
		<td>".$student['ccity']."</td>
		<td>Dist.</td>
		<td>".$student['cdist']."</td>
	</tr>
	<tr>
		<td>State</td>
		<td>".$student['cstate']."</td>
		<td>PIN</td>
		<td>".$student['cpin']."</td>
	</tr>
	<tr>
		<th colspan='4' class='title'>:: Contact Details</th>
	</tr>
	<tr>
		<td>Mobile</td>
		<td>".$student['mobile']."</td>
		<td>E-Mail</td>
		<td>".$student['email']."</td>
	</tr>";
						if($student['sign']!=null &&$student['thumb']!=null){
						echo"
	<tr>
		<td colspan='2'><img src='uploads/".$student['sign']."' alt='Signature' width='250px' height='110px'></td>
		<td colspan='2'><img src='uploads/".$student['thumb']."' alt='Thumb Impression' width='250px' height='110px'></td>
	</tr>
	";	
						}
						
						echo"
</tbody>
</table>
</div>";

?>
	


    
    </body>
</html>