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

Plugin::setInfos(array(
    'id'          => 'approved_users',
    'title'       => 'Approved Users',
    'description' => 'Allows you to manage and approve new user registrations on your site.',
    'version'     => '0.1',
    'author'      => 'Giles Metcalf',
    'require_wolf_version' => '0.7.7'
));

// Only when the plugin is enabled
if (Plugin::isEnabled('approved_users')) {

    Plugin::addController('approved_users', 'Approved Users', 'admin_edit', true);

    Observer::observe('view_page_edit_plugins',	'approved_users_access_page_checkbox');
    Observer::observe('page_add_after_save',	'approved_users_add_page_permissions');
    Observer::observe('page_edit_after_save',	'approved_users_edit_page_permissions');
    Observer::observe('page_delete',		'approved_users_delete_page_permissions');
    Observer::observe('page_found',		'approved_users_page_found');

    Behavior::add('login_page', '');

    include('classes/ApprovedUser.php');
    include('classes/APCommon.php');
    include('observers/APObservers.php');

// Functions to display pages from functions
    
    function ap_login_page() {
        $approved_users_class = new ApprovedUser();
        $loginpage = $approved_users_class->login_page();
        echo $loginpage;
    }

    function ap_register_page() {
        $approved_users_class = new ApprovedUser();
        $registerpage = $approved_users_class->registration_page();
        echo $registerpage;
    }

    function ap_confirm_page() {
        $approved_users_class = new ApprovedUser();
        $confirmation_page = $approved_users_class->confirm();
        echo $confirmation_page;
    }

    function ap_auth_required_page() {
        $approved_users_class = new ApprovedUser();
        $auth_required_page = $approved_users_class->auth_required_page();
        echo $auth_required_page;
    }

    function ap_reset_page() {
        $approved_users_class = new ApprovedUser();
        $reset_page = $approved_users_class->password_reset();
        echo $reset_page;
    }

    function ap_logout() {
        // Allow plugins to handle logout events
            Observer::notify('logout_requested');

            $username = AuthUser::getUserName();
            AuthUser::logout();
            Observer::notify('admin_after_logout', $username);
            redirect(get_url());
    }
}
