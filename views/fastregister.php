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
**/
?>

<h1><?php echo __('Load FastRegister Database'); ?></h1>
<p>
A CSV file of membership numbers and postcodes must be processed to populate the Fast Register database. 
The CSV file must contain just two columns, the membership number and the postcode. No header row is required.
</p><p>
The file can be exported from Excel, generated from another database, or hand-built in a text editor. 
The completed file must be uploaded to the "public/uploads" file area using Wolf administrative tools.
</p><p>
Use this  form to enter the name of the CSV file  to update the Fast Register database. Do not enter the path, as 
this is generated internally.
</p>
<p>&nbsp; </p>

<form id="fastregisterload" action="<?php echo get_url('plugin/approved_users/fastregisterload/'); ?>" method="post">

    Enter filename to process:
    <input type="text" name="fileToUpload" id="fileToUpload"> 

<input id="commit" name ="uploadfile" class="btn submit" type="submit" accesskey="s" value="Process FR file" />

</form>

<p>&nbsp; </p>
<p><strong>Note:</strong> Very large files of data may take some time to process. Please be patient - you will be notified when it is complete!</p>
