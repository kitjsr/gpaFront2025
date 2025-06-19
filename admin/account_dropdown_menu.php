<?php

echo"
<li class='dropdown user user-menu'>
                            <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
                                <i class='glyphicon glyphicon-user'></i>
                                <span>".$loggedInUser->displayname." <i class='caret'></i></span>
                            </a>
                            <ul class='dropdown-menu'>
                                <!-- User image -->
                                <li class='user-header bg-light-blue'>";
								
								if ($loggedInUser->checkPermission(array(4))){
									$student=fetchSingleStudent($loggedInUser->username);
									if($student['photo']!=null)
									{
										echo "
                                   <a href='student_profile.php'><img src='uploads/".$student['photo']."' class='img-circle drop_profile' alt='Photo'  /></a>";
									}
									else{
										echo "
                                    <a href='student_profile.php'><img src='img/avatar3.png' class='img-circle drop_profile' alt='Photo'  /></a>";
									}
								}
								else{
										echo "
                                    <img src='img/avatar3.png' class='img-circle' alt='Photo' />";
								}
								
								echo"
                                    <p>
                                      ".$loggedInUser->displayname."
                                        <small>
                                        	Member since ".date("M d, Y", $loggedInUser->signupTimeStamp())."</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                
                                <!-- Menu Footer-->
                                <li class='user-footer'>
								";
								if ($loggedInUser->checkPermission(array(4))){
								echo "
                                    <div class='pull-left'>
                                        <a href='student_profile.php' class='btn btn-default btn-flat'>Profile</a>
										<a href='user_settings.php' class='btn btn-default btn-flat'>Setting</a>
                                    </div>";
								}
								else{
									echo "
                                    <div class='pull-left'>
										<a href='user_settings.php' class='btn btn-default btn-flat'>Setting</a>
                                    </div>";
								}
								echo"
                                    <div class='pull-right'>
                                        <a href='logout.php' class='btn btn-default btn-flat'>Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        ";
?>