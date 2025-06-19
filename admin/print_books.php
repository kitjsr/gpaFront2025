<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");

echo "
<html>
<head>

<script language='Javascript1.2'>
  <!--
  function printpage() {
  window.print();
  }
  //-->
</script>
</head>
<body onload='printpage()' style='background:#FFF; margin:0; padding:0;'>
";

$allDetails=fetchBookList();

echo "
<table id='example1' class='table table-bordered table-striped' style='font:10px normal arial; margin:0; padding:0;'>
                        	<thead>
							<tr>
								<th colspan='9' style='text-align:center'><img src='logo.png'><h2>".$websiteName."</h2><h3 style='padding:5px 20px; margin:5px 0; border:solid 1px #000;'>Library Book List</h3></th>
							</tr>
							<tr>
                            	<th style='text-align:center;'>ISBN</th>
								<th style='text-align:left;'>Name</th>
								<th style='text-align:left;'>Author</th>
								<th style='text-align:left;'>Publisher</th>
								<th style='text-align:center;'>Year</th>
								<th style='text-align:center;'>Edition</th>
								<th style='text-align:center;'>Pages</th>
								<th style='text-align:center;'>Price</th>
								<th style='text-align:center;'>Place</th>
							</tr>
                            </thead>
                            </thead>
                            <tbody>";
							//Display list of pages
							foreach ($allDetails as $row){
							$singlePlace=fetchSinglePlace($row['pid']);
								echo"
                            	<tr>
                                	<td style='text-align:center;'>".$row['isbn']."</td>
									<td style='text-align:left;'>".ucwords($row['bname'])."</td>
									<td style='text-align:left;'>".ucwords($row['author'])."</td>
									<td style='text-align:left;'>".ucwords($row['publisher'])."</td>
									<td style='text-align:center;'>".$row['year']."</td>
									<td style='text-align:center;'>".$row['edition']."</td>
									<td style='text-align:center;'>".$row['nop']."</td>
									<td style='text-align:center;'>".$row['price']."</td>
									<td style='text-align:center;'>".$singlePlace['pcode']."</td>
                                </tr>";
								
							}
							echo"
                            </tbody>
                            <tfoot>
                                         
                                        </tfoot>
                                    </table>";

echo"

				
					
</body>
</html>";

?>