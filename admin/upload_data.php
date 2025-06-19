<?php
require_once("models/config.php");
if($_FILES['photo']['error'] ){
	$targetDir = "uploads/";
    $allowTypes = array('jpg','png','jpeg');
    
        $image_name = $_FILES['photo']['name'];
        $tmp_name   = $_FILES['photo']['tmp_name'];
        $size       = $_FILES['photo']['size'];
        $type       = $_FILES['photo']['type'];
        $error      = $_FILES['photo']['error'];
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
        if(in_array($fileType, $allowTypes)){    
            // Store images on the server
            if(move_uploaded_file($_FILES['photo']['tmp_name'],$targetFilePath)){
                //$images_arr[] = $targetFilePath;
				echo"<img class='image-preview' src='".$targetFilePath."' width='240px' height='320px' style='margin:0 auto;'/>";
				//echo $NewFileName;
				updatePhoto($mobile, $NewFileName);
            }
        }
		else{
			echo"<div class='col-md-12'>
					<div class='alert alert-danger'>
                      <b>Alert!</b> <br>File Format not supported!
                 </div>
				 </div>";
		}
}
//////////////
if($_FILES['sign']['size'] > 0){
	$targetDir = "uploads/";
    $allowTypes = array('jpg','png','jpeg');
    
        $image_name = $_FILES['sign']['name'];
        $tmp_name   = $_FILES['sign']['tmp_name'];
        $size       = $_FILES['sign']['size'];
        $type       = $_FILES['sign']['type'];
        $error      = $_FILES['sign']['error'];
		$file_ext	= substr($image_name, strrpos($image_name, '.')); //file extension
        $mobile		= $_POST['mobile'];
		
		$RandNumber   		= rand(0, 9999999999); //Random number to make each filename unique.
		$NewFileName = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($mobile));
		$NewFileName = $NewFileName.'_'.$RandNumber.$file_ext;
        // File upload path
        $fileName = basename($_FILES['sign']['name']);
        $targetFilePath = $targetDir . $NewFileName;
        
        // Check whether file type is valid
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        if(in_array($fileType, $allowTypes)){    
            // Store images on the server
            if(move_uploaded_file($_FILES['sign']['tmp_name'],$targetFilePath)){
                //$images_arr[] = $targetFilePath;
				echo"<img class='image-preview' src='".$targetFilePath."' width='240px' height='320px' style='margin:0 auto;'/>";
				//echo $NewFileName;
				updateSign($mobile, $NewFileName);
            }
        }
		else{
			echo"<div class='col-md-12'>
					<div class='alert alert-danger'>
                      <b>Alert!</b> <br>File Format not supported!
                 </div>
				 </div>";
		}
}
//////////////////
if($_FILES['thumb']['size'] > 0){
	$targetDir = "uploads/";
    $allowTypes = array('jpg','png','jpeg');
    
        $image_name = $_FILES['thumb']['name'];
        $tmp_name   = $_FILES['thumb']['tmp_name'];
        $size       = $_FILES['thumb']['size'];
        $type       = $_FILES['thumb']['type'];
        $error      = $_FILES['thumb']['error'];
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
        if(in_array($fileType, $allowTypes)){    
            // Store images on the server
            if(move_uploaded_file($_FILES['thumb']['tmp_name'],$targetFilePath)){
                //$images_arr[] = $targetFilePath;
				echo"<img class='image-preview' src='".$targetFilePath."' width='240px' height='320px' style='margin:0 auto;'/>";
				//echo $NewFileName;
				updateThumb($mobile, $NewFileName);
            }
        }
		else{
			echo"<div class='col-md-12'>
					<div class='alert alert-danger'>
                      <b>Alert!</b> <br>File Format not supported!
                 </div>
				 </div>";
		}
}