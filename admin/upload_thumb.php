<?php
require_once("models/config.php");
/////////////////
if($_FILES['thumb']['size'] > 0){
	$targetDir = "uploads/";
    $allowTypes = array('jpg','png','jpeg');
    
        $image_name = $_FILES['thumb']['name'];
        $tmp_name   = $_FILES['thumb']['tmp_name'];
        $size       = $_FILES['thumb']['size'];
        $type       = $_FILES['thumb']['type'];
        $error      = $_FILES['thumb']['error'];
		$fileinfo = @getimagesize($_FILES["thumb"]["tmp_name"]);
    	$width = $fileinfo[0];
    	$height = $fileinfo[1];
		$file_ext	= substr($image_name, strrpos($image_name, '.')); //file extension
        $mobile		= $_POST['mobile'];
	
		$RandNumber   		= rand(0, 9999999999); //Random number to make each filename unique.
		$NewFileName = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($mobile));
		$NewFileName = $NewFileName.'_'.$RandNumber.$file_ext;
        // File upload path
        $fileName = basename($_FILES['thumb']['name']);
        $targetFilePath = $targetDir . $NewFileName;
        
        // Check whether file type is valid
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        if(!in_array($fileType, $allowTypes)){    
            echo"<div class='col-md-12'>
					<div class='alert alert-danger'>
                      <b>Alert!</b> <br>File Format not supported!
                 </div>
				 </div>";
        }
		else if($size > 500000){
			echo"<div class='col-md-12'>
					<div class='alert alert-danger'>
                      <b>Alert!</b> <br>File Size exceeds 0.5MB!
                 </div>
				 </div>";
		}
		else if ($width !="250" && $height!="110") {
			echo"<div class='col-md-12'>
					<div class='alert alert-danger'>
                      <b>Alert!</b> <br>Image dimension should be within 250 X 110
                 </div>
				 </div>";
		}
		else{
			// Store images on the server
            if(move_uploaded_file($_FILES['thumb']['tmp_name'],$targetFilePath)){
                //$images_arr[] = $targetFilePath;
				echo"<img class='image-preview' src='".$targetFilePath."' width='250px' height='110px' style='margin:0 auto;'/>";
				//echo $NewFileName;
				updateThumb($mobile, $NewFileName);
            }
		}
}
?>