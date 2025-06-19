<?php 
require_once("models/config.php");

 if(isset($_POST["bid"]))  
 {  
     $noBooks=checkNoOfBook($_POST["bid"]);
	$book=fetchSingleBook($_POST["bid"]); 
	 $output = '';  
      //////////////////
									$allLibBooks=fetchAllBookList($_POST['bid']);
									$count=0;
									foreach ($allLibBooks as $data){
										//echo $data['libid'];
										$val=countSingleIssueBook($data['libid']);
										if($val['no']==0)
										{
											$avBook[]=$data['libid'];
										}
										
										$count=$count+$val['no'];
										
										
									}
									
									
									///////////// 
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
     
           $output .= '  
                <tr>  
                     <td width="30%"><label>Available</label></td>  
                     <td width="70%">'.($noBooks['no']-$count).'/'.$noBooks['no'].'</td>  
                </tr> 
				<tr>  
                     <td width="30%"><label>ISBN</label></td>  
                     <td width="70%">'.$book["isbn"].'</td>  
                </tr>
				<tr>  
                     <td width="30%"><label>Name</label></td>  
                     <td width="70%">'.$book["bname"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Author</label></td>  
                     <td width="70%">'.$book["author"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Publisher</label></td>  
                     <td width="70%">'.$book["publisher"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Edition</label></td>  
                     <td width="70%">'.$book["edition"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Category</label></td>  
                     <td width="70%">'.$book["bcat"].'</td>  
                </tr> 
				<tr>  
                     <td width="30%"><label>Price</label></td>  
                     <td width="70%">'.$book["price"].'</td>  
                </tr> 
				<tr>  
                     <td width="30%"><label>Year</label></td>  
                     <td width="70%">'.$book["year"].'</td>  
                </tr> 
				<tr>  
                     <td width="30%"><label>Available</label></td>  
                     <td width="70%">'.implode(", ",$avBook).'</td>  
                </tr> 
                ';  
    
      $output .= "</table></div>";  
      echo $output;  
 }  
 ?>