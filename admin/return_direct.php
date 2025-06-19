<?php 
require_once("models/config.php");

 if(isset($_POST["libid"]))  
 {  
     $libid = trim($_POST['libid']);
			date_default_timezone_set('Asia/Calcutta');
			$date=date("Y-m-d  h:i:s A");
			//Validate request
			
			$bookIssueDetails=fetchIssueBookId($libid);
				
				$returnBook=returnBook($bookIssueDetails['boisid'],$date);
			
	 $output = '';  
      //////////////////
									
									
									
									///////////// 
      $output .= " <div class='alert alert-suceess'>
                                        <i class='fa fa-book'></i>
                                        
                                        <b>Suceess!</b> Book Successfully Returned!
                                    </div> 
      
                ";  
    
      
      echo $output;  
 }  
 ?>