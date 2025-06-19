<?php
if (!securePage($_SERVER['PHP_SELF'])){die();}
$unread=countUnreadQuery();
//Links for logged in user
if(isUserLoggedIn()) {
	
	
	//Links for permission level 2 (default admin)
	if ($loggedInUser->checkPermission(array(2))){
	echo "
	<ul class='sidebar-menu'>
                        <li class='active'>
                            <a href='account.php'>
                                <i class='fa fa-dashboard'></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class='treeview'>
                            <a href='#'>
                                <i class='fa fa-bell'></i>
                                <span>Notice</span>
                                <i class='fa fa-angle-left pull-right'></i>
                            </a>
                            <ul class='treeview-menu'>
                                <li><a href='add_notice.php'><i class='fa fa-angle-double-right'></i> New Notice</a></li>
                                <li><a href='notices.php'><i class='fa fa-angle-double-right'></i> View</a></li>
                            </ul>
                        </li>
                        <li class='treeview'>
                            <a href='#'>
                                <i class='fa fa-cogs'></i>
                                <span>Admin Setting</span>
                                <i class='fa fa-angle-left pull-right'></i>
                            </a>
                            <ul class='treeview-menu'>
                                <li><a href='admin_configuration.php'><i class='fa fa-angle-double-right'></i> Configuration</a></li>
                                <li><a href='admin_users.php'><i class='fa fa-angle-double-right'></i> Users</a></li>
                                <li><a href='admin_permissions.php'><i class='fa fa-angle-double-right'></i> Permissions</a></li>
                                <li><a href='admin_pages.php'><i class='fa fa-angle-double-right'></i> Pages</a></li>
								<li><a href='records.php'><i class='fa fa-angle-double-right'></i> User Record</a></li>
								<li><a href='register.php'><i class='fa fa-angle-double-right'></i> Register</a></li>
                            </ul>
                        </li>
						<li class='treeview'>
                            <a href='#'>
                                <i class='fa fa-file'></i> <span>Vacancy</span>
                                <i class='fa fa-angle-left pull-right'></i>
                            </a>
                            <ul class='treeview-menu'>
                                <li><a href='#'><i class='fa fa-angle-double-right'></i> Current Opening</a></li>
                                <li><a href='view_vacancy_app.php'><i class='fa fa-angle-double-right'></i> View Application</a></li>
                            </ul>
                        </li>
                        <li class='treeview'>
                            <a href='#'>
                                <i class='fa fa-envelope'></i> <span>SMS</span>
                                <i class='fa fa-angle-left pull-right'></i>
                            </a>
                            <ul class='treeview-menu'>
                                <li><a href='create_message.php'><i class='fa fa-angle-double-right'></i> Create Message</a></li>
								<li><a href='sentbox.php'><i class='fa fa-angle-double-right'></i> Sentbox</a></li>
                            </ul>
                        </li>
						<li class='treeview'>
                            <a href='#'>
                                <i class='fa fa-group'></i> <span>Branch</span>
                                <i class='fa fa-angle-left pull-right'></i>
                            </a>
                            <ul class='treeview-menu'>
                                <li><a href='add_branch.php'><i class='fa fa-angle-double-right'></i> Add Details</a></li>
                                <li><a href='view_branch.php'><i class='fa fa-angle-double-right'></i> View Details</a></li>
                            </ul>
                        </li>
						<li class='treeview'>
                            <a href='#'>
                                <i class='fa fa-group'></i> <span>Program</span>
                                <i class='fa fa-angle-left pull-right'></i>
                            </a>
                            <ul class='treeview-menu'>
                                <li><a href='add_program.php'><i class='fa fa-angle-double-right'></i> Add Details</a></li>
                                <li><a href='view_program.php'><i class='fa fa-angle-double-right'></i> View Details</a></li>
                            </ul>
                        </li>
						<li class='treeview'>
                            <a href='#'>
                                <i class='fa fa-group'></i> <span>Trainer</span>
                                <i class='fa fa-angle-left pull-right'></i>
                            </a>
                            <ul class='treeview-menu'>
                                <li><a href='add_trainer.php'><i class='fa fa-angle-double-right'></i> Add Details</a></li>
                                <li><a href='view_trainer.php'><i class='fa fa-angle-double-right'></i> View Details</a></li>
                            </ul>
                        </li>
						<li class='treeview'>
                            <a href='#'>
                                <i class='fa fa-group'></i> <span>Batch</span>
                                <i class='fa fa-angle-left pull-right'></i>
                            </a>
                            <ul class='treeview-menu'>
                                <li><a href='add_batch.php'><i class='fa fa-angle-double-right'></i> Add Details</a></li>
                                <li><a href='view_batch.php'><i class='fa fa-angle-double-right'></i> View Details</a></li>
								<li><a href='close_batch.php'><i class='fa fa-angle-double-right'></i> Close Batch</a></li>
                            </ul>
                        </li>
						<li class='treeview'>
                            <a href='#'>
                                <i class='fa fa-group'></i> <span>Student</span>
                                <i class='fa fa-angle-left pull-right'></i>
                            </a>
                            <ul class='treeview-menu'>
                                <li><a href='personal_details.php'><i class='fa fa-angle-double-right'></i> Register</a></li>
                                <li><a href='complete_adm_app.php'><i class='fa fa-angle-double-right'></i> Recieved Application</a></li>
								<li><a href='accepted_adm_app.php'><i class='fa fa-angle-double-right'></i> Approved Student</a></li>
								<li><a href='active_trainee.php'><i class='fa fa-angle-double-right'></i> Active Student</a></li>
								<li><a href='ex_trainee.php'><i class='fa fa-angle-double-right'></i> Our Alumni</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href='inbox.php'>
                                <i class='fa fa-envelope-o'></i> <span>Enquiry</span>
                                <small class='badge pull-right bg-yellow'>".$unread['no']."</small>
                            </a>
                        </li>
                        
                    </ul>";
	}
	else if ($loggedInUser->checkPermission(array(6))){
	echo "
	<ul class='sidebar-menu'>
                        <li class='active'>
                            <a href='account.php'>
                                <i class='fa fa-dashboard'></i> <span>Dashboard</span>
                            </a>
                        </li>
						<li>
                            <a href='online_application.php'>
                                <i class='fa fa-file'></i> <span>Online Application</span>
                            </a>
                        </li>
						<li>
                            <a href='review.php'>
                                <i class='fa fa-check'></i><span>Review/Finalize</span>
                            </a>
                        </li>
						<li>
                            <a href='saved_app.php'>
                                <i class='fa fa-save'></i> <span>Saved Application</span>
                            </a>
                        </li>
                        
                    </ul>";
	}
} 
//Links for users not logged in
else {
	
}

?>
