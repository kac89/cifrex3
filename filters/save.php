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

if(!isset($_POST['name']) OR ( isset($_POST['name']) AND empty($_POST['name']))){ header("HTTP/1.1 500 Internal Server Error"); die("error name"); }
if(!isset($_POST['v1']) OR (isset($_POST['v1']) AND empty($_POST['v1']))){ header("HTTP/1.1 500 Internal Server Error"); die("error v1"); }

if(!isset($_POST['v1']) OR !isset($_POST['v2']) OR !isset($_POST['v3']) OR !isset($_POST['t1']) OR !isset($_POST['t2']) OR !isset($_POST['t3']) OR !isset($_POST['f1']) OR !isset($_POST['f2']) OR !isset($_POST['f3']) OR !isset($_POST['path']) OR !isset($_POST['group']) OR !isset($_POST['lang']) OR !isset($_POST['cve']) OR !isset($_POST['cwe']) OR !isset($_POST['author']) OR !isset($_POST['wlb']) OR !isset($_POST['description'])){ header("HTTP/1.1 500 Internal Server Error"); die("syntax"); }

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

$dbLink->insertSql("INSERT INTO `cifrex_filters` (`filtr_id`, `filtr_hash`, `regexdb_id`, `author`, `name`, `description`, `cve`, `cwe`, `wlb`, `filtr`, `date_created`, `date_lastmod`, `qs_lastused_path`) VALUES (NULL, '".md5($pattern)."', 0, '".addslashes($_POST['author'])."', '".addslashes($_POST['name'])."', '".addslashes($_POST['description'])."',
'".addslashes($_POST['cve'])."',
'".addslashes($_POST['cwe'])."',
'".addslashes($_POST['wlb'])."',
'".$pattern."', '".$dateux."', 
'".$dateux."', 
'".addslashes($_POST['path'])."')");
$new_filtr_id = $dbLink->lastInsert;

if(isset($_POST['lang'])){
	$dbLink->sql("SELECT lang_id FROM cifrex_languages WHERE lang_id='".intval($_POST['lang'])."' ");
	if($dbLink->numOfRows()!=1) print ( "Error LANGUAGE NOT EXISTS " );
	else {
		$dbLink->sql_execute("INSERT INTO `cifrex_relation_lang_fil` (`relation_fl`, `lang_id`, `filtr_id`) VALUES (NULL, '".intval($_POST['lang'])."', '".intval($new_filtr_id)."');");
	}
}

if(!empty($_POST['group']) AND is_numeric($_POST['group'])){
	$dbLink->sql("SELECT group_id FROM cifrex_groups WHERE group_id='".intval($_POST['group'])."'");
	if($dbLink->numOfRows()!=1) print ( "Error GROUP NOT EXISTS " );
	else {
		$dbLink->sql_execute("INSERT INTO `cifrex_relation_fil_gro` (`relation_fg`, `filtr_id`, `group_id`) VALUES (NULL, '".intval($new_filtr_id)."', '".intval($_POST['group'])."');");
	}
}


die("{}");
?>