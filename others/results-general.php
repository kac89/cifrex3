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

$dbLink->sql("SELECT * FROM `cifrex_results`");

header('Content-Type: application/json');

$results=$dbLink->getResults();

echo "[";

for($filtrycount=0; $filtrycount<$dbLink->numOfRows(); $filtrycount++)
{

	echo stripslashes('{"result_id":"'.$results[$filtrycount]["result_id"].'",
"name":"'.stripJs($results[$filtrycount]["name"]).'",
"date":"'.date("Y/m/d H:i:s", $results[$filtrycount]["date"]).'",
"path":"'.stripJs($results[$filtrycount]["path"]).'",
"files":"'.stripJs($results[$filtrycount]["files"]).'",
"credit":"'.stripJs($results[$filtrycount]["credit"]).'",
"count":"'.stripJs($results[$filtrycount]["count_result"]).'"}');

	if($filtrycount!=$dbLink->numOfRows()-1) echo ",";
}

echo "]";

?>