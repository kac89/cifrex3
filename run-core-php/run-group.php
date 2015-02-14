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
include './../include/general/debug.php';

// create link to database
$dbLink = new dbEngine($cconfig['db_config']);

// create error handler
error_reporting(E_ALL);

if(!isset($_POST['group_id']) OR !is_numeric($_POST['group_id'])) die("lang?"); else $groupIds=intval($_POST['group_id']); 
if(isset($_POST['execLog']) AND $_POST['execLog']=='True') $saveLog=true; else $saveLog=false;
if(isset($_POST['printOutput']) AND $_POST['printOutput']=='True') $printOutput=true; else $printOutput=false;
if(isset($_POST['toDb']) AND $_POST['toDb']=='True') $writeToDb=true; else $writeToDb=false;
if(isset($_POST['resultName']) AND !empty($_POST['resultName'])) $resultName=$_POST['resultName']; else $resultName='Generic';
if(isset($_POST['credit']) AND !empty($_POST['credit'])) $credit=$_POST['credit']; else $credit='Anonymous';
if(isset($_POST['email']) AND !empty($_POST['email'])) $email=$_POST['email']; else $email='';

// create debug handler {string,standard}
$log = new debugMe($printOutput ? 'standard' : 'string');

// response type
header('Content-Type: application/json');

// start it baby
if(isset($_POST['trythispatterns'])){

    $dateO = date("D M j G:i:s T Y");
    
    $katalog='';
    if(isset($_POST['katalog'])){
        $katalog = $_POST['katalog'];
    }
    
    // Initial Directory 
    if(!empty($_GET['katalog']) AND 0>=strncmp($cconfig['core']['internal_openbasedir'], $_POST['katalog'], strlen($cconfig['core']['internal_openbasedir']))) $katalog=$_GET['katalog']; 
    elseif(!empty($_POST['katalog']) AND 0>=strncmp($cconfig['core']['internal_openbasedir'], $_POST['katalog'], strlen($cconfig['core']['internal_openbasedir']))) $katalog=$_POST['katalog']; 
    else die("Ups. Specified directory outside internal openbasedir ".htmlspecialchars($cconfig['db_config']['internal_openbasedir']));

    $katalog=str_replace("../","/",str_replace("/..","/",$katalog));

    $Ids=intval($_POST['group_id']);

    $dbLink->sql("SELECT f.filtr_id as filtr_id, f.name as filtr_name, f.description as filtr_description, f.wlb as filtr_wlb, f.filtr as filtr_filtr, l.custom_files FROM cifrex_relation_fil_gro as d, cifrex_groups as l, cifrex_filters as f WHERE d.group_id=l.group_id AND d.filtr_id = f.filtr_id AND l.group_id = '".$groupIds."'");

    $countt = $dbLink->numOfRows();
    
    if($countt<1){
        die("ERROR: No exists!");
    }
    
    $primaryResult = $dbLink->getResults();

    $log->add("===========================================");
    $log->add("cIFrex Group Scan Result ( ".$dateO." )");
    $log->add("===========================================");
    $log->add("Name: ".$resultName."");
    $log->add("Dir: ".$katalog."");
    $log->add("Group_id: ".intval($_POST['group_id'])."");
    $log->add("Started by: ".$credit."");
    if(isset($primaryResult[0]['custom_files']))
    $log->add("\nFiles: ".$primaryResult[0]['custom_files']."");
    $log->add("Directory: ".$katalog."");
    $log->add("===========================================");
    
    for($index = 0; $index < $countt; $index++){
        $log->add("\n=== Filtr (".($index+1)."/".$countt.") ====================");
        $log->add("\nFiltr Name: ".$primaryResult[$index]['filtr_name']."");
        if(!empty($primaryResult[$index]['filtr_description']))
        $log->add("Filtr Description: ".$primaryResult[$index]['filtr_description']."");
        $log->add("Filtr URL: ".$url_config."database.php?q=".urlencode($primaryResult[$index]['filtr_name'])."");
        
        $log->add("\nResult: ".$url_config."schedule.php?q=".urlencode($_POST['resultName']." (".($primaryResult[$index]['filtr_name']).""));
        if(!empty($primaryResult[$index]['filtr_wlb']))
        $log->add("\nSee on cxsecurity: http://cxsecurity.com/issue/".$primaryResult[$index]['filtr_wlb']."");
        
        $patty = json_decode($primaryResult[$index]['filtr_filtr'], true);
        $data=array('toDb'=>$_POST['toDb'],
                   'execLog'=>$_POST['execLog'],
                   'katalog'=>$katalog,
                   'files'=>$primaryResult[$index]['custom_files'],
                   'value1'=>base64_encode($patty['v1']),
                   'value2'=>base64_encode($patty['v2']),
                   'value3'=>base64_encode($patty['v3']),
                   'true1'=>base64_encode($patty['t1']),
                   'true2'=>base64_encode($patty['t2']),
                   'true3'=>base64_encode($patty['v3']),
                   'false1'=>base64_encode($patty['f1']),
                   'false2'=>base64_encode($patty['f2']),
                   'false3'=>base64_encode($patty['f3']),
                   'resultName'=>$_POST['resultName']." (".$primaryResult[$index]['filtr_name'].") [".($index+1)."/".$countt."]",
                   'email'=>'',// or you can set $_POST['email']
                   'credit'=>$_POST['credit'],
                   'printOutput'=>'False',
                   'trythispatterns'=>'Start Lang'
                   );
        $data=http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_config."run-core-php/search.php");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        curl_exec($ch);
        $info = curl_getinfo($ch);

        $log->add("\nTime: " . $info['total_time'] . " seconds");
        
        $log->add("\nURL: ".$info['url']." ( Status: ".$info['http_code']." )");
        $log->add("POST: ".$data."");
        $log->add("\n===========================================");

        flush();

    }
    $log->add("\n==================== Finished! =======================");
    $log->add("\nSee all results:");
    $log->add("\n".$url_config."schedule.php?q=".urlencode($_POST['resultName']." ("));
    $log->add("\n=========================================================\n");
     
    if(!empty($email)){
        $subject = "[GroupScan] ".$resultName." (".$dateO.")";
        $header = "From: ". $cconfig['mail']['Name'] . " <" . $cconfig['mail']['email'] . ">\r\n";
        
        echo "Email sent?";
        var_dump(mail($email, $subject, $log->printOut(), $header));
    }
}

?>