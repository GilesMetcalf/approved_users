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
* This is a complete new view for the Fast Register database load administrative page
* It allows an administrator to upload a new fast register CSV file and update the database
* TODO: All of it, really...
**/
?>

<h1><?php echo __('Load FastRegister Database'); ?></h1>
<p>
Use this  form to select a CSV file of membership numbers and postcodes to update the Fast Register database.
</p>
<p>Note that the CSV file must contain just two columns, the membership number and the postcode. No header row is required.</p>

<form id="fastregisterload" action="<?php echo get_url('plugin/approved_users/fastregisterload/'); ?>" method="post" enctype="multipart/form-data">

    Select fileto upload:
    <input type="file" name="fileToUpload" id="fileToUpload">

<input id="commit" name ="uploadfile" class="btn submit" type="submit" accesskey="s" value="Upload FR file" />

</form>
