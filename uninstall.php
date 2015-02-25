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

/* Prevent direct access. */
if (!defined('IN_CMS')) { exit(); }

$sql = 'DROP TABLE IF EXISTS `' . TABLE_PREFIX . 'approved_users_temp`';
$pdo = Record::getConnection();
$pdo->exec($sql);

$sql = 'DROP TABLE IF EXISTS `' . TABLE_PREFIX . 'permission_page`';
$pdo = Record::getConnection();
$pdo->exec($sql);
