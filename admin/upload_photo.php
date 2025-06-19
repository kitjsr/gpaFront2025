<?php
require_once("models/config.php");
if($_FILES['photo']['size'] > 0){
	$targetDir = "uploads/";
    $allowTypes = array('jpg','png','jpeg');
    
        $image_name = $_FILES['photo']['name'];
        $tmp_name   = $_FILES['photo']['tmp_name'];
        $size       = $_FILES['photo']['size'];
        $type       = $_FILES['photo']['type'];
        $error      = $_FILES['photo']['error'];
		$fileinfo = @getimagesize($_FILES["photo"]["tmp_name"]);
    	$width = $fileinfo[0];
    	$height = $fileinfo[1];
		$file_ext	= substr($image_name, strrpos($image_name, '.')); //file extension
        $mobile		= $_POST['mobile'];
		
		$RandNumber   		= rand(0, 9999999999); //Random number to make each filename unique.
		$NewFileName = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($mobile));
		$NewFileName = $NewFileName.'_'.$RandNumber.$file_ext;
        // File upload path
        $fileName = basename($_FILES['photo']['name']);
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
		else if($size > 1000000){
			echo"<div class='col-md-12'>
					<div class='alert alert-danger'>
                      <b>Alert!</b> <br>File Size exceeds 1MB!
                 </div>
				 </div>";
		}
		else if ($width !="200" && $height!="230") {
			echo"<div class='col-md-12'>
					<div class='alert alert-danger'>
                      <b>Alert!</b> <br>Image dimension should be within 200 X 230
                 </div>
				 </div>";
		}
		else{
			// Store images on the server
            if(move_uploaded_file($_FILES['photo']['tmp_name'],$targetFilePath)){
                //$images_arr[] = $targetFilePath;
				echo"<img class='image-preview' src='".$targetFilePath."' width='200px' height='230px' style='margin:0 auto;'/>";
				//echo $NewFileName;
				updatePhoto($mobile, $NewFileName);
            }
		}
}
?>