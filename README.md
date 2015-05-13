================
APPROVED USERS
================

By Giles Metcalf <giles@lughnasadh.com>

Original code by: 
  Andrew Waters <andrew@band-x.org>
  Martijn van der Kleijn <martijn.niji@gmail.com>

Licensed under an MIT style license, see license.txt


ABOUT
=====

This plugin will allow you to add a registration and approvals process to your Wolf CMS site.

It adds the following tables to your wolf database:

	permission_page
	approved_users_settings
	approved_users_temp
	fast_register

The administration tab is only available to Site Administrators by design.

NOTES:
=============

As users register on the site, their details will be listed on the "Approvals" page for manual approval. 
Ticking the "Approve" boxes for those users that can be approved, and finally clicking the "Approve" 
button, will bulk approve all checked users, and send registration confirmation emails. Unapproved 
registrants will remain on this list. A "Delete" option will be added at a later stage.

A "fast registration" facility is built in to the system. This allows an Administrator to upload a 
list of potential pre-approved users, so that when they do register, they are automatically approved 
and a confirmation email sent without the need for manual approval.

INSTRUCTIONS:
=============

1.	First upload and unzip the registered_users.zip file into /wolf/plugins

2.	Log in to the admin are of your site and click 'Administration'

3.	Find "Approved Users" in the list and click the checkbox to activate the
    plugin.

4.	Refresh the page and click the new "Approved Users" tab in the navigation.

5.	Follow the instructions on that page. You'll need to create 5 new pages on
    your site and insert the code provided in order to activate all the
    functionality of this plugin.

6.	Customise the settings of your site using the settings button on the sidebar.

7.	If you want to restrict access on your site to certain types of users, edit
    (or add) the page as you usually would. At the end of the page, be sure to
    select 'Login Required' from the drop down menu and then check the user
    types you'd like to give access to. Any groups not checked here will not be
    able to access the page.

8.	To use the fast registration option, a CSV file of membership numbers and 
	postcodes must be uploaded to the server (to the /public/files/uploads/ folder 
	in the Wolf installation directory). The name of this file (no path!), is 
	entered on the "Load Fast Register" tab, and the "Process FR file" button 
	clicked to add the data to the database. This may take a few seconds, so be patient!	
