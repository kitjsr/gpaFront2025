<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost", "gpaac_panditidkun", "Nh2He[tZ,M4w", "gpaac_gpakun");


//Check connection was successful
  if ($conn->connect_errno) {
     printf("Failed to connect to database");
     exit();
  }

//Fetch 
  $sql="SELECT title,notice,home,new,date FROM notice WHERE home=1 ORDER BY id DESC LIMIT 20";

//Initialize array variable
  $dbdata = array();

//Fetch into associative array
if($data=mysqli_query($conn,$sql))
{
    while ( $row =mysqli_fetch_assoc($data))  {
	$dbdata[]=$row;
  }
}
  

//Print array in JSON format
 echo json_encode($dbdata);
?>