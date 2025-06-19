<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");

echo "
<link rel='stylesheet' type='text/css' href='models/site-templates/menu.css' />
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css' />

<script language='Javascript1.2'>
  <!--
  function printpage() {
  window.print();
  }
  //-->
</script>
<body onload='printpage()'>
";

$allDetails=fetchAllNotice();

echo "
<table id='example1' class='table table-bordered table-striped'>
                        	<thead>
							<tr>
								<th colspan='4' style='text-align:center'><img src='logo.png'><h3>".$websiteName."</h3></th>
							</tr>
							<tr>
                            	<th>Title</th>
                                <th style='text-align:center'>New</th>
                                <th style='text-align:center'>Home</th>
								<th style='text-align:center'>Date</th>
							</tr>
                            </thead>
                            </thead>
                            <tbody>";
							//Display list of pages
							foreach ($allDetails as $details){
								if($details['new']==1)
							{
								$new="Yes";
							}
							else
							{
								$new="No";
							}
							if($details['home']==1)
							{
								$home="Yes";
							}
							else
							{
								$home="No";
							}
							echo"
                            	<tr>
                                	<td style='text-align:left'>".$details['title']."</td>
									<td style='text-align:center'>".$new."</td>
									<td style='text-align:center'>".$home."</td>
									<td style='text-align:center'>".date( "j M, Y", strtotime($details['date']))."</td>
                                </tr>
							";
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