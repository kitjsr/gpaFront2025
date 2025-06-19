<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$myXMLData =
"<?xml version='1.0' encoding='UTF-8'?>
<XML>
	<STATUS>Y</STATUS>
	<AdmissionNumber>12345678</AdmissionNumber >
	<SchoolName>Government Polytechnic Adityapur</SchoolName >
	<StudentName>Anil Kumar</StudentName>
	<FeeAmount>1000.00</FeeAmount >
  	<MSG>Pending</MSG>
</XML>";

$xml=simplexml_load_string($myXMLData) or die("Error: Cannot create object");
print_r($myXMLData);
?>