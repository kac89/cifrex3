<?php
//  
//    cIFrex Tool for Static Code Analysis
//    Copyright (C) 2015 cIFrex Team
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program.  If not, see http://www.gnu.org/licenses/.
//

include './../config.php';
include './../include/general/db.php';

// create link to database
$dbLink = new dbEngine($cconfig['db_config']);

if((isset($_POST['group_id']) AND empty($_POST['group_id']) ) OR !isset($_POST['group_id'])) { header("HTTP/1.1 500 Internal Server Error"); die("error id"); }
if(isset($_POST['group_id']) AND !is_numeric($_POST['group_id'])) { header("HTTP/1.1 500 Internal Server Error");  die("error no integer"); }

$dbLink->deleteSql("DELETE FROM `cifrex_groups` WHERE `group_id` = ".intval($_POST['group_id']));
$dbLink->deleteSql("DELETE FROM `cifrex_relation_fil_gro` WHERE `group_id` = ".intval($_POST['group_id']));

die("{}");
?>