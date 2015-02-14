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
include './../include/general/json.php';

// create link to database
$dbLink = new dbEngine($cconfig['db_config']);

header('Content-Type: application/json');

if(isset($_POST['filtr_id']) AND empty($_POST['filtr_id'])){ header("HTTP/1.1 500 Internal Server Error"); die("error name"); }
if(isset($_POST['name']) AND empty($_POST['name'])){ header("HTTP/1.1 500 Internal Server Error"); die("error name"); }
if(isset($_POST['v1']) AND empty($_POST['v1'])){ header("HTTP/1.1 500 Internal Server Error"); die("error v1"); }

if(!isset($_POST['v1']) OR !isset($_POST['v2']) OR !isset($_POST['v3']) OR !isset($_POST['t1']) OR !isset($_POST['t2']) OR !isset($_POST['t3']) OR !isset($_POST['f1']) OR !isset($_POST['f2']) OR !isset($_POST['f3']) OR !isset($_POST['path']) OR !isset($_POST['lang']) OR !isset($_POST['cve']) OR !isset($_POST['cwe']) OR !isset($_POST['author']) OR !isset($_POST['wlb']) OR !isset($_POST['description'])){ header("HTTP/1.1 500 Internal Server Error"); die("syntax"); }


$dbLink->sql("SELECT filtr_id FROM cifrex_filters WHERE filtr_id='".intval($_POST['filtr_id'])."'");
if($dbLink->numOfRows()!=1) die("Not exists");    

$pattern = "{
\"v1\":\"".stripJsSlash($_POST['v1'])."\",
\"v2\":\"".stripJsSlash($_POST['v2'])."\",
\"v3\":\"".stripJsSlash($_POST['v3'])."\",
\"t1\":\"".stripJsSlash($_POST['t1'])."\",
\"t2\":\"".stripJsSlash($_POST['t2'])."\",
\"t3\":\"".stripJsSlash($_POST['t3'])."\",
\"f1\":\"".stripJsSlash($_POST['f1'])."\",
\"f2\":\"".stripJsSlash($_POST['f2'])."\",
\"f3\":\"".stripJsSlash($_POST['f3'])."\"
}";
$dateux=date("U");

$dbLink->updateSql("UPDATE `cifrex_filters` SET `filtr_hash` = '".md5($pattern)."', `author` = '".addslashes($_POST['author'])."', `name` = '".addslashes($_POST['name'])."', `description` = '".addslashes($_POST['description'])."', `cve` = '".addslashes($_POST['cve'])."', `cwe` = '".addslashes($_POST['cwe'])."', `wlb` = '".addslashes($_POST['wlb'])."', `filtr` = '".$pattern."', `date_lastmod` = '".intval($dateux)."', `qs_lastused_path` = '".addslashes($_POST['path'])."' WHERE `cifrex_filters`.`filtr_id` = ".intval($_POST['filtr_id']));

$dbLink->updateSql("UPDATE `cifrex_relation_lang_fil` SET `lang_id` = '".intval($_POST['lang'])."' WHERE `filtr_id` = ".intval($_POST['filtr_id']));

die("{}");
?>