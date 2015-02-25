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

$snippet = Snippet::findByName('ap-registration');

if (false !== $snippet) {
    eval('?' . '>' . $snippet->content_html);
    return true;
} else {
    ?>

    <p><label for="name">Name</label>
        <input class="text-input validate['required']" id="name" maxlength="100" name="name" size="20" type="text" value="" /></p>
	<!-- Added Membership number and postcode fields here -->
    <p><label for="member_no">Membership number</label>
        <input class="text-input validate['required']" id="member_no" maxlength="15" name="member_no" size="10" type="text" value="" /></p>
    <p><label for="member_post_code">Postcode</label>
        <input class="text-input validate['required']" id="member_post_code" maxlength="15" name="member_post_code" size="10" type="text" value="" /></p>
    <p><label for="email">E-mail</label>
        <input class="text-input validate['required','email']" id="email" maxlength="40" name="email" size="20" type="text" value="" /></p>
    <p><label for="username">Username</label>
        <input class="text-input validate['required']" id="username" maxlength="40" name="username" size="20" type="text" value="" /></p>
    <p><label for="password">Password</label>
        <input class="text-input validate['required']" id="password" maxlength="40" name="password" size="20" type="password" value="" /></p>
    <p><label for="confirm_pass">Confirm Password</label>
        <input class="text-input validate['required','confirm[password]']" id="confirm_pass" maxlength="40" name="confirm_pass" size="20" type="password" value="" /></p>
    <p><label for="signup"> </label><input id="submit_btn" class="btn submit" type="submit" accesskey="s" value="Register" /></p>

<?php } ?>