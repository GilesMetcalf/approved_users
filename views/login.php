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

$snippet = Snippet::findByName('ap-login');

if (false !== $snippet) {
    eval('?' . '>' . $snippet->content_html);
    return true;
} else { ?>

    <p><label for="login-username"><?php echo __('Username'); ?></label> <input id="login-username" type="text" name="login[username]" value="" /></p>
    <p><label for="login-password"><?php echo __('Password'); ?></label> <input id="login-password" type="password" name="login[password]" value="" /></p>
    <input id="login-redirect" type="hidden" name="login[redirect]" value="<?php echo BASE_URL . CURRENT_URI . URL_SUFFIX; ?>" />
    <p><label class="checkbox" for="login-remember-me"><?php echo __('Stay logged in');?></label> <input id="login-remember-me" type="checkbox" class="checkbox" name="login[remember]" value="checked" /></p>
    <p><label for="submit"> </label><input id="submit_btn" class="btn submit" type="submit" accesskey="s" value="<?php echo __('Log in');?>" /></p>

<?php } ?>
