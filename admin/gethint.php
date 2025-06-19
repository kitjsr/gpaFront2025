<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
// Array with names
$allStudent = allStudent();

// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from "" 
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    foreach($allStudent as $name) {
        if (stristr($q, substr($name['name'], 0, $len))) {
			//echo"<table>";
            if ($hint === "") {
				
                $hint = "<tr><td><a href='create_individual_message_2.php?sid=".$name['sid']."'>".$name['name']."</td><td>".$name['fname']."</td><td><a class='btn btn-sm btn-success' href='create_individual_message_2.php?sid=".$name['sid']."'>View</a></td></tr>";
            } else {
                $hint .= "<tr><td><a href='create_individual_message_2.php?sid=".$name['sid']."'>".$name['name']."</td><td>".$name['fname']."</td><td><a class='btn btn-sm btn-success' href='create_individual_message_2.php?sid=".$name['sid']."'>View</a></td></tr>";
            }
			//echo"</table>";
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values 
echo $hint === "" ? "no suggestion" : $hint;
?>