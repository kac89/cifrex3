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

if((isset($_POST['name']) AND empty($_POST['name']) ) OR !isset($_POST['name'])){ header("HTTP/1.1 500 Internal Server Error"); die("error name"); }
if((isset($_POST['description']) AND empty($_POST['description']) ) OR !isset($_POST['description'])){ header("HTTP/1.1 500 Internal Server Error"); die("error description"); }
if((isset($_POST['path']) AND empty($_POST['path']) ) OR !isset($_POST['path'])){ header("HTTP/1.1 500 Internal Server Error"); die("error source"); }
if((isset($_POST['custom_files']) AND empty($_POST['custom_files']) ) OR !isset($_POST['custom_files'])){ header("HTTP/1.1 500 Internal Server Error"); die("error custom_files"); }
if(!isset($_POST['source'])){ $_POST['source']=''; }

$dateux=date("U");

$dbLink->insertSql("INSERT INTO `cifrex_groups` (`group_id`, `name`, `description`, `path`,  `custom_files`, `source`, `date_created`, `date_lastmod`) VALUES (NULL, '".addslashes($_POST['name'])."', '".addslashes($_POST['description'])."', '".addslashes($_POST['path'])."', '".addslashes($_POST['custom_files'])."', '".addslashes($_POST['source'])."', '".intval($dateux)."', '".intval($dateux)."');");
die("{}");
?>