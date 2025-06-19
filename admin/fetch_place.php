<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
$category = trim(mysql_escape_string($_POST["category"]));

if(checkBookPlace($category))
{
$allPlace=fetchAllPlace($category);

	echo"
		<div class='form-group'>
        	<label for='section'>Place Code</label>
			<select class='form-control validate[required]' name='pid'>
            	<option value=''>--- Choose Place ---</option>";
				//Display list of branch
				foreach ($allPlace as $place) {
				echo "<option value='".$place['pid']."'>".$place['pcode']."</option>";
				}
              echo"
				  								
			</select>
		</div>
		";
	}
else{
	echo"<div class='alert alert-danger'>
                                        <i class='fa fa-ban'></i>
                                        
                                        <b>Alert!</b> No Any Place Available. At First <a href='add_place.php' target='_blank'>Add Place</a>.
                                    </div></span>";
}

?>

