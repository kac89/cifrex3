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

header('Content-Type: application/json');

if(!isset($_POST['lang_id'])){ header("HTTP/1.1 500 Internal Server Error"); die("error id exist"); }
if(isset($_POST['lang_id']) AND empty($_POST['lang_id'])) { header("HTTP/1.1 500 Internal Server Error"); die("error id"); }
if(isset($_POST['lang_id']) AND !is_numeric($_POST['lang_id'])) { header("HTTP/1.1 500 Internal Server Error");  die("no integer"); }

$dbLink->deleteSql("DELETE FROM `cifrex_languages` WHERE `cifrex_languages`.`lang_id` = ".intval($_POST['lang_id']));
$dbLink->updateSql("UPDATE cifrex_relation_lang_fil SET `lang_id` = '0' WHERE `lang_id` = ".intval($_POST['lang_id']));
die("{}");
?>