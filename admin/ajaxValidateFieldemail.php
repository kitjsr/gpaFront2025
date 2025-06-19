<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
/* RECEIVE VALUE */
$validateValue=$_REQUEST['fieldValue'];
$validateId=$_REQUEST['fieldId'];


$validateError= "This email is already taken";
$validateSuccess= "This email is available";



	/* RETURN VALUE */
	$arrayToJs = array();
	$arrayToJs[0] = $validateId;

	if(!studentEmailExists($validateValue)){		// validate??
		$arrayToJs[1] = true;			// RETURN TRUE
		echo json_encode($arrayToJs);			// RETURN ARRAY WITH success
	}else{
		for($x=0;$x<1000000;$x++){
			if($x == 990000){
				$arrayToJs[1] = false;
				echo json_encode($arrayToJs);		// RETURN ARRAY WITH ERROR
			}
		}
		
	}

?>