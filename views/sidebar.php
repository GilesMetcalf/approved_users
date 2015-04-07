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
?>
<p class="button"><a href="<?php echo get_url('plugin/approved_users/statistics'); ?>"><img src="<?php echo PLUGINS_URI; ?>approved_users/images/statistics.png" align="middle"><?php echo __('Statistics');?></a></p>
<p class="button"><a href="<?php echo get_url('plugin/approved_users/groups'); ?>"><img src="<?php echo PLUGINS_URI; ?>approved_users/images/groups.png" align="middle"><?php echo __('User Roles');?></a></p>

<!-- New button for the Approvals tab -->
<p class="button"><a href="<?php echo get_url('plugin/approved_users/approvals'); ?>"><img src="<?php echo PLUGINS_URI; ?>approved_users/images/approvals.png" align="middle"><?php echo __('Approvals');?></a></p>
<p class="button"><a href="<?php echo get_url('plugin/approved_users/approvals'); ?>"><img src="<?php echo PLUGINS_URI; ?>approved_users/images/approvals.png" align="middle"><?php echo __('Load Fast Register');?></a></p>
<p class="button"><a href="<?php echo get_url('user'); ?>"><img src="<?php echo PLUGINS_URI; ?>approved_users/images/user.png" align="middle"><?php echo __('Users');?></a></p>
<p class="button"><a href="<?php echo get_url('plugin/approved_users/settings'); ?>"><img src="<?php echo ICONS_URI; ?>settings-32-ns.png" align="middle"><?php echo __('Settings');?></a></p>
<p class="button"><a href="<?php echo get_url('plugin/approved_users/documentation'); ?>"><img src="<?php echo ICONS_URI; ?>documentation-32-ns.png" align="middle"><?php echo __('Documentation');?></a></p>

<div class="box">
    <h3><?php echo __('Approved Users'); ?></h3>
    <p><?php echo __('This plugin allows you to manage user registrations and approvals through your Wolf CMS site.'); ?></p>
    <p><?php echo __('It controls the administration of user groups as well as the front end elements of login, logout and registration forms.'); ?></p>
    <p><a href="http://vanderkleijn.net/software/registered-users">http://vanderkleijn.net/software/registered-users</a></p>
</div>
