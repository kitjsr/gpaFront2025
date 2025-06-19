<?php
date_default_timezone_set('Asia/Calcutta');
$date=date("Y-m-d h:i:s A");
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

					
							
							
							
						
					   $sql = "INSERT INTO `fee_collection` ( `sid`, `cid`, `pcode`, `trno`, `brno`, `amount`, `authstatus`, `txndate`, `date`) VALUES ('1', '123', '1', 'SHD48671623973', '009214163754', '1', '0300', '2020-11-29 13:46:58 AM', '2020-11-29 13:46:58');";
					$conn->query($sql);
								//addPay($sid,$cid,$pcode,$trno,$brno,$amount,$authstatus,$txndate,$date);
								echo "<script>alert('Successfully Payment Recieved!')</script>";
								header ('Location: fee_deposit.php');
							
							
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