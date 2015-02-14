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
include './../include/general/json.php';
include './../include/general/db.php';

// create link to database
$dbLink = new dbEngine($cconfig['db_config']);

$dbLink->sql("SELECT f.filtr_id, f.author, f.filtr_hash, f.cve, f.cwe, f.wlb, f.regexdb_id, f.name, f.description, f.filtr, f.date_created, f.date_lastmod, f.qs_lastused_path, l.name as language_name, l.lang_id, l.name as lang_name, l.files as lang_files
FROM
cifrex_filters as f,
cifrex_languages as l, 
cifrex_relation_lang_fil as relation
WHERE f.filtr_id=relation.filtr_id AND relation.lang_id=l.lang_id");

$results=$dbLink->getResults();
$results_count=$dbLink->numOfRows();

header('Content-Type: application/json');
echo "[";

for($filtrycount=0; $filtrycount<$results_count; $filtrycount++)
{
    
    $dbLink->sql("SELECT g.group_id, g.name as group_name, g.custom_files as group_files
FROM
cifrex_filters as f, 
cifrex_groups as g, 
cifrex_relation_fil_gro as d 
WHERE f.filtr_id=d.filtr_id AND g.group_id=d.group_id AND f.filtr_id='".intval($results[$filtrycount]["filtr_id"])."'");
    $results2=$dbLink->getResults();
    $results_count2=$dbLink->numOfRows();
    $groups=array();
    for($filtrycount2=0; $filtrycount2<$results_count2; $filtrycount2++)
    {
        $groups[$filtrycount2]['group_id'] = intval($results2[$filtrycount2]['group_id']);
        $groups[$filtrycount2]['group_name'] = htmlspecialchars($results2[$filtrycount2]['group_name']);
        $groups[$filtrycount2]['group_files'] = htmlspecialchars($results2[$filtrycount2]['group_files']);
    }
    
	$filtr = json_decode($results[$filtrycount]["filtr"],true);

    $encodeToJ = array(
"id" => $results[$filtrycount]["filtr_id"],
"title" => $results[$filtrycount]["name"],
"description" => ($results[$filtrycount]["description"]),
"author" => ($results[$filtrycount]["author"]),
"env" => ($results[$filtrycount]["language_name"]),
"cve" => ($results[$filtrycount]["cve"]),
"cwe" => ($results[$filtrycount]["cwe"]),
"wlb" => ($results[$filtrycount]["wlb"]),
"lang_id" => ($results[$filtrycount]["lang_id"]),
"lang_name" => ($results[$filtrycount]["lang_name"]),
"lang_files" => ($results[$filtrycount]["lang_files"]),
"groups" => $groups,
"v1" => $filtr['v1'],
"v2" => ($filtr['v2']),
"v3" => ($filtr['v3']),
"t1" => ($filtr['t1']),
"t2" => ($filtr['t2']),
"t3" => ($filtr['t3']),
"f1" => ($filtr['f1']),
"f2" => ($filtr['f2']),
"f3" => ($filtr['f3']),
"diff" => date("Y/m/d H:i:s", $results[$filtrycount]["date_lastmod"]),
"date" => date("Y/m/d H:i:s", $results[$filtrycount]["date_created"]),
"hash" => $results[$filtrycount]["filtr_hash"]
    );
    echo json_encode($encodeToJ);
	if($filtrycount!=$results_count-1) echo ",";
}

echo "]";

?>