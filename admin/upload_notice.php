<?php
require_once("models/config.php");
if($_FILES['notice']['size'] > 0){
	$targetDir = "uploads/";
    $allowTypes = array('pdf','doc','docx');
    
        $image_name = $_FILES['notice']['name'];
        $tmp_name   = $_FILES['notice']['tmp_name'];
        $size       = $_FILES['notice']['size'];
        $type       = $_FILES['notice']['type'];
        $error      = $_FILES['notice']['error'];
		
		$file_ext	= substr($image_name, strrpos($image_name, '.')); //file extension
        $mobile		= $_POST['mobile'];
		
		$RandNumber   		= rand(0, 9999999999); //Random number to make each filename unique.
		$NewFileName = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($mobile));
		$NewFileName = $NewFileName.'_'.$RandNumber.$file_ext;
        // File upload path
        $fileName = basename($_FILES['notice']['name']);
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
		else if($size > 5000000){
			echo"<div class='col-md-12'>
					<div class='alert alert-danger'>
                      <b>Alert!</b> <br>File Size exceeds 5MB!
                 </div>
				 </div>";
		}
		
		else{
			// Store images on the server
            if(move_uploaded_file($_FILES['notice']['tmp_name'],$targetFilePath)){
                //$images_arr[] = $targetFilePath;
				echo"<img class='image-preview' src='".$targetFilePath."' width='200px' height='230px' style='margin:0 auto;'/>";
				//echo $NewFileName;
				updatenotice($mobile, $NewFileName);
				$allNotice=fetchAllNotice();
            }
		}
}
?>