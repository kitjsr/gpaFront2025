<?php
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d h:i:s");
		$servername = "localhost";
			$username = "gpadporg_gpaku";
			$password = "#_s)f!891kq]";
			$dbname = "gpadporg_gpadp";
			$prefix = "";
			// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

							$msg=$_POST['msg'];
							$data=explode("|",$msg);
							//echo $data[13];
							$sid=$data[1];
							$cid=$data[16];
							$trno=$data[2];
							$brno=$data[3];
							$amount=$data[4];
							$authstatus=$data[14];
							$tdata=explode(" ",$data[13]);
							$tdate=explode("-",$tdata[0]);
							$txndate="".$tdate[2]."-".$tdate[1]."-".$tdate[0]." ".$tdata[1]."";
							$pcode=$data[19];// Payment Code
							/*
							echo $sid;
							echo"<br/>";
							echo $cid;
							echo"<br/>";
							echo $pcode;
							echo"<br/>";
							echo $trno;
							echo"<br/>";
							echo $brno;
							echo"<br/>";
							echo $amount;
							echo"<br/>";
							echo $authstatus;
							echo"<br/>";
							echo $date;
							echo"<br/>";
							echo $txndate;
							*/
							//
							
							
						
								// Insert Payment Details
								$sql = "INSERT INTO `fee_collection` ( `sid`, `cid`, `pcode`, `trno`, `brno`, `amount`, `authstatus`, `txndate`, `date`) VALUES ('".$sid."','".$cid."','".$pcode."','".$trno."','".$brno."','".$amount."','".$authstatus."','".$txndate."','".$date."')";
					  // $sql = "INSERT INTO `fee_collection` (`fid`, `sid`, `cid`, `pcode`, `trno`, `brno`, `amount`, `authstatus`, `txndate`, `date`) VALUES (NULL, \'1\', \'123\', \'1\', \'SHD48671623973\', \'009214163754\', \'1\', \'0300\', \'2020-11-29 13:46:58 AM\', \'2020-11-29 13:46:58\')";
					  //echo $sql;
					$conn->query($sql);
								//addPay($sid,$cid,$pcode,$trno,$brno,$amount,$authstatus,$txndate,$date);
								//echo "<script>alert('Successfully Payment Recieved!')</script>";
								header ('Location: regfee.php');
							
							
							///////////////
		



/*
if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Something Wrong";
}
*/

$conn->close();
///////////
						
						?>