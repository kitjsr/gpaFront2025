<?php
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Links for logged in user
if(isUserLoggedIn()) {
	
	
	//Links for permission level 2 (default admin)
	if ($loggedInUser->checkPermission(array(2))){
	echo "
	<ul class='sidebar-menu'>
                        <li class='active'>
                            <a href='account.php'>
                                <i class='fa fa-dashboard'></i> <span>Home</span>
                            </a>
                        </li>
						<li>
                            <a href='notices.php'>
                                <i class='fa fa-bell'></i> <span>Notice</span>
                            </a>
                        </li>
						<li>
                            <a href='inbox.php'>
                                <i class='fa fa-comments'></i> <span>Grievance</span>
                            </a>
                        </li>
						<li>
                            <a href='fee_collection.php'>
                                <i class='fa fa-money'></i> <span>Fee Collection</span>
                            </a>
                        </li>
						<li>
                            <a href='library_admin.php'>
                                <i class='fa fa-book'></i> <span>Library</span>
                            </a>
                        </li>
                        <li class='treeview'>
                            <a href='#'>
                                <i class='fa fa-cogs'></i>
                                <span>Admin Setting</span>
                                <i class='fa fa-angle-left pull-right'></i>
                            </a>
                            <ul class='treeview-menu'>
                                <li><a href='admin_configuration.php'><i class='fa fa-angle-double-right'></i> Configuration</a></li>
                                <li><a href='admin_permissions.php'><i class='fa fa-angle-double-right'></i> Permissions</a></li>
								<li><a href='admin_users.php'><i class='fa fa-angle-double-right'></i> Users</a></li>
                                <li><a href='admin_pages.php'><i class='fa fa-angle-double-right'></i> Pages</a></li>
								<li><a href='register.php'><i class='fa fa-angle-double-right'></i> Register</a></li>
                            </ul>
                        </li>
						<li>
                            <a href='print.php'>
                                <i class='fa fa-print'></i> <span>Print</span>
                            </a>
                        </li>
                        
                    </ul>";
	}
	if ($loggedInUser->checkPermission(array(4))){
		$gno=checkNoUnsolveg($student['mobile']);
		$bino=checkNoOfIssueBook($student['cid']);
	echo "
	<ul class='sidebar-menu'>
                        <li class='active'>
                            <a href='account.php'>
                                <i class='fa fa-dashboard'></i> <span>Home</span>
                            </a>
                        </li>
                        <li>
                            <a href='fee2022.php'>
                                <i class='ion ion-document-text'></i> <span>Fee Deposit</span>
                            </a>
                        </li>
                        <!--
                        <li>
                            <a href='fee_deposit.php'>
                                <i class='ion ion-document-text'></i> <span>First Year(New Admission)</span>
                            </a>
                        </li>
                        <li>
                            <a href='transfer.php'>
                                <i class='ion ion-document-text'></i> <span>New Admission (Transfer)</span>
                            </a>
                        </li>
                        <li>
                            <a href='readmission2605.php'>
                                <i class='ion ion-document-text'></i> <span>First Year(Re Admission 2605)</span>
                            </a>
                        </li>
                        <li>
                            <a href='readmission5.php'>
                                <i class='ion ion-document-text'></i> <span>First Year(Re Admission 5)</span>
                            </a>
                        </li>
						<li>
                            <a href='library.php'>
                                <i class='fa fa-book'></i> <span>Library</span>
								<small class='badge pull-right bg-yellow'>".$bino['no']."</small>
                            </a>
                        </li>
                        <li>
                            <a href='transfer.php'>
                                <i class='fa fa-rupee'></i> <span>Transfer</span>
                            </a>
                        </li>-->
						<li>
                            <a href='grievance.php'>
                                <i class='fa fa-comments'></i> <span>Grievance</span>
								<small class='badge pull-right bg-red'>".$gno['no']."</small>
                            </a>
                        </li>
						<li>
                            <a href='#'>
                                <i class='fa fa-external-link-square'></i> <span>CLC</span>
                            </a>
                        </li>
                    </ul>
					";
	}
	}

?>
