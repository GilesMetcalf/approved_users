<?php

	//	Written by Andrew Waters - andrew@band-x.org
    //  Additional code by Martijn van der Kleijn (martijn.niji@gmail.com)
    //  Additional code by Giles Metcalf (giles@lughnasadh.com)
	//	Please leave credit

 /**
 * This file is part of the "Approved Users" plugin for Wolf CMS.
 * Licensed under an MIT style license. For full details see license.txt.
 *
 * @author Giles Metcalf <giles@lughnasadh.com>
 * @copyright Giles Metcalf, 2015
 * 
 * Original authors:
 * 
 * @author Andrew Waters <andrew@band-x.org>
 * @copyright Andrew Waters, 2009
 *
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @copyright Martijn van der Kleijn, 2009-2013
 */
 
   /*
	*	Contains the following functions for the Front End :
	*	
	*	ap_register_page()			Use this on the page you want to have for registrations eg mysite.com/register
	*	ap_login_page()				Use this on the page you want to have for logging in eg mysite.com/login
	*	ap_confirm_page()			This is the page a user clicks through to validate their account
	*	ap_auth_required_page()		Users who are not authorised to view the requested page will be redirected here
	*	ap_reset_page()				Will allow a user to have an email sent to them with a lnk to reset their password
	*	ap_logout()					A page to logout a user and return them to the hompage
	*/

function approved_users_page_found($page) {
    $PDO = Record::getConnection();

	// If login is required for the page
	if ($page->getLoginNeeded() == Page::LOGIN_REQUIRED) {

		AuthUser::load();
	
		// Not Logged In
		if ( ! AuthUser::isLoggedIn()) {
	
			// Get the current page id
			$requested_page_id = $page->id();
			
			// Let's get the page that is set as the login page to prevent any loopbacks
			$getloginpage = 'SELECT * FROM '.TABLE_PREFIX."page WHERE behavior_id='login_page'";
			$getloginpage = $PDO->prepare($getloginpage);
			$getloginpage->execute();
	
			while ($loginpage = $getloginpage->fetchObject()) {
				$slug = $loginpage->slug;
                print_r($loginpage);
			}
	
			if ($requested_page_id != $loginpage_id) {
				header('Location: '.BASE_URL.$slug);
			}
	
		}
	
		// User is logged in
		else {
			// We need to check if the user has permission to access the page
			
			// Get requested page id
			$requested_page_id = $page->id();

			// Get permissions that are required for this page
			$permissions_check = "SELECT * FROM ".TABLE_PREFIX."permission_page WHERE page_id='$requested_page_id'";
			$permissions_check = $PDO->prepare($permissions_check);
			$permissions_check->execute();

			$permission_array = array();

			while ($permission = $permissions_check->fetchObject()) {
				$page_permission = $permission->permission_id;
				array_push($permission_array, $page_permission);
			}

			$permissions_count = count($permission_array);

			AuthUser::load();
			$userid = AuthUser::getRecord()->id;

			// Get permissions that this user has
                        /*
			$user_permissions_check = "SELECT * FROM ".TABLE_PREFIX."user_permission WHERE user_id='$userid'";
			$user_permissions_check = $__CMS_CONN__->prepare($user_permissions_check);
			$user_permissions_check->execute();

			$user_permissions_array = array();

			while ($user_permissions = $user_permissions_check->fetchObject()) {
				$user_permission = $user_permissions->permission_id;
				array_push($user_permissions_array, $user_permission);
			}*/
                        $roles = AuthUser::getRecord()->roles();
                        foreach ($roles as $role) {
                            $user_permissions_array[] = $role->id;
                        }
			
			$permission_result = array_intersect($permission_array, $user_permissions_array);
			
			$permission_result_count = count($permission_result);

			if($permission_result_count < 1 && AuthUser::getId() != 1) {
				// Let's get the authorisation required page
                $auth_required_page = Plugin::getSetting("auth_required_page", "approved_users");
				header('Location: '.URL_PUBLIC.''.$auth_required_page.'');
			}
		}
	}
}



function approved_users_access_page_checkbox($page) {

    $PDO = Record::getConnection();
    $page_id = $page->id;
        $roles = Role::findAllFrom('Role');

	echo '<label for="access">Access:</label> ';

        foreach ($roles as $role) {
		//global $__CMS_CONN__;
		$id = $role->id;
		$name = $role->name;

		echo '<input id="permission_'.$id.'" name="permission_'.$id.'" type="checkbox"';

		$permissions_check = "SELECT * FROM ".TABLE_PREFIX."permission_page WHERE page_id='$page_id'";
		$permissions_check = $PDO->prepare($permissions_check);
		$permissions_check->execute();

		while ($permissions_checked = $permissions_check->fetchObject()) {
			$page_permission = $permissions_checked->permission_id;
			if ($id == $page_permission) {
				echo 'checked';
			} 
		}

		echo ' value="allowed" /> '.$name.' | ';
	}
	echo '<div class="clear"></div>';
}


function approved_users_add_page_permissions($page) {

    $PDO = Record::getConnection();
    $page_id = $page->id;

        $roles = Role::findAllFrom('Role');

        foreach ($roles as $role) {
		$id = $role->id;

        if (isset($_POST['permission_'.$id.''])) {
            $permission = $_POST['permission_'.$id.''];
    		if ($permission == 'allowed') {
        		$add_page_permission = "INSERT INTO ".TABLE_PREFIX."permission_page VALUES ('".$page_id."','".$id."')";
            	$add_page_permission = $PDO->prepare($add_page_permission);
                $add_page_permission->execute();
            }
		}
	}
}


function approved_users_edit_page_permissions($page) {

	$PDO = Record::getConnection();
    $page_id = $page->id;
	
	/*$permissions_list = "SELECT * FROM ".TABLE_PREFIX."permission";
	$permissions_list = $__CMS_CONN__->prepare($permissions_list);
	$permissions_list->execute();*/
        
        $roles = Role::findAllFrom('Role');

	$delete_page_permission = "DELETE FROM ".TABLE_PREFIX."permission_page WHERE page_id = '$page_id'";
	$delete_page_permission = $PDO->prepare($delete_page_permission);
	$delete_page_permission->execute();


	//while ($permission = $permissions_list->fetchObject()) {
        foreach ($roles as $role) {
		$id = $role->id;

		if (isset($_POST['permission_'.$id.''])) {
            $permission = $_POST['permission_'.$id.''];
            if ($permission == 'allowed') {
                $add_page_permission = "INSERT INTO ".TABLE_PREFIX."permission_page VALUES ('".$page_id."','".$id."')";
                $add_page_permission = $PDO->prepare($add_page_permission);
                $add_page_permission->execute();
            }
        }
	}
}


function approved_users_delete_page_permissions($page) {

	// This function cleans up the database if the page is deleted from the site
	$PDO = Record::getConnection();
    $page_id = $page->id;
	$delete_page_permission = "DELETE FROM ".TABLE_PREFIX."permission_page WHERE page_id = '$page_id'";
	$delete_page_permission = $PDO->prepare($delete_page_permission);
	$delete_page_permission->execute();
	
}
