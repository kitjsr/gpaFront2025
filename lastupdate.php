<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost", "gpa7097", "Gpa@832109KunalM*_*", "gpadp");


//Check connection was successful
  if ($conn->connect_errno) {
     printf("Failed to connect to database");
     exit();
  }

//Fetch 
  $sql="SELECT date FROM login_details WHERE id=(SELECT MAX(id) FROM login_details)";

//Initialize array variable
  $dbdata = array();

//Fetch into associative array
if($data=mysqli_query($conn,$sql))
{
     $dbdata =mysqli_fetch_array($data);
     //echo $dbdata['date'];
}
  
//Print array in JSON format
 echo json_encode($dbdata);
?>
