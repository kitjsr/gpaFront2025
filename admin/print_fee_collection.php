<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$allFee=fetchAllFee();
?>
<html>
    <head>
        <title></title>
        <style type="text/css">
            table{
                width:100%;
                border-collapse:collapse;
            }
            table,tr,td,th{
                border:solid 1px #000;
            }
            thead{
                background:#000;
                color:#FFF;
            }
            th,td{
                padding:5px;
            }
        </style>
    </head>
    <body>
                    <h1 style='text-align:center'>Government Polytechnic Adityapur</h1>    
                    <h2 style='text-align:center'>Fee Collection</h2>             
                                
                                    <?php
									echo"
                                    <table id='example1' class='table table-bordered'>
                        	<thead>
                            	<th style='text-align:left;'>Name</th>
								<th style='text-align:center;'>Mobile</th>
                            	<th style='text-align:left;'>E-Mail</th>
                            	<th style='text-align:center;'>Purpose</th>
								<th style='text-align:center;'>Trans. Id</th>
								<th style='text-align:center;'>BR No.</th>
								<th style='text-align:center;'>Status</th>
                                <th style='text-align:center;'>Amount</th>
                                <th style='text-align:center;'>Date</th>
                            </thead>
                            <tbody>
                            ";
							//Display list of pages
							foreach ($allFee as $row) {
						
							echo "
								<tr>
									<td style='text-align:left;'>".$row['name']."</td>
									<td style='text-align:center;'>".$row['mobile']."</td>
									<td style='text-align:left;'>".$row['email']."</td>
									<td style='text-align:center;'>".$row['pcode']."</td>
									<td style='text-align:center;'>".$row['trno']."</td>
									<td style='text-align:center;'>".$row['brno']."</td>
									<td style='text-align:center;'>".$row['authstatus']."</td>
									<td style='text-align:right;'>".$row['amount']."</td>
									<td style='text-align:center;'>".date( "j M, Y", strtotime($row['txndate']))."</td>
									
									
								</tr>";
							}
							?>
                            </tbody>
                            
                                    </table>
                                
       

       
      

    </body>
</html>