<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
$allFee=fetchAllStudent();

echo "



?>

    <body >
      
                                    <?php
									echo"
                                    <table>
                        	<thead>
                            	<th style='text-align:left;'>Name</th>
								<th style='text-align:center;'>Broll</th>
                            	<th style='text-align:left;'>Roll</th>
                                <th></th>
                            </thead>
                            <tbody>
                            ";
							//Display list of pages
							foreach ($allFee as $row) {
						
							echo "
								<tr>
									<td style='text-align:left;'>".$row['name']."</td>
									<td style='text-align:center;'>".$row['broll']."</td>
									<td style='text-align:center;'>".$row['roll']."</td>
									
									
								</tr>";
							}
							?>
                            </tbody>
                            
                                    </table>
                                
    </body>
</html>