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

$resultId=0;
if(isset($_GET['resId']) AND !empty($_GET['resId'])){
    $resultId = intval($_GET['resId']);
} else {
    die("missing resId");   
}

header('Content-Type: application/json');

$dbLink->sql("SELECT * FROM `cifrex_results` as r, `cifrex_results_details` as d WHERE r.result_id = d.result_id AND r.result_id = '".$resultId."'");

if($dbLink->numOfRows()!=1) die("ups! not exist".$dbLink->numOfRows());

$results=$dbLink->getResults();

$filtrycount=0;
$results[$filtrycount]["date"] = date("Y/m/d H:i:s", $results[$filtrycount]["date"]);

	$filtr = json_decode($results[$filtrycount]["filtr"],true);


	echo stripslashes('{"result_id":"'.$results[$filtrycount]["result_id"].'",
"name":"'.stripJs($results[$filtrycount]["name"]).'",
"date":"'.$results[$filtrycount]["date"].'",
"path":"'.stripJs($results[$filtrycount]["path"]).'",
"files":"'.stripJs($results[$filtrycount]["files"]).'",
"credit":"'.stripJs($results[$filtrycount]["credit"]).'",
"filtr":{
"v1":"'.doubleSlash($filtr['v1']).'",
"v2":"'.doubleSlash($filtr['v2']).'",
"v3":"'.doubleSlash($filtr['v3']).'",
"t1":"'.doubleSlash($filtr['t1']).'",
"t2":"'.doubleSlash($filtr['t2']).'",
"t3":"'.doubleSlash($filtr['t3']).'",
"f1":"'.doubleSlash($filtr['f1']).'",
"f2":"'.doubleSlash($filtr['f2']).'",
"f3":"'.doubleSlash($filtr['f3']).'"
},
"result":'.($results[$filtrycount]["result"]).',
"debug_log":"'.stripJs($results[$filtrycount]["debug_log"]).'",
"hasz":"'.stripJs($results[$filtrycount]["hasz"]).'",
"count":"'.stripJs($results[$filtrycount]["count_result"]).'"}');

?>