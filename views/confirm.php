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

$snippet = Snippet::findByName('ap-confirmation');

if (false !== $snippet) {
    eval('?' . '>' . $snippet->content_html);
    return true;
} else {
    ?>

<p><label for="email">Email :</label> <input id="email" type="text" name="email" value="" /></p>
<p><label for="rand_key">Authorisation Code :</label> <input id="rand_key" type="text" name="rand_key" value="" /></p>
<p><label for="submit"></label><input id="submit_btn" class="btn submit" type="submit" accesskey="s" value="Activate your account" /></p>

<?php } ?>