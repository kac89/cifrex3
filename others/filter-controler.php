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

if( !isset($_POST['action']) OR ($_POST['action']!='lang' AND $_POST['action']!='group') ) die("action baby"); 
if( !isset($_POST['lang_id']) OR !is_numeric($_POST['lang_id'])) die("lang_id baby"); 
if( !isset($_POST['filters']) ) die("filters baby"); 

$incoming=explode("|", $_POST['filters']);

if($_POST['action']=='lang'){
    $table='cifrex_languages';
    $table2='cifrex_relation_lang_fil';
    $what='lang_id';
} else {
    $table='cifrex_groups';
    $table2='cifrex_relation_fil_gro';
    $what='group_id';
}
   
$Ids=intval($_POST['lang_id']);

$dbLink->sql("SELECT * FROM ".$table." WHERE ".$what." = '".$Ids."'");

if($dbLink->numOfRows()!=1){
    die("ERROR: No exists!");
}

$primaryResult = $dbLink->getResults();

$dbLink->sql("SELECT filtr_id FROM ".$table2." WHERE ".$what." = '".$Ids."'");

$numberOfRelations=$dbLink->numOfRows();

$secResult = $dbLink->getResults();

$zapisane = array();

for($index=0; $index<$numberOfRelations; $index++){
    $zapisane[] = $secResult[$index]['filtr_id'];
}
    

$dateux=date("U");

$usunac=array();
$dodac=array();

for($idx=0; $idx<count($incoming); $idx++){
    $val=$incoming[$idx];
    if(!is_numeric($val)) continue;
    if(in_array($val,$zapisane)) continue;
    $dodac[]=$val;
}
 
for($idx=0; $idx<count($zapisane); $idx++){
    $val=$zapisane[$idx];
    if(!is_numeric($val)) continue;
    
    if(in_array($val,$incoming)) continue;
    $usunac[]=$val;
}

foreach($dodac as $key => $val){
    $val = intval($val);
    if($_POST['action']=='lang'){
        $dbLink->deleteSql("DELETE FROM ".$table2." WHERE filtr_id = '".$val."'");
        $dbLink->insertSql("INSERT INTO ".$table2." VALUES (NULL, '".$Ids."', '".$val."');");
    } else {
        $dbLink->insertSql("INSERT INTO ".$table2." VALUES (NULL, '".$val."', '".$Ids."');");        
    }
}

foreach($usunac as $key => $val){
    $val = intval($val);
    $dbLink->deleteSql("DELETE FROM ".$table2." WHERE ".$what." = '".$Ids."' AND filtr_id = '".$val."'");
    
    if($_POST['action']=='lang'){
        $dbLink->sql("SELECT * FROM ".$table2." WHERE filtr_id = '".intval($val)."'");

        if($dbLink->numOfRows()==0){
            $dbLink->insertSql("INSERT INTO ".$table2." VALUES (NULL, '0', '".$val."');");        
        }
    }

}


header('Content-Type: application/json');
// keep lang unique
echo "{}";
?>