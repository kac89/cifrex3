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

if(!isset($_POST['group_id']) OR (isset($_POST['group_id']) AND empty($_POST['group_id']))){ header("HTTP/1.1 500 Internal Server Error"); die("error group id"); }
if((isset($_POST['name']) AND empty($_POST['name']) ) OR !isset($_POST['name'])){ header("HTTP/1.1 500 Internal Server Error"); die("error name"); }
if((isset($_POST['description']) AND empty($_POST['description']) ) OR !isset($_POST['description'])){ header("HTTP/1.1 500 Internal Server Error"); die("error description"); }
if((isset($_POST['path']) AND empty($_POST['path']) ) OR !isset($_POST['path'])){ header("HTTP/1.1 500 Internal Server Error"); die("error source"); }
if((isset($_POST['custom_files']) AND empty($_POST['custom_files']) ) OR !isset($_POST['custom_files'])){ header("HTTP/1.1 500 Internal Server Error"); die("error custom_files"); }
if(!isset($_POST['source'])){ $_POST['source']=''; }


$dbLink->sql("SELECT group_id FROM cifrex_groups WHERE group_id=".intval($_POST['group_id']));
if($dbLink->numOfRows()!=1) die("Not exists");    
$dateux=date("U");

$dbLink->updateSql("UPDATE `cifrex_groups` SET `name` = '".addslashes($_POST['name'])."', `description` = '".addslashes($_POST['description'])."', `path` = '".addslashes($_POST['path'])."', `source` = '".addslashes($_POST['source'])."', `custom_files` = '".addslashes($_POST['custom_files'])."', `date_lastmod` = '".intval($dateux)."' WHERE `cifrex_groups`.`group_id` = ".$_POST['group_id']);

die("{}");
?>