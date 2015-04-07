<?php

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
 * Contains the following functions for the Front End :
 *
 * ap_register_page()           Use this on the page you want to have for registrations eg mysite.com/register
 * ap_login_page()		Use this on the page you want to have for logging in eg mysite.com/login
 * ap_confirm_page()		This is the page a user clicks through to validate their account
 * ap_auth_required_page()	Users who are not authorised to view the requested page will be redirected here
 * ap_reset_page()		Will allow a user to have an email sent to them with a link to reset their password
 * ap_logout()			A page to logout a user and return them to the home page
 */
 
class ApprovedUsersController extends PluginController {

    public function __construct() {
        $this->setLayout('backend');
        $this->assignToLayout('sidebar', new View('../../plugins/approved_users/views/sidebar'));
    }

    public function index() {
        $this->documentation();
    }

    public function documentation() {
        $this->display('approved_users/views/documentation');
    }

    function settings() {
        $roles = Role::findAllFrom('Role');

        $this->display('approved_users/views/settings', array(
            'roles' => $roles,
            'settings' => Plugin::getAllSettings('approved_users')));
    }

    public function groups() {
        $roles = Role::findAllFrom('Role');

        $this->display('approved_users/views/groups', array('roles' => $roles));
    }

    function notvalidated() {
        $this->display('approved_users/views/notvalidated');
    }

	// GM - New function here to show the "Approvals" administrative page
   function approvals() {
        $this->display('approved_users/views/approvals');
    }

	// GM - New function here to show the "Fast Register" administrative page
   function fast_register_load() {
        $this->display('approved_users/views/fastregister');
    }

     function statistics() {
        $this->display('approved_users/views/statistics');
    }

    public function edit_settings() {
        if (isset($_POST['settings'])) {
            if (Plugin::setAllSettings($_POST['settings'], 'approved_users')) {
                Flash::set('success', __('The settings have been saved.'));
            } else {
                Flash::set('error', __('An error occurred trying to save the settings.'));
            }
        } else {
            Flash::set('error', __('Could not save settings, no settings found.'));
        }

        redirect(get_url('plugin/approved_users/settings'));
    }

	/**
	* GM - This function is called from the Approvals page
	*
	* This is the heart of the changes from the original Registered Users plugin, where we have
	* separated the initial registration operation from the final approval and sending of the validation
	* email.
	* It iterates through each approval row (passed as an array) and decides what to do deepening on the
	* value of the approved row.
	*
	* TODO: Include additional code for rejected applications
	*
	**/
	
   public function send_approvals() {
         if (isset($_POST['approval'])) {
             $PDO = Record::getConnection();
			 $common = new APCommon();
   			 foreach($_POST['approval'] as $id){
				
				//Find the record in the temp table and send the confirmation email
				$sql = "SELECT * FROM ". TABLE_PREFIX . "approved_users_temp WHERE id=:id";
                $stmt = $PDO->prepare($sql);
                $stmt->execute(array("id" => $id));
				$row = $stmt->fetch();
				$email = $row[2];
				$name = $row[1];
				$common->confirmation_email($email, $name);
				
				//Update the temp table to mark row as processed
                $sql = "UPDATE " . TABLE_PREFIX . "approved_users_temp SET processed=1 WHERE id=:id";
                $stmt = $PDO->prepare($sql);
                $stmt->execute(array("id" => $id));
			 }
       
  			Flash::set('success', __('Approvals processed'));
   		} else {
            Flash::set('error', __('Unable to process approvals'));
        }

        redirect(get_url('plugin/approved_users/approvals'));
   }

    public function add_user_group() {
        $new_group = trim($_POST['new_group']);
        if (isset($_POST['default']))
            $default = true;
        else
            $default = false;

        if ($new_group == '' || empty($new_group)) {
            Flash::set('error', __('You need to enter a name for your new user group'));
            redirect(get_url('plugin/approved_users/groups'));
        } else {
            $role = new Role();
            $role->name = $new_group;
            $role->save();

            if ($default) {
                Plugin::setSetting("default_permissions", $role->id, "approved_users");
            }

            Flash::set('success', __('The ' . $new_group . ' user group has been added'));
            redirect(get_url('plugin/approved_users/groups'));
        }
    }

    public function add_first_user_group() {
        //global $__CMS_CONN__;
        $PDO = Record::getConnection();
        $new_group_name = $_POST['new_group_name'];
        if ($new_group_name == '' || empty($new_group_name)) {
            Flash::set('error', __('You need to enter a name for your new user group'));
            redirect(get_url('plugin/approved_users/permissions'));
        } else {
            $sql = "INSERT INTO " . TABLE_PREFIX . "permission VALUES ('', :group)";
            $stmt = $PDO->prepare($sql);
            $stmt->execute(array("group" => $new_group_name));
            $sql = "SELECT * FROM " . TABLE_PREFIX . "permission WHERE name=:group";
            $stmt = $PDO->prepare($sql);
            $stmt->execute(array("group" => $new_group_name));
            while ($st = $stmt->fetchObject()) {
                $id = $st->id;
            }
            $this->makedefault($id);
        }
    }

    public function rename_user_group() {
        $name = trim($_POST['renamed']);
        $id = trim($_POST['id']);
        $role = Role::findById($id);
        $role->name = $name;

        if ($role->save()) {
            Flash::set('success', __('' . $name . ' has been updated.'));
            redirect(get_url('plugin/approved_users/groups'));
        } else {
            Flash::set('error', __('Unable to rename group! (' . $name . ')'));
            redirect(get_url('plugin/approved_users/groups'));
        }
    }

    public function makedefault($id) {
        Plugin::setSetting("default_permissions", $id, "approved_users");

        Flash::set('success', __('The default user group has been changed'));
        redirect(get_url('plugin/approved_users/groups'));
    }

    public function delete($id) {
        $role = Role::findById($id);

        if ($role->delete()) {
            Flash::set('success', __('The ' . $name . ' user group has been deleted.'));
            redirect(get_url('plugin/approved_users/groups'));
        } else {
            Flash::set('success', __('Unable to delete the ' . $name . ' user group!'));
            redirect(get_url('plugin/approved_users/groups'));
        }
    }

    function checkfordb() {
        $PDO = Record::getConnection();
        return $PDO->exec("SELECT version FROM " . TABLE_PREFIX . "approved_users_temp") !== false;
    }

}
