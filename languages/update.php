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

if(!isset($_POST['lang_id'])){ header("HTTP/1.1 500 Internal Server Error"); die("error id exist"); }
if(isset($_POST['lang_id']) AND empty($_POST['lang_id'])){ header("HTTP/1.1 500 Internal Server Error"); die("error id empty"); }
if(!isset($_POST['name']) OR (isset($_POST['name']) AND empty($_POST['name']))){ header("HTTP/1.1 500 Internal Server Error"); die("error name"); }
if(!isset($_POST['description']) OR (isset($_POST['description']) AND empty($_POST['description']))){ header("HTTP/1.1 500 Internal Server Error"); die("error description"); }
if(!isset($_POST['files']) OR (isset($_POST['files']) AND empty($_POST['files']))){ header("HTTP/1.1 500 Internal Server Error"); die("error files"); }

$dbLink->sql("SELECT lang_id FROM cifrex_languages WHERE lang_id=".intval($_POST['lang_id']));
if($dbLink->numOfRows()!=1){ header("HTTP/1.1 500 Internal Server Error");  die("Not exists"); }

$dateux=date("U");

$dbLink->updateSql("UPDATE cifrex_languages SET `name` = '".addslashes($_POST['name'])."', `description` = '".addslashes($_POST['description'])."', `files` = '".addslashes($_POST['files'])."',  `date_lastmod` = '".addslashes($dateux)."' WHERE `lang_id` = ".intval($_POST['lang_id']));

header('Content-Type: application/json');
die("{}");
?>