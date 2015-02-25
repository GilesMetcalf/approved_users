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
 
 /**
 * This is a complete new view for the Approvals administrative page
 * It allows an administrator to view applications, and select those that can be approved
 * TODO: Rejections
 **/
 
?>
<style>
    .odd { background-color: #efefef; }
    td { padding: 0.5em; }
</style>
<h1><?php echo __('Approvals'); ?></h1>

<p>
    Below is a list of registrations awaiting approval for the <?php echo Setting::get('admin_title'); ?>
    website. 
</p>

<form id="approvals" action="<?php echo get_url('plugin/approved_users/send_approvals/'); ?>" method="post" >

<table style="width: 100%; margin: 1em 2em 1em 0em;">
    <thead>
        <tr>
            <th class="page"><?php echo __('Name'); ?></th>
            <th class="page"><?php echo __('Membership No.'); ?></th>
            <th class="page"><?php echo __('Postcode'); ?></th>
            <th class="page"><?php echo __('Approve'); ?></th>
        </tr>
    </thead>

	<?php
    // Check for entries in the temp table
    $PDO = Record::getConnection();

    // Check temp table
    $check_new_registrations = "SELECT * FROM " . TABLE_PREFIX . "approved_users_temp WHERE processed=0";
    $result = $PDO->prepare($check_new_registrations);
    $result->execute();
	?>
	
    <tbody>
	    <?php
		while ($row = $result->fetch()) {        
			$id = $row[0];
			$name = $row[1];
			$member_no = $row[7];        
			$member_post_code = $row[8];        
		?>
		
            <tr class="<?php echo odd_even(); ?>">
                <td> <?php echo '<strong>'.$name.'</strong>'; ?></td>
                <td> <?php echo $member_no; ?></td>
                <td> <?php echo $member_post_code; ?></td>
                <td> <input type="checkbox" name="approval[]" value=<?php echo $id; ?> /></td>
                    
            </tr>
	     <?php } ?>
	     
	     
	     
    </tbody>
</table>


<input id="commit" name ="send_approvals" class="btn submit" type="submit" accesskey="s" value="Approve" />


</form>

<div id="boxes">
    <div id="add-user-group" class="window">
        <div class="titlebar">
            <?php echo __('Add user group'); ?>
            <a href="#" class="close">[x]</a>
        </div>
        <div class="content">
            <form action="<?php echo get_url('plugin/approved_users/add_user_group/'); ?>" method="post" name="add_user_group">
                <p>Group Name <input id="new_group" maxlength="255" name="new_group" type="text" value="" /></p>
                <p>Make default group for new users? <input type="checkbox" name="default" value="1" /></p>
                <input id="add_user_group_button" name="commit" type="submit" value="<?php echo __('Add user group'); ?>" />
            </form>
        </div>
    </div>

    <div id="rename_user_group" class="window">
        <div class="titlebar">
            <?php echo __('Rename group'); ?>
            <a href="#" class="close">[x]</a>
        </div>
        <div class="content">
            <form action="<?php echo get_url('plugin/approved_users/rename_user_group/'); ?>" method="post" name="rename_user_group">
                <input type="hidden" id="rename_user_group_id" name="id" value="'.$id.'" />
                <p>Group Name <input id="rename_user_group_new_name" maxlength="255" name="renamed" type="text" value="" /></p>
                <input id="add_user_group_button" name="commit" type="submit" value="<?php echo __('Rename group'); ?>" />
            </form>
        </div>
    </div>
</div>

<div id="popups">
    <div class="popup" id="rename_user_group" style="display:none;">
        <h3><?php echo __('Rename group'); ?></h3>
        <form action="<?php echo get_url('plugin/approved_users/rename_user_group/'); ?>" method="post"> 
            <div>
                <input type="hidden" id="rename_user_group_id" name="id" value="'.$id.'" />
                <p>Group Name <input id="rename_user_group_new_name" maxlength="255" name="renamed" type="text" value="" /></p>
                <input id="add_user_group_button" name="commit" type="submit" value="<?php echo __('Rename group'); ?>" />
            </div>
            <p><a class="close-link" href="#" onclick="toggle_rename_popup(); return false;"><?php echo __('Close'); ?></a></p>
        </form>
    </div>
</div>



 


